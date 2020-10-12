<?php

namespace app\api\controller;

use app\xcx\model\Loops;
use app\xcx\model\Msgs;
use app\xcx\model\Subscp;
use think\Controller;
use think\Db;
use think\Image;
use think\Loader;
use think\Log;

class Msg extends Controller
{
    /**
     * 发送验证码
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function checkMsg()
    {
        $message = Db::table('xcx_msg_content')->field('xcx_msg_mp_id, xcx_msg_add_time, xcx_msg_uid,xcx_msg_content,xcx_msg_ul_id')
            ->where(['xcx_msg_isread' => 2, 'xcx_msg_isable' => 1])
            ->group('xcx_msg_mp_id')->order('xcx_msg_id asc')->select();
        dump($message);
        if (!$message) {
            return 1;
        }
        //设置时区问题
        date_default_timezone_set("Australia/Melbourne");
        $time = time();

        $date = date('Y-m-d H:i:s', time());
        foreach ($message as $key => $val) {
            $diff_num = $time - strtotime($val['xcx_msg_add_time']);
            //dump($val['xcx_msg_add_time'].'-'.$date);
            if ($diff_num <= 300) {
                continue;
            }
            $users = Db::table('xcx_msg_person')
                ->field('mp_id,mp_u_id, mp_ul_id,mp_utype,mp_ultype')
                ->where('mp_id', '=', $val['xcx_msg_mp_id'])
                ->where('mp_isable = 1')
                ->find();
            dump($users);
            if (!$users) {
                continue;
            }
            //会话发起者 等于 消息发送者 发送未读提醒给 消息接受者
            if ($users['mp_u_id'] == $val['xcx_msg_uid']) {
                //如果消息接受者类型为后端用户
                if ($users['mp_ultype'] == 2) {
                    dump('会话发起者等于消息发送者发送未读提醒给消息接受者,消息接受者类型为后端用户adminid=' . $users['mp_ul_id']);
                    //  $this->sendNotAdminMsg($users['mp_ul_id']);
                } else {
                    //消息接受者为前端用户
                    dump('会话发起者等于消息发送者发送未读提醒给消息接受者,消息接受者为前端用户userid=' . $users['mp_ul_id']);
                    //  $this->sendNotMsg($users['mp_ul_id']);
                }
            } else {
                //会话的接受者 等于 消息发送者  发送未读提醒给 消息发起者
                //如果消息发起者为后端用户
                if ($users['mp_utype'] == 2) {
                    dump('会话的接受者 等于 消息发送者  发送未读提醒给 消息发起者,消息发起者为后端用户adminid=' . $users['mp_u_id']);
                    //  $this->sendNotAdminMsg($users['mp_u_id']);
                } else if ($users['mp_ultype'] == 2) {
                    dump('会话的接受者 bu等于 消息发送者  发送未读提醒给 消息发起者,消息发起者为后端用户adminid=' . $users['mp_ul_id']);
                    //  $this->sendNotAdminMsg($users['mp_ul_id']);
                } else {
                    dump('会话的接受者 等于 消息发送者  发送未读提醒给 消息发起者,消息发起者为q前端用户userid=' . $users['mp_u_id']);
                    //   $this->sendNotMsg($users['mp_u_id']);
                }

            }
        }
        return 2;
    }

    public function checkMsgs()
    {
        $message = Db::table('xcx_msg_content')
            ->where(['xcx_msg_isread' => 2, 'xcx_msg_isable' => 1])
            ->group('xcx_msg_mp_id')->order('xcx_msg_id asc')->select();

        if (!$message) {
            return 1;
        }
        //设置时区问题
        date_default_timezone_set("Australia/Melbourne");
        $time = time();
        foreach ($message as $key => $val) {
            $msgFidIsdel = $this->msgIsDel($val['xcx_msg_mp_id']);
            $diff_num = $time - strtotime($val['xcx_msg_add_time']);
            //1. 收到新消息的提醒时间--1分钟
            if ($diff_num <= 60) {
                continue;
            }
            //4. 超过3天的未读消息，自动变为已读；
            $this->netDate($val['xcx_msg_add_time'], $val['xcx_msg_id']);
            if ($msgFidIsdel == 1) {
                if ($val['xcx_msg_ul_type'] == 1) {
                    //dump('前端用户userid='.$val['xcx_msg_ul_id']);
                    //消息接受者为前端用户的话，发送订阅消息提醒
                    $sendId = $val['xcx_msg_uid'];
                    $sendType = $val['xcx_msg_u_type'];
                    $sendTime = $val['xcx_msg_add_time'];
                    $msgId = $val['xcx_msg_id'];
                    $revid = $val['xcx_msg_ul_id'];
                    $this->sendSubscp($sendId, $sendType, $sendTime, $msgId, $revid);
                    //发送短信
                    $this->sendNotMsg($val['xcx_msg_ul_id']);
                } else {
                    //dump('后端用户adminid='.$val['xcx_msg_ul_id']);
                    //发送短信
                    $this->sendNotAdminMsg($val['xcx_msg_ul_id']);
                }
            }
        }
        return 2;
    }

    public function netDate($date, $id)
    {
        $data = date("Y-m-d H:i:s", strtotime($date . ' +3 days'));
        $today = date("Y-m-d H:i:s");
        if ($today < $data) {
            Db::table('xcx_msg_content')
                ->where(['xcx_msg_id' => $id])
                ->update(['xcx_msg_isread' => 1]);
        }
    }

    /***
     * @param $sendId string 发送者id 用来查找发送人昵称
     * @param $sendType  string 发送者类型
     * @param $sendTime string 消息的发送时间
     * @param $msgId string 消息id
     * @param $revid string 消息接受者id 只有小程序用户才能接收订阅消息
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException3
     */
    public function sendSubscp($sendId, $sendType, $sendTime, $msgId, $revid)
    {
        //当天是否已经给该用户推送过订阅消息
        $isSendToday = $this->isSendToday($revid);
        if (!$isSendToday) {
            //订阅消息预发送
            $data['ss_msg_id'] = $msgId;
            $data['ss_status'] = 1;
            $data['ss_user_id'] = $revid;
            $data['ss_send_time'] = date('Y-m-d H:i:s');
            $data['ss_send_date'] = date('Y-m-d');
            $data['ss_remarks'] = '1.订阅消息预发送；';
            $logId = Db::table('xcx_sub_msg')->insertGetId($data);
            $receive = $this->getRevStatus($revid);
            if (!$receive) {
                //无此用户信息
                Db::table('xcx_sub_msg')
                    ->where(['ss_id' => $logId])
                    ->update([
                        'ss_status' => 3,
                        'ss_remarks' => $data['ss_remarks'] . '2.发送失败：无此用户信息；',
                    ]);

            }
            if ($receive['able_sub'] <= 0) {
                //用户拒绝接收消息
                Db::table('xcx_sub_msg')
                    ->where(['ss_id' => $logId])
                    ->update([
                        'ss_status' => 3,
                        'ss_remarks' => $data['ss_remarks'] . '2.发送失败：用户未授权订阅消息；',
                    ]);
            }
            $uOpen = $receive['openid'];
            $sender = $this->getSenderNick($sendId, $sendType);
            $send = new Subscp();
            $sendSub = $send->sendMessage($sender, $uOpen, $sendTime);
            $res = json_decode($sendSub, true);
            if ($res['errcode'] == 0) {
                //发送成功
                Db::table('xcx_sub_msg')
                    ->where(['ss_id' => $logId])
                    ->update([
                        'ss_status' => 2,
                        'ss_remarks' => $data['ss_remarks'] . '2.发送成功：已发送订阅消息到用户手机。',
                    ]);
                //减少一次消息通知2020年9月28日11:27:17
                Db::table('tk_user')
                    ->where(['openid' => $uOpen])
                    ->setDec('able_sub');
            } else {
                //发送失败
                Db::table('xcx_sub_msg')
                    ->where(['ss_id' => $logId])
                    ->update([
                        'ss_status' => 3,
                        'ss_remarks' => $data['ss_remarks'] . '2.发送失败：微信服务端未发送成功。',
                    ]);
            }
        }
    }

    public function isSendToday($revid)
    {
        $date = date('Y-m-d');
        $isSend = Db::table('xcx_sub_msg')
            ->where(['ss_user_id' => $revid, 'ss_send_date' => $date])
            ->field('ss_id')
            ->find();
        return $isSend ? true : false;
    }

    public function ack()
    {
        $send = new Subscp();
        $res = $send->getAckToken();
    }

    /***
     * @param $revid string 消息接收者id
     * @return array|bool|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getRevStatus($revid)
    {
        $sender = Db::table('tk_user')
            ->where(['id' => $revid])
            ->field('able_sub,openid')
            ->find();
        return $sender ? $sender : false;

    }

    public function getSenderNick($sendId, $sendType)
    {
        if ($sendType == 1) {
            $sender = Db::table('tk_user')
                ->where(['id' => $sendId])
                ->field('nickname')
                ->find();
            return $sender ? $sender['nickname'] : '小程序未知用户';
        } else {
            $sender = Db::table('super_admin')
                ->where(['ad_id' => $sendId])
                ->field('ad_realname')
                ->find();
            return $sender ? $sender['ad_realname'] : '小程序未知用户';
        }
    }


    public function msgIsDel($mpid)
    {
        $msg = Db::table('xcx_msg_person')->where(['mp_id' => $mpid])->field('mp_isable')->find();
        return $msg['mp_isable'];
    }

    //前端用户发送消息
    private function sendNotMsg($uid)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://www.huaxiangxiaobao.com/api/msg/sendNot?id=' . $uid);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($curl);
        curl_close($curl);
    }


    //后台用户发送消息
    public function sendNotAdminMsg($uid)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://www.huaxiangxiaobao.com/api/msg/sendNotAdmin?id=' . $uid);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($curl);
        curl_close($curl);
    }

    /****
     * 1.创建会话
     * @return \think\response\Json
     */
    public function touch()
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        //发起者id
        $uId = intval(trim($this->request->param('uid')));
        //接受者id
        $ulId = intval(trim($this->request->param('ulid')));
        $hId = intval(trim($this->request->param('hid')));
        Log::write('发起会话请求参数：uid=' . $uId . ',$ulId=' . $ulId . ',$hId=' . $hId, 'info');
        if (!$uId || !$ulId) {
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        $msgm = new Msgs();
        $createTouch = $msgm->createTouch($uId, $ulId, $hId);
        if ($createTouch) {
            $res['code'] = 1;
            $res['msg'] = '创建成功！';
            $res['id'] = $createTouch;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '创建失败！';
        $res['id'] = $createTouch;
        return json($res);
    }


    /***
     * 2.获取会话列表
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getMsgList()
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid')));
        if (!$uId) {
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        //检测该用户是否绑定后端平台用户
        $where = "(mp_u_id = " . $uId . " and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = " . $uId . " and mp_ultype = 1 and  mp_isable = 1)";
        $isBindAdmin = $this->isBindAdmin($uId);
        //用户新消息提醒次数
        $remindCount = Db::table('tk_user')->where(['id' =>$uId])->field('able_sub')->find();
        $remindCount = $remindCount['able_sub'];
        $msg = new Loops();
        if ($isBindAdmin) {
            $adId = intval($isBindAdmin['ad_id']);
            $where .= " or (mp_u_id = " . $adId . " and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = " . $adId . " and mp_ultype = 2 and  mp_isable = 1)";
            $list = Db::table('xcx_msg_person')
                ->where($where)
                ->order('mp_mod_time desc')
                ->select();
            //dump($list);
            foreach ($list as $k => $v) {
                if ($v['mp_ul_id'] == $adId && $v['mp_ultype'] == 2 && $v['mp_utype'] == 1) {
                    $list[$k]['nickname'] = $msg->getUserNick($v['mp_u_id']);
                    $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_u_id']);
                }
                if ($v['mp_ul_id'] == $adId && $v['mp_ultype'] == 2 && $v['mp_utype'] == 2) {
                    $list[$k]['nickname'] = $msg->getAdminNick($v['mp_u_id']);
                    $list[$k]['avaurl'] = $msg->getAdminAvatar($v['mp_u_id']);
                }
                if ($v['mp_ul_id'] == $uId && $v['mp_utype'] == 1 && $v['mp_ultype'] == 1) {
                    $list[$k]['nickname'] = $msg->getUserNick($v['mp_u_id']);
                    $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_u_id']);
                }
                if ($v['mp_u_id'] == $adId && $v['mp_utype'] == 2 && $v['mp_ultype'] == 1) {
                    $list[$k]['nickname'] = $msg->getUserNick($v['mp_ul_id']);
                    $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_ul_id']);
                }
                if ($v['mp_u_id'] == $uId && $v['mp_utype'] == 1 && $v['mp_ultype'] == 2) {
                    $list[$k]['nickname'] = $msg->getAdminNick($v['mp_ul_id']);
                    $list[$k]['avaurl'] = $msg->getAdminAvatar($v['mp_ul_id']);
                }
                if ($v['mp_u_id'] == $uId && $v['mp_utype'] == 1 && $v['mp_ultype'] == 1) {
                    $list[$k]['nickname'] = $msg->getUserNick($v['mp_ul_id']);
                    $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_ul_id']);
                }
                if ($v['mp_ul_id'] == $uId && $v['mp_utype'] == 2 && $v['mp_ultype'] == 1) {
                    $list[$k]['nickname'] = $msg->getAdminNick($v['mp_u_id']);
                    $list[$k]['avaurl'] = $msg->getAdminAvatar($v['mp_u_id']);
                }
                $list[$k]['count'] = $msg->getUnread($v['mp_id'], $uId);
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功1！';
            $res['data'] = $list;
            $res['remind'] = $remindCount;
            return json($res);
        } else {
            //没有绑定后端平台用户
            $list = Db::table('xcx_msg_person')
                ->where($where)
                ->order('mp_mod_time desc')
                ->select();
            if ($list) {
                foreach ($list as $k => $v) {
                    //消息发送人是我自己
                    if ($list[$k]['mp_u_id'] == $uId) {
                        if ($v['mp_utype'] == 1 && $v['mp_ultype'] == 2) {
                            $list[$k]['nickname'] = $msg->getAdminNick($v['mp_ul_id']);
                            $list[$k]['avaurl'] = $msg->getAdminAvatar($v['mp_ul_id']);
                            $list[$k]['count'] = $this->getUnread2($v['mp_id'], $uId);
                        }
                        if ($v['mp_utype'] == 1 && $v['mp_ultype'] == 1) {
                            $list[$k]['nickname'] = $msg->getUserNick($v['mp_ul_id']);
                            $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_ul_id']);
                            $list[$k]['count'] = $this->getUnread2($v['mp_id'], $uId);
                        }
                    }
                    //消息接收人是我自己
                    if ($list[$k]['mp_ul_id'] == $uId) {
                        if ($v['mp_utype'] == 2 && $v['mp_ultype'] == 1) {
                            $list[$k]['nickname'] = $msg->getAdminNick($v['mp_u_id']);
                            $list[$k]['avaurl'] = $msg->getAdminAvatar($v['mp_u_id']);
                            $list[$k]['count'] = $this->getUnread1($v['mp_id'], $uId);
                        }
                        if ($v['mp_utype'] == 1 && $v['mp_ultype'] == 1) {
                            $list[$k]['nickname'] = $msg->getUserNick($v['mp_u_id']);
                            $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_u_id']);
                            $list[$k]['count'] = $this->getUnread1($v['mp_id'], $uId);
                        }
                    }
                }
                $res['code'] = 1;
                $res['msg'] = '读取成功2！';
                $res['data'] = $list;
                $res['remind'] = $remindCount;
                return json($res);
            }
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = null;
        $res['remind'] = $remindCount;
        return json($res);
    }

    public function getUnread1($mpId, $uid)
    {
        $readWhere = 'xcx_msg_ul_id = ' . $uid;
        $unRead = Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpId, 'xcx_msg_isread' => 2, 'xcx_msg_isable' => 1])
            ->where($readWhere)
            ->count('xcx_msg_id');
        return $unRead ? $unRead : 0;
    }

    public function getUnread2($mpId, $uid)
    {
        $readWhere = 'xcx_msg_uid != ' . $uid;
        $unRead = Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpId, 'xcx_msg_isread' => 2, 'xcx_msg_isable' => 1])
            ->where($readWhere)
            ->count('xcx_msg_id');
        return $unRead ? $unRead : 0;
    }

    /***
     * 当前小程序用户是否绑定后端用户
     * @param $uid
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function isBindAdmin($uid)
    {
        $isBind = Db::table('super_admin')->where(['ad_wechat' => $uid])->field('ad_id')->find();
        return $isBind ? $isBind : null;
    }

    public function unRead2()
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid')));
        if (!$uId) {
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        //检测该用户是否绑定后端平台用户
        $where = "(mp_u_id = " . $uId . " and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = " . $uId . " and mp_ultype = 1 and  mp_isable = 1)";
        $isBindAdmin = $this->isBindAdmin($uId);
        $msg = new Loops();
        if ($isBindAdmin) {
            $adId = intval($isBindAdmin['ad_id']);
            $where .= " or (mp_u_id = " . $adId . " and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = " . $adId . " and mp_ultype = 2 and  mp_isable = 1)";
            $list = Db::table('xcx_msg_person')
                ->where($where)
                ->order('mp_mod_time desc')
                ->select();
            $count = 0;
            foreach ($list as $k => $v) {
                $count = $msg->getUnread($v['mp_id'], $uId);
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功1！';
            $res['count'] = $count;
            return json($res);
        } else {
            //没有绑定后端平台用户
            $list = Db::table('xcx_msg_person')
                ->where($where)
                ->order('mp_mod_time desc')
                ->select();
            $count = 0;
            if ($list) {
                foreach ($list as $k => $v) {
                    //消息发送人是我自己
                    if ($list[$k]['mp_u_id'] == $uId) {
                        if ($v['mp_utype'] == 1 && $v['mp_ultype'] == 2) {
                            $count += $this->getUnread2($v['mp_id'], $uId);
                        }
                        if ($v['mp_utype'] == 1 && $v['mp_ultype'] == 1) {
                            $count += $this->getUnread2($v['mp_id'], $uId);
                        }
                    }
                    //消息接收人是我自己
                    if ($list[$k]['mp_ul_id'] == $uId) {
                        if ($v['mp_utype'] == 2 && $v['mp_ultype'] == 1) {
                            $count += $this->getUnread1($v['mp_id'], $uId);
                        }
                        if ($v['mp_utype'] == 1 && $v['mp_ultype'] == 1) {
                            $count += $this->getUnread1($v['mp_id'], $uId);
                        }
                    }
                }
                $res['code'] = 1;
                $res['msg'] = '读取成功2！';
                $res['count'] = $count;
                return json($res);
            }
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['count'] = 0;
        return json($res);
    }


    public function unRead()
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid')));
        $where = "(mp_u_id = " . $uId . " and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = " . $uId . " and mp_ultype = 1 and  mp_isable = 1)";
        $isBindAdmin = $this->isBindAdmin($uId);
        if ($isBindAdmin) {
            $adId = intval($isBindAdmin['ad_id']);
            $where .= " or (mp_u_id = " . $adId . " and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = " . $adId . " and mp_ultype = 2 and  mp_isable = 1)";
        }
        $list = Db::table('xcx_msg_person')
            ->where($where)
            ->field('mp_id')
            ->select();
        if ($list) {
            $msg = new Loops();
            $count = 0;
            foreach ($list as $k => $v) {
                $count += $msg->getUnread($v['mp_id'], $uId);
            }
            $res['code'] = 1;
            $res['msg'] = '获取成功！';
            $res['count'] = $count;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '获取成功！';
        $res['count'] = 0;
        return json($res);
    }


    /***
     * 3.发送消息
     * @return \think\response\Json
     */
    public function sendMsg()
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        //发送人id
        $mpid = intval(trim($this->request->param('mpid')));
        //会话id
        $uId = intval(trim($this->request->param('uid')));
        //type 消息类型 1.文本消息 2 图片消息
        $type = intval(trim($this->request->param('type',1)));
        //会话内容
        //消息接受者信息
        $ulInfo = $this->getUlidAndType($mpid, $uId);
        $content = trim($this->request->param('content'));
        if (!$mpid || !$uId) {
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        if (!$content) {
            $res['code'] = 0;
            $res['msg'] = '发送内容不能为空！';
            return json($res);
        }
        Log::write("消息类型type=".$type."&contents=".$content, 'info');
        $data['xcx_msg_mp_id'] = $mpid;
        $data['xcx_msg_uid'] = $uId;
        $data['xcx_msg_ul_id'] = $ulInfo['ul_id'];
        $data['xcx_msg_ul_type'] = $ulInfo['ul_type'];
        //后端发送
        $data['xcx_msg_u_type'] = 1;
        $data['xcx_msg_type'] = $type;
        $data['xcx_msg_content'] = $content;
        $data['xcx_msg_hid'] = $ulInfo['hid'];
        date_default_timezone_set("Australia/Melbourne");
        $data['xcx_msg_add_time'] = date('Y-m-d H:i:s');
        $datas['mp_mod_time'] = date('Y-m-d H:i:s');
        $sendMsg = Db::table('xcx_msg_content')->insertGetId($data);
        //转发邮件 前端用户不发送邮件
        if($ulInfo['ul_type'] == 2){
            $hid = $ulInfo['hid'];
            $address = $this->getHouseAdd($hid);
            $address = $address['street']."  ".$address['address']."  ".$address['dsn'];
            $content = $this->getEmailsContent($type,$content);
            //查看当前消息是否为该房源该回话的第一条消息
            $isFrist = $this->isFristMsg($mpid,$ulInfo['hid']);
            Log::write('消息条数：$isFrist=' . $isFrist."房源ID=".$ulInfo['hid']."&contents=".$content, 'info');
            $isRe = $isFrist > 1 ? 1 : 2;
            $this->sendEmail($mpid, $uId, $ulInfo['ul_id'], $content,$address,$isRe);
        }
        //更新会话修改时间
        Db::table('xcx_msg_person')->where(['mp_id' => $mpid])->update($datas);
        if ($sendMsg) {
            $res['code'] = 1;
            $res['msg'] = '发送成功！';
            $res['id'] = $sendMsg;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '发送失败！';
        $res['id'] = $sendMsg;
        return json($res);
    }
    
    
    public function isFristMsg($mpid,$hid){
        $count = Db::table('xcx_msg_content')
        ->where(['xcx_msg_mp_id' => $mpid,'xcx_msg_hid' => $hid,'xcx_msg_isable' => 1])
        ->count('xcx_msg_id');
        return $count;
    }
    
    public function getEmailsContent($type,$content){
         if($type == 1){
           return  $content;
        }else{
            $str = "<img src='https://".$_SERVER['SERVER_NAME']."/".$content."' style='width:230px;height:230px'/>";
            return $str; 
        }
    }


    public function getHouseAdd($hid){
        $houseInfo = Db::table('tk_houses')
            ->where(['id' => $hid])
            ->field('address,street,dsn')
            ->find();
        return $houseInfo ? $houseInfo : '';
    }


    /***
     * 邮件回复消息转发到站内信
     * @param $mpid  int 会话id
     * @param $uId int 用户id
     * @param $content string 消息内容
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function forwardToMsg($mpid, $uId, $content)
    {
        Log::write('邮件回复消息转发到站内信：uid=' . $uId . ',$mpid=' . $mpid, 'info');
        $ulInfo = $this->getUlidAndType($mpid, $uId);
        if (!$mpid || !$uId) {
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        if (!$content) {
            $res['code'] = 0;
            $res['msg'] = '发送内容不能为空！';
            return json($res);
        }
        date_default_timezone_set("Australia/Melbourne");
        $data['xcx_msg_mp_id'] = $mpid;
        $data['xcx_msg_uid'] = $uId;
        $data['xcx_msg_ul_id'] = $ulInfo['ul_id'];
        $data['xcx_msg_ul_type'] = $ulInfo['ul_type'];
        //后端发送
        $data['xcx_msg_u_type'] = 1;
        $data['xcx_msg_content'] = $content;
        $data['xcx_msg_hid'] = $ulInfo['hid'];
        $data['xcx_msg_add_time'] = date('Y-m-d H:i:s');
        foreach($content as $key => $val){
            
            $data['xcx_msg_type'] = $val['type'];
            $content = $this->getMsgContent($val['type'],$val['msg']);
            $data['xcx_msg_content'] =  $content;
            $sendMsg = Db::table('xcx_msg_content')->insertGetId($data);
            Log::write('转发到站内信：type=' . $val['type'] . ',xcx_msg_content=' . $content, 'info');
        }
        $datas['mp_mod_time'] = date('Y-m-d H:i:s');
       
        //更新会话修改时间
        //转发邮件 前端用户不发送邮件
        if($ulInfo['ul_type'] == 2){
            $hid = $ulInfo['hid'];
            if($hid != 0){
                $address = $this->getHouseAdd($hid);
                $address = $address['street']."  ".$address['address']."and 房源ID：".$address['dsn'];
                 //查看当前消息是否为该房源该回话的第一条消息
                $isFrist = $this->isFristMsg($mpid,$ulInfo['hid']);
                 Log::write('消息条数：$isFrist=' . $isFrist."房源ID=".$ulInfo['hid'], 'info');
                $isRe = $isFrist > 1 ? 1 : 2;
                $this->sendEmail($mpid, $uId, $ulInfo['ul_id'], $content,$address,1);
            }
        }
        Db::table('xcx_msg_person')->where(['mp_id' => $mpid])->update($datas);
        if ($sendMsg) {
            $res['code'] = 1;
            $res['msg'] = '发送成功！';
            $res['id'] = $sendMsg;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '发送失败！';
        $res['id'] = $sendMsg;
        return json($res);
    }
    
    
    
    public function getMsgContent($type,$image){
        if($type == 1){
           return  $image;
        }else{
            $imageName = "msg".date("His",time())."_".rand(1111,9999).'.png';
            if (strstr($image,",")){
                $image = explode(',',$image);
                $image = $image[1];
            }
    
            $path = "uploads/msgimg/".date("Ymd",time());
            if (!is_dir($path)){ //判断目录是否存在 不存在就创建
                mkdir($path,0777,true);
            }
            $imageSrc=  $path."/". $imageName;  //图片名字
            $r = file_put_contents(ROOT_PATH ."public/".$imageSrc, base64_decode($image));//返回的是字节数
            return $imageSrc; 
        }
        
    }
    
    
    

    //邮件转发
    public function sendEmail($mpid, $uId, $ulId, $content,$title,$type)
    {
        $loop = new Loops();
        $fromName = $loop->getUserNick($uId);
        $fromName = json_decode($this->removeEmoji($fromName));
        $pre = $type == 1? 'Re:':'';
        Log::write($pre.'New enquiry from '.$fromName.' via Welhome', 'info');
        $subject = $pre.'New enquiry from '.$fromName.' via Welhome';
        $emails = new Mailer();
        $content=$content."<br/> <br/> <br/> for address:【".$title."】";
        //根据消息id和发送者id判断接收人姓名和邮箱
        $user = $this->getUlInfo($mpid, $uId);
        Log::write('邮件转发：uid=' . $uId . ',$mpid=' . $mpid . ',$content=' . $content, 'info');
        if(isset($user['email']) && !empty($user['email']) && $user['email']){
            $emails->sendEmail($user['email'], $user['unickname'], $mpid, $ulId, $fromName, $subject, $content);
        }else{
            Log::write('邮件转发[用户未绑定邮箱]：uid=' . $uId . ',$mpid=' . $mpid . ',$content=' . $content, 'info');
        }

    }

    public function getUlidAndType($mpid, $uId)
    {
        $ulInfo = Db::table('xcx_msg_person')->where(['mp_id' => $mpid])->find();
        if ($ulInfo['mp_u_id'] == $uId) {
            $res['ul_id'] = $ulInfo['mp_ul_id'];
            $res['ul_type'] = $ulInfo['mp_ultype'];
            $res['hid'] = $ulInfo['mp_hid'];
        } else {
            $res['ul_id'] = $ulInfo['mp_u_id'];
            $res['ul_type'] = $ulInfo['mp_utype'];
            $res['hid'] = $ulInfo['mp_hid'];
        }
        return $res;
    }

    /***
     * 获取消息会话内容
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function getMsg()
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        //会话id
        $uid = intval(trim($this->request->param('uid')));
        $mpid = intval(trim($this->request->param('mpid')));
        $isbend = $this->isBindAdmin($uid);
        //获取消息的发送方
        $ulInfo = $this->getUlInfo($mpid, $uid);
        $page = trim($this->request->param('page', '0'));
        $limit = 100;
        if (!$mpid && $uid) {
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        $bindId = $isbend['ad_id'];
        //更新已读状态
        if ($isbend) {
            $readWhere = '( xcx_msg_uid != ' . $uid . ' and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != ' . $bindId . ' and  xcx_msg_u_type = 2 )';
        } else {
            $readWhere = '( xcx_msg_u_type = 1 and  xcx_msg_uid != ' . $uid . ' ) or ( xcx_msg_ul_type = 1 and  xcx_msg_ul_id != ' . $uid . ') ';
        }
        Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpid, 'xcx_msg_isable' => 1])
            ->where($readWhere)
            ->update(['xcx_msg_isread' => 1]);
        $msgList = Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpid, 'xcx_msg_isable' => 1])
            ->order('xcx_msg_add_time')
            ->limit($limit, $page)
            ->select();
        if ($msgList) {
            if ($isbend) {
                $bindId = $isbend['ad_id'];
                foreach ($msgList as $k => $v) {
                    if ($v['xcx_msg_uid'] == $bindId) {
                        $msgList[$k]['xcx_msg_uid'] = $uid;
                    }
                    if ($v['xcx_msg_uid'] == $uid) {
                        $msgList[$k]['xcx_msg_uid'] = $uid;
                    }
                    if($v['xcx_msg_type'] == 2){
                        $msgList[$k]['xcx_msg_content'] = "https://".$_SERVER['SERVER_NAME']."/".$v['xcx_msg_content'];
                    }
                }
            } else {
                foreach ($msgList as $k => $v) {
                    if ($v['xcx_msg_ul_id'] == $uid) {
                        Db::table('xcx_msg_content')
                            ->where(['xcx_msg_mp_id' => $mpid, 'xcx_msg_isable' => 1, 'xcx_msg_ul_id' => $uid])
                            ->update(['xcx_msg_isread' => 1]);
                    
                    }
                    if($v['xcx_msg_type'] == 2){
                        $msgList[$k]['xcx_msg_content'] = "https://".$_SERVER['SERVER_NAME']."/".$v['xcx_msg_content'];
                    }
                }
            }

            $msg = new Loops();
            $user['unickname'] = $ulInfo['unickname'];
            $user['uavaurl'] = $ulInfo['uavaurl'];
            $user['inickname'] = $msg->getUserNick($uid);
            $user['iavaurl'] = $msg->getUserAvatar($uid);
            $hid = Db::table('xcx_msg_person')
                ->where(['mp_id' => $mpid])
                ->column('mp_hid');
            $field = 'id,type,title,house_room,price,toilet,car,house_type';
            $houses = Db::table('tk_houses')
                ->where(['id' => $hid[0]])
                ->field($field)
                ->find();
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $msgList;
            $res['user'] = $user;
            $res['house'] = $houses;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空';
        $res['data'] = null;
        $res['user'] = null;
        $res['house'] = null;
        return json($res);

    }


    public function getUlInfo($mpid, $uId)
    {
        //查询当前小程序用户是否绑定admin用户
        $isbend = $this->isBindAdmin($uId);
        $ulInfo = Db::table('xcx_msg_person')->where(['mp_id' => $mpid])->find();
        //dump($ulInfo);
        $msg = new Loops();
        if ($isbend) {
            $adminId = $isbend['ad_id'];
            if ($ulInfo['mp_ul_id'] == $adminId && $ulInfo['mp_ultype'] == 2 && $ulInfo['mp_utype'] == 1) {
                $user['unickname'] = $msg->getUserNick($ulInfo['mp_u_id']);
                $user['uavaurl'] = $msg->getUserAvatar($ulInfo['mp_u_id']);
                $user['email'] = $msg->getUserEmail($ulInfo['mp_u_id']);
                $user['uid'] = $ulInfo['mp_u_id'];
            }
            if ($ulInfo['mp_ul_id'] == $adminId && $ulInfo['mp_ultype'] == 2 && $ulInfo['mp_utype'] == 2) {
                $user['unickname'] = $msg->getAdminNick($ulInfo['mp_u_id']);
                $user['uavaurl'] = $msg->getAdminAvatar($ulInfo['mp_u_id']);
                $user['email'] = $msg->getAdminEmail($ulInfo['mp_u_id']);
                $user['uid'] = $ulInfo['mp_u_id'];
            }
            if ($ulInfo['mp_ul_id'] == $uId && $ulInfo['mp_utype'] == 1 && $ulInfo['mp_ultype'] == 1) {
                $user['unickname'] = $msg->getUserNick($ulInfo['mp_u_id']);
                $user['uavaurl'] = $msg->getUserAvatar($ulInfo['mp_u_id']);
                $user['email'] = $msg->getUserEmail($ulInfo['mp_u_id']);
                $user['uid'] = $ulInfo['mp_u_id'];
            }
            if ($ulInfo['mp_u_id'] == $adminId && $ulInfo['mp_utype'] == 2 && $ulInfo['mp_ultype'] == 1) {
                $user['unickname'] = $msg->getUserNick($ulInfo['mp_ul_id']);
                $user['uavaurl'] = $msg->getUserAvatar($ulInfo['mp_ul_id']);
                $user['email'] = $msg->getUserEmail($ulInfo['mp_ul_id']);
                $user['uid'] = $ulInfo['mp_ul_id'];
            }
            if ($ulInfo['mp_u_id'] == $uId && $ulInfo['mp_utype'] == 1 && $ulInfo['mp_ultype'] == 2) {
                $user['unickname'] = $msg->getAdminNick($ulInfo['mp_ul_id']);
                $user['uavaurl'] = $msg->getAdminAvatar($ulInfo['mp_ul_id']);
                $user['email'] = $msg->getAdminEmail($ulInfo['mp_ul_id']);
                $user['uid'] = $ulInfo['mp_ul_id'];
            }
            if ($ulInfo['mp_u_id'] == $uId && $ulInfo['mp_utype'] == 1 && $ulInfo['mp_ultype'] == 1) {
                $user['unickname'] = $msg->getUserNick($ulInfo['mp_ul_id']);
                $user['uavaurl'] = $msg->getUserAvatar($ulInfo['mp_ul_id']);
                $user['email'] = $msg->getUserEmail($ulInfo['mp_ul_id']);
                $user['uid'] = $ulInfo['mp_ul_id'];
            }
            return $user;
        } else {
            if ($ulInfo['mp_u_id'] == $uId) {
                if ($ulInfo['mp_ultype'] == 2) {
                    $user['unickname'] = $msg->getAdminNick($ulInfo['mp_ul_id']);
                    $user['uavaurl'] = $msg->getAdminAvatar($ulInfo['mp_ul_id']);
                    $user['email'] = $msg->getAdminEmail($ulInfo['mp_ul_id']);
                    $user['uid'] = $ulInfo['mp_ul_id'];
                } else {
                    $user['unickname'] = $msg->getUserNick($ulInfo['mp_ul_id']);
                    $user['uavaurl'] = $msg->getUserAvatar($ulInfo['mp_ul_id']);
                    $user['email'] = $msg->getUserEmail($ulInfo['mp_ul_id']);
                    $user['uid'] = $ulInfo['mp_ul_id'];
                }
                return $user;
            }
            if ($ulInfo['mp_ul_id'] == $uId) {
                if ($ulInfo['mp_utype'] == 2) {
                    $user['unickname'] = $msg->getAdminNick($ulInfo['mp_u_id']);
                    $user['uavaurl'] = $msg->getAdminAvatar($ulInfo['mp_u_id']);
                    $user['email'] = $msg->getAdminEmail($ulInfo['mp_u_id']);
                    $user['uid'] = $ulInfo['mp_u_id'];
                } else {
                    $user['unickname'] = $msg->getUserNick($ulInfo['mp_u_id']);
                    $user['uavaurl'] = $msg->getUserAvatar($ulInfo['mp_u_id']);
                    $user['email'] = $msg->getUserEmail($ulInfo['mp_u_id']);
                    $user['uid'] = $ulInfo['mp_u_id'];
                }
                return $user;
            }
        }
    }

    /***
     * 删除会话
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delTouch()
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        //会话id
        $mp_id = intval(trim($this->request->param('mpid')));
        if (!$mp_id) {
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        $msgList = Db::table('xcx_msg_person')
            ->where(['mp_id' => $mp_id])
            ->update(['mp_isable' => 2]);
        Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mp_id, 'xcx_msg_isable' => 1])
            ->update(['xcx_msg_isable' => 2]);
        if ($msgList) {
            $res['code'] = 1;
            $res['msg'] = '删除成功！';
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '删除失败！';
        return json($res);
    }


    /***
     * 删除消息
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delMsg()
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        //消息id
        $msgid = intval(trim($this->request->param('msgid')));
        if (!$msgid) {
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        $msgList = Db::table('xcx_msg_content')
            ->where(['xcx_msg_id' => $msgid, 'xcx_msg_isable' => 1])
            ->update(['xcx_msg_isable' => 2]);
        if ($msgList) {
            $res['code'] = 1;
            $res['msg'] = '删除成功！';
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '删除失败！';
        return json($res);
    }


    public function sendSms()
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $phone = trim($this->request->param('phone'));
        if ($phone == '') {
            return json(['code' => '0', 'msg' => '手机号不能为空！']);
        }
        //判断手机号是否正确
        //判断是否为澳洲手机号
        $code = mt_rand(999, 9999);
        $myreg = "/^(\+?0?86\-?)?1[345789]\d{9}$/";
        $au = "/^(\+?61|0)4\d{8}$/";
        //匹配国内手机号成功返回1 失败返回0
        $res = preg_match($myreg, $phone);
        //匹配澳洲手机号，成功返回1 失败返回0
        $resAu = preg_match($au, $phone);
        if ($res) {
            Loader::import('aliyunSdk/api_demo/SmsDemo', EXTEND_PATH);
            $sems = new \SmsDemo();
            $sem1 = $sems->sendSms1($phone, $code);
            $array = $this->object2array($sem1);
            $data['code'] = $code;
            $data['phone'] = $phone;
            if ($array['Code'] == 'OK') {
                return json(['code' => '1', 'msg' => '国内短信发送成功！', 'data' => $code]);
            } else {
                return json(['code' => '0', 'msg' => '短信发送失败！']);
            }
        }
        if ($resAu) {
            $msg = new Msgs();
            $res = $msg->sendAus($code, $phone);
            if ($res == 200) {
                return json(['code' => '1', 'msg' => '澳洲短信发送成功！', 'data' => $code]);
            } else {
                return json(['code' => 0, 'msg' => '发送失败！请联系管理员']);
            }
        }
    }


    //把对象转换成数组的方法；
    public function object2array($object)
    {
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                $array[$key] = $value;
            }
        } else {
            $array = $object;
        }
        return $array;
    }

    public function sendNot()
    {
        $id = trim($this->request->param('id'));
        if (!$id) {
            return json(['code' => 0, 'msg' => 'ID不为空']);
        }
        $userInfo = Db::connect('db2')->table('tk_user')
            ->where(['id' => $id])
            ->field('tel,nickname')
            ->find();
        if (!$userInfo) {
            return json(['code' => 0, 'msg' => '无此用户']);
        }
        if (!$userInfo['tel']) {
            return json(['code' => 0, 'msg' => '该用户暂未绑定手机号，消息无法发送']);
        }
        $phone = $userInfo['tel'];
        $myreg = "/^(\+?0?86\-?)?1[345789]\d{9}$/";
        $au = "/^(\+?61|0)4\d{8}$/";
        //匹配国内手机号成功返回1 失败返回0
        $res = preg_match($myreg, $phone);
        //匹配澳洲手机号，成功返回1 失败返回0
        $resAu = preg_match($au, $phone);
        $name = json_decode($this->removeEmoji($userInfo['nickname']));
        if ($res) {
            Loader::import('aliyunSdk/api_demo/SmsDemo', EXTEND_PATH);
            $sems = new \SmsDemo();
            $sem1 = $sems->sendNotice($phone, $name);
            $array = $this->object2array($sem1);
            if ($array['Code'] == 'OK') {
                return json(['code' => '1', 'msg' => '国内短信发送123123']);
            } else {
                return json(['code' => '0', 'msg' => '短信发送失败！', 'data' => $sem1]);
            }
        }
        if ($resAu) {
            $msg = new Msgs();
            $res = $msg->sendNotice($name, $phone);
            if ($res == 200) {
                return json(['code' => '1', 'msg' => '短信提醒发送成功！']);
            } else {
                return json(['code' => 0, 'msg' => '发送失败！请联系管理员']);
            }
        }

    }

    public function removeEmoji($message)
    {
        $message = json_encode($message);
        return preg_replace("#(\\\ud[0-9a-f]{3})#i", "", $message);
    }


    public function sendAdmin(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $hid = trim($this->request->param('hid'));
        $uid = trim($this->request->param('uid'));
        $name = trim($this->request->param('name'));
        $phone = trim($this->request->param('phone'));
        $email = trim($this->request->param('email'));
        $save = trim($this->request->param('is_save'));
        $type = trim($this->request->param('type'));
        $content = trim($this->request->param('content'));
        if(!$hid || !$name || !$phone ||  !$type || !$uid){
            $res['code'] = 2;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        //更新用户信息
        if($save == 1){
            Db::table('tk_user')->where(['id' => $uid])->update(['tel' => $phone,'email' => $email,'real_name' => $name]);
        }

        $house = Db::table('tk_houses')
            ->where(['id' => $hid])
            ->field('street,address,pm')
            ->find();
        $loop = new Loops();
        $address = $house['street'].''.$house['address'];
        $adminEmail = $loop->getAdminEmail($house['pm']);
        if($content != ''){
            //发送站内信
            $msgm = new Msgs();
            $Touchid = $msgm->createTouch($uid, $house['pm'], $hid);
            $this->sendAmsg($Touchid,$uid,$content);
        }
        $type = $this->forType($type);
        $mailer = new Mailer();
        $mpid = $Touchid;
        $uId = $uid;
        $formName = $loop->getUserNick($uId);
        $res = $mailer->mailPm($type,$adminEmail,$name,$mpid,$uId,$formName,$phone,$address,$content);
        if(!$res){
            return json(['code'=>0,'msg'=>'发送失败！请联系管理员']);
        }else{
            return json(['code'=>1,'msg'=>'发送成功！']);
        }
        return json(['code'=>1,'msg'=>'发送成功！']);
    }



    //对于一个房源新发送一条消息
    public function sendAmsg($mpid,$uId,$content){
        $ulInfo = $this->getUlidAndType($mpid, $uId);
        $data['xcx_msg_mp_id'] = $mpid;
        $data['xcx_msg_uid'] = $uId;
        $data['xcx_msg_ul_id'] = $ulInfo['ul_id'];
        $data['xcx_msg_ul_type'] = $ulInfo['ul_type'];
        $data['xcx_msg_u_type'] = 1;
        $data['xcx_msg_type'] = 1;
        $data['xcx_msg_content'] = $content;
        date_default_timezone_set("Australia/Melbourne");
        $data['xcx_msg_add_time'] = date('Y-m-d H:i:s');
        $datas['mp_mod_time'] = date('Y-m-d H:i:s');
        $data['xcx_msg_hid'] = $ulInfo['hid'];
        Db::table('xcx_msg_content')->insertGetId($data);
        //更新会话修改时间
        Db::table('xcx_msg_person')->where(['mp_id' => $mpid])->update($datas);
    }


    public function forType($type){
        switch ($type){
//        Inspection/ Available Date/ Application/ Length of lease
            case 1:
                $room = 'Inspection';
                break;
            case 2:
                $room = 'Length of lease';
                break;
            case 3:
                $room = 'Available Date';
                break;
            case 4:
                $room = 'Application';
                break;
            default:
                $room ='Others';
        }
        return $room;
    }

   public function upImg(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $path_date=date("Ym",time());
        $file = isset($_FILES['file']['name']);
        if($file){
            $file = $this->request->file('file');
            $file_type = $file->getInfo()['type'];
            $size = false;
            if(!in_array($file_type, ['image/jpg','image/png', 'image/jpeg', 'video/mp4', 'video/MP4'])) {
                return json(array('code'=>0,'path'=>'','msg'=> '系统仅支持jpg,jpeg,png格式图片,或MP4格式视频!'));
            }
            if(in_array($file_type, ['image/jpg','image/png', 'image/jpeg'])) {
                $config = [
                    'size' => 1024 * 1024 * 5,
                    'ext' => 'jpg,png,jpeg'
                ];
                $size = $file->validate($config);
            }
            if(in_array($file_type, ['video/mp4','video/MP4'])) {
                $config = [
                    'size' => 1024 * 1024 * 25,
                    'ext' => 'mp4,MP4'
                ];
                $size = $file->validate($config);
            }
            if($size){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/msg/'.$path_date.'/');
                if($info){
                    $path = 'uploads/msg/'.$path_date.'/'.$info->getSaveName();
                    //判断一下图片宽高，如果比例长宽比超过2.5：1，则认定为长图
                    $extension = $info->getExtension();
                    if(in_array($extension, ['mp4', 'MP4'])) {
                        return json(array('code'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
                    }
                    $check = $this->checkImg($path);
                    if($check == 2){
                        $path = $this->compImages($path);
                        return json(array('code'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
                    } else {
                        return json(array('code'=>0,'path'=>'','msg'=> '为方便浏览房源实景，请勿上传长图！'));
                    }
                }else{
                    if($file->getError() == '上传文件大小不符！'){
                        return json(array('code'=>0,'path'=>'','msg'=> '文件大小超过5MB，请压缩后重新上传'));
                    }elseif ($file->getError() == '上传文件后缀不允许'){
                        return json(array('code'=>0,'path'=>'','msg'=> '系统仅支持jpg,jpeg,png格式图片!'));
                    }else{
                        return json(array('code'=>0,'path'=>'','msg'=> '图片上传失败,请联系管理员！<br/>错误信息：'.$file->getError()));
                    }
                }
            }else{
                return json(array('code'=>0,'path'=>'','msg'=> '文件大小不超过10M，或格式错误！'));
            }
        }else{
            return json(array('code'=>0,'path'=>'','msg'=> '没有接收到文件,请在手机上的小程序重试！'));
        }
    }
    public function checkImg($filePath){
        $image = Image::open($filePath);
        //长宽比超过2.5：1
        $w = $image->width();
        $h = $image->height();
        $scale = $h / $w;
        $default = 2.5;
        if($scale > $default) {
            //程序删掉这个图片
            if(file_exists($filePath)){
                unlink($filePath);
            }
            return 1;
        } else {
            return 2;
        }
    }

    //压缩大于1.5m的房源图片
    public function compImages($files){
        $file = "./".$files;
        $size = filesize($file);
        $imgSize = ceil($size/1024);
        $Size1 = 1.5*1024;
        $Size2 = 2.5*1024;
        $Size3 = 3*1024;
        $Size4 = 6*1024;
        if($Size1 < $imgSize){
            return $file;
        }elseif($Size2 > $imgSize && $imgSize > $Size1){
            $this->compressImg($file,80);
        }elseif($Size3 > $imgSize && $imgSize > $Size2){
            $this->compressImg($file,70);
        }elseif($Size4 > $imgSize && $imgSize > $Size3){
            $this->compressImg($file,60);
        }else{
            $this->compressImg($file,40);
        }
        return $files;
    }

    /***
     * @param $filePath string 文件路径
     * @param $quality int 压缩比率
     * @return mixed
     */
    public function compressImg($filePath,$quality){
        $image = Image::open($filePath);
        $image->save($filePath,null,$quality);
        return $filePath;
    }


}