<?php
namespace app\api\controller;
use app\xcx\model\Loops;
use app\xcx\model\Msgs;
use think\Controller;
use think\Db;
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
        $message = Db::table('xcx_msg_content')->field('xcx_msg_mp_id, xcx_msg_add_time, xcx_msg_uid,xcx_msg_content')
            ->where(['xcx_msg_isread' => 2, 'xcx_msg_isable' => 1])
            ->group('xcx_msg_mp_id')->order('xcx_msg_id asc')->select();
        //dump($message);
        if (!$message) {
            return 1;
        }
        //设置时区问题
        date_default_timezone_set("Australia/Melbourne");
        $time = time();

        $date = date('Y-m-d H:i:s',time());
        foreach ($message as $key => $val) {
            $diff_num = $time - strtotime($val['xcx_msg_add_time']);
            //dump($val['xcx_msg_add_time'].'-'.$date);
            if ($diff_num <= 300) {
                continue;
            }
            $users = Db::table('xcx_msg_person')->field('mp_id,mp_u_id, mp_ul_id,mp_utype,mp_ultype')->where('mp_id', '=', $val['xcx_msg_mp_id'])->find();
            // dump($users);
            if (!$users) {
                continue;
            }
            //dump($users);
            //会话发起者 等于 消息发送者 发送未读提醒给 消息接受者
            if ($users['mp_u_id'] == $val['xcx_msg_uid']) {
                //如果消息接受者类型为后端用户
                if($users['mp_ultype'] == 2){
                    //  dump('会话发起者等于消息发送者发送未读提醒给消息接受者,消息接受者类型为后端用户adminid='.$users['mp_ul_id']);
                    $this->sendNotAdminMsg($users['mp_ul_id']);
                }else{
                    //消息接受者为前端用户
                    // dump('会话发起者等于消息发送者发送未读提醒给消息接受者,消息接受者为前端用户userid='.$users['mp_ul_id']);
                    $this->sendNotMsg($users['mp_ul_id']);
                }
            }else{
                //会话的接受者 等于 消息发送者  发送未读提醒给 消息发起者
                //如果消息发起者为后端用户
                if($users['mp_utype'] == 2){
                    //  dump('会话的接受者 等于 消息发送者  发送未读提醒给 消息发起者,消息发起者为后端用户adminid='.$users['mp_u_id']);
                    $this->sendNotAdminMsg($users['mp_u_id']);
                }else if($users['mp_ultype'] == 2){
                    //  dump('会话的接受者 bu等于 消息发送者  发送未读提醒给 消息发起者,消息发起者为后端用户adminid='.$users['mp_ul_id']);
                    $this->sendNotAdminMsg($users['mp_ul_id']);
                }else{
                    //    dump('会话的接受者 等于 消息发送者  发送未读提醒给 消息发起者,消息发起者为q前端用户userid='.$users['mp_u_id']);
                    $this->sendNotMsg($users['mp_u_id']);
                }

            }
        }
        return 2;
    }

    //前端用户发送消息
    private function sendNotMsg($uid) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://www.huaxiangxiaobao.com/api/msg/sendNot?id=' . $uid);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($curl);
        curl_close($curl);
    }


    //后台用户发送消息
    public function sendNotAdminMsg($uid){
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
    public function touch(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        //发起者id
        $uId = intval(trim($this->request->param('uid')));
        //接受者id
        $ulId = intval(trim($this->request->param('ulid')));
        $hId = intval(trim($this->request->param('hid')));
        Log::write('发起会话请求参数：uid='.$uId.',$ulId='.$ulId.',$hId='.$hId,'info');
        if(!$uId || !$ulId){
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        $msgm = new Msgs();
        $createTouch = $msgm->createTouch($uId,$ulId,$hId);
        if($createTouch){
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
        $where = "(mp_u_id = ".$uId." and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = ".$uId." and mp_ultype = 1 and  mp_isable = 1)";
        $isBindAdmin = $this->isBindAdmin($uId);
        $msg = new Loops();
        if($isBindAdmin){
            $adId = intval($isBindAdmin['ad_id']);
            $where .= " or (mp_u_id = ".$adId." and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = ".$adId." and mp_ultype = 2 and  mp_isable = 1)";
            $list = Db::table('xcx_msg_person')
                ->where($where)
                ->order('mp_mod_time desc')
                ->select();
            //dump($list);
            foreach ($list as $k => $v){
                if($v['mp_ul_id'] == $adId && $v['mp_ultype'] == 2 && $v['mp_utype'] == 1){
                    $list[$k]['nickname'] = $msg->getUserNick($v['mp_u_id']);
                    $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_u_id']);
                }
                if($v['mp_ul_id'] == $adId && $v['mp_ultype'] == 2 && $v['mp_utype'] == 2){
                    $list[$k]['nickname'] = $msg->getAdminNick($v['mp_u_id']);
                    $list[$k]['avaurl'] = $msg->getAdminAvatar($v['mp_u_id']);
                }
                if($v['mp_ul_id'] == $uId && $v['mp_utype'] == 1 && $v['mp_ultype'] == 1){
                    $list[$k]['nickname'] = $msg->getUserNick($v['mp_u_id']);
                    $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_u_id']);
                }
                if($v['mp_u_id'] == $adId && $v['mp_utype'] == 2 && $v['mp_ultype'] == 1){
                    $list[$k]['nickname'] = $msg->getUserNick($v['mp_ul_id']);
                    $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_ul_id']);
                }
                if($v['mp_u_id'] == $uId && $v['mp_utype'] == 1 && $v['mp_ultype'] == 2){
                    $list[$k]['nickname'] = $msg->getAdminNick($v['mp_ul_id']);
                    $list[$k]['avaurl'] = $msg->getAdminAvatar($v['mp_ul_id']);
                }
                if($v['mp_u_id'] == $uId && $v['mp_utype'] == 1 && $v['mp_ultype'] == 1){
                    $list[$k]['nickname'] = $msg->getUserNick($v['mp_ul_id']);
                    $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_ul_id']);
                }
                if($v['mp_ul_id'] == $uId && $v['mp_utype'] == 2 && $v['mp_ultype'] == 1){
                    $list[$k]['nickname'] = $msg->getAdminNick($v['mp_u_id']);
                    $list[$k]['avaurl'] = $msg->getAdminAvatar($v['mp_u_id']);
                }
                $list[$k]['count'] = $msg->getUnread($v['mp_id'], $uId);
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功1！';
            $res['data'] = $list;
            return json($res);
        }else{
            //没有绑定后端平台用户
            $list = Db::table('xcx_msg_person')
                ->where($where)
                ->order('mp_mod_time desc')
                ->select();
            if ($list) {
                foreach ($list as $k => $v) {
                    //消息发送人是我自己
                    if($list[$k]['mp_u_id'] == $uId){
                        if($v['mp_utype'] == 1 && $v['mp_ultype'] == 2){
                            $list[$k]['nickname'] = $msg->getAdminNick($v['mp_ul_id']);
                            $list[$k]['avaurl'] = $msg->getAdminAvatar($v['mp_ul_id']);
                            $list[$k]['count'] = $this->getUnread2($v['mp_id'],$uId);
                        }
                        if($v['mp_utype'] == 1 && $v['mp_ultype'] == 1){
                            $list[$k]['nickname'] = $msg->getUserNick($v['mp_ul_id']);
                            $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_ul_id']);
                            $list[$k]['count'] = $this->getUnread2($v['mp_id'],$uId);
                        }
                    }
                    //消息接收人是我自己
                    if($list[$k]['mp_ul_id'] == $uId){
                        if($v['mp_utype'] == 2 && $v['mp_ultype'] == 1){
                            $list[$k]['nickname'] = $msg->getAdminNick($v['mp_u_id']);
                            $list[$k]['avaurl'] = $msg->getAdminAvatar($v['mp_u_id']);
                            $list[$k]['count'] = $this->getUnread1($v['mp_id'],$uId);
                        }
                        if($v['mp_utype'] == 1 && $v['mp_ultype'] == 1){
                            $list[$k]['nickname'] = $msg->getUserNick($v['mp_u_id']);
                            $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_u_id']);
                            $list[$k]['count'] = $this->getUnread1($v['mp_id'],$uId);
                        }
                    }
                }
                $res['code'] = 1;
                $res['msg'] = '读取成功2！';
                $res['data'] = $list;
                return json($res);
            }
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = null;
        return json($res);
    }
    public function getUnread1($mpId,$uid){
        $readWhere = 'xcx_msg_ul_id != '.$uid;
        $unRead = Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpId,'xcx_msg_isread' => 2,'xcx_msg_isable' =>1])
            ->where($readWhere)
            ->count('xcx_msg_id');
        return $unRead ? $unRead : 0;
    }
    public function getUnread2($mpId,$uid){
        $readWhere = 'xcx_msg_uid != '.$uid;
        $unRead = Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpId,'xcx_msg_isread' => 2,'xcx_msg_isable' =>1])
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
    public function isBindAdmin($uid){
        $isBind = Db::table('super_admin')->where(['ad_wechat' => $uid])->field('ad_id')->find();
        return $isBind ? $isBind : null;
    }
    public function unRead(){
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
        $where = "(mp_u_id = ".$uId." and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = ".$uId." and mp_ultype = 1 and  mp_isable = 1)";
        $isBindAdmin = $this->isBindAdmin($uId);
        $msg = new Loops();
        if($isBindAdmin){
            $adId = intval($isBindAdmin['ad_id']);
            $where .= " or (mp_u_id = ".$adId." and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = ".$adId." and mp_ultype = 2 and  mp_isable = 1)";
            $list = Db::table('xcx_msg_person')
                ->where($where)
                ->order('mp_mod_time desc')
                ->select();
            $count = 0;
            foreach ($list as $k => $v){
                $count = $msg->getUnread($v['mp_id'], $uId);
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功1！';
            $res['count'] = $count;
            return json($res);
        }else{
            //没有绑定后端平台用户
            $list = Db::table('xcx_msg_person')
                ->where($where)
                ->order('mp_mod_time desc')
                ->select();
            $count = 0;
            if ($list) {
                foreach ($list as $k => $v) {
                    //消息发送人是我自己
                    if($list[$k]['mp_u_id'] == $uId){
                        if($v['mp_utype'] == 1 && $v['mp_ultype'] == 2){
                            $count += $this->getUnread2($v['mp_id'],$uId);
                        }
                        if($v['mp_utype'] == 1 && $v['mp_ultype'] == 1){
                            $count +=  $this->getUnread2($v['mp_id'],$uId);
                        }
                    }
                    //消息接收人是我自己
                    if($list[$k]['mp_ul_id'] == $uId){
                        if($v['mp_utype'] == 2 && $v['mp_ultype'] == 1){
                            $count +=  $this->getUnread1($v['mp_id'],$uId);
                        }
                        if($v['mp_utype'] == 1 && $v['mp_ultype'] == 1){
                            $count +=  $this->getUnread1($v['mp_id'],$uId);
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


    public function unRead1(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid')));
        $where = "(mp_u_id = ".$uId." and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = ".$uId." and mp_ultype = 1 and  mp_isable = 1)";
        $isBindAdmin = $this->isBindAdmin($uId);
        if($isBindAdmin) {
            $adId = intval($isBindAdmin['ad_id']);
            $where .= " or (mp_u_id = " . $adId . " and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = " . $adId . " and mp_ultype = 2 and  mp_isable = 1)";
        }
        $list = Db::table('xcx_msg_person')
            ->where($where)
            ->field('mp_id')
            ->select();
        if($list){
            $msg = new Loops();
            $count = 0;
            foreach ($list as $k => $v){
                $count += $msg->getUnread($v['mp_id'],$uId);
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
        //会话内容
        //消息接受者信息
        $ulInfo = $this->getUlidAndType($mpid,$uId);
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
        $data['xcx_msg_mp_id'] = $mpid;
        $data['xcx_msg_uid'] = $uId;
        $data['xcx_msg_ul_id'] = $ulInfo['ul_id'];
        $data['xcx_msg_ul_type'] = $ulInfo['ul_type'];
        //后端发送
        $data['xcx_msg_u_type'] = 1;
        $data['xcx_msg_content'] = $content;
        date_default_timezone_set("Australia/Melbourne");
        $data['xcx_msg_add_time'] = date('Y-m-d H:i:s');
        $datas['mp_mod_time'] = date('Y-m-d H:i:s');
        $sendMsg = Db::table('xcx_msg_content')->insertGetId($data);
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

    public function getUlidAndType($mpid,$uId){
        $ulInfo = Db::table('xcx_msg_person')->where(['mp_id' => $mpid])->find();
        if($ulInfo['mp_u_id'] == $uId){
            $res['ul_id'] = $ulInfo['mp_ul_id'];
            $res['ul_type'] = $ulInfo['mp_ultype'];
        }else{
            $res['ul_id'] = $ulInfo['mp_u_id'];
            $res['ul_type'] = $ulInfo['mp_utype'];
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
        $ulInfo = $this->getUlInfo($mpid,$uid);
        //dump($ulInfo);
        $page = trim($this->request->param('page', '0'));
        $limit = 100;
        if (!$mpid && $uid) {
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        //更新已读状态

        //更新已读状态
        $bindId = $isbend['ad_id'];
        //更新已读状态
        if($isbend){
            $readWhere = '( xcx_msg_uid != '.$uid.' and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != '.$bindId.' and  xcx_msg_u_type = 2 )';
        }else{
            $readWhere = '( xcx_msg_u_type = 1 and  xcx_msg_uid != '.$uid.' ) or ( xcx_msg_ul_type = 1 and  xcx_msg_ul_id != '.$uid.') ';
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
//            $list[$k]['mp_ultype'] == 2 || $list[$k]['mp_utype'] == 2
            $mpids = Db::table('xcx_msg_person')
                ->where(['mp_id' => $mpid])
                ->field('mp_u_id,mp_ul_id,mp_ultype,mp_utype')
                ->find();
            if($isbend){
                $bindId = $isbend['ad_id'];
                foreach($msgList as $k => $v){
                    if($v['xcx_msg_uid'] == $bindId){
                        $msgList[$k]['xcx_msg_uid'] = $uid;
                    }
                    if($v['xcx_msg_uid'] == $uid){
                        $msgList[$k]['xcx_msg_uid'] = $uid;
                    }
                }
            }else{
                foreach($msgList as $k => $v){
                    if($v['xcx_msg_ul_id'] == $uid){
                        Db::table('xcx_msg_content')
                            ->where(['xcx_msg_mp_id' => $mpid, 'xcx_msg_isable' => 1,'xcx_msg_ul_id' => $uid])
                            ->update(['xcx_msg_isread' => 1]);
                    }
                }
            }

            $msg = new Loops();
            $user['unickname'] = $ulInfo['unickname'];
            $user['uavaurl'] = $ulInfo['uavaurl'];
            $user['inickname'] = $msg->getUserNick($uid);
            $user['iavaurl'] = $msg->getUserAvatar($uid);
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            //dump($user);
            $res['data'] = $msgList;
            $res['user'] = $user;
            //dump($res);
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空';
        $res['data'] = null;
        return json($res);

    }


    public function getUlInfo($mpid,$uId){
        //查询当前小程序用户是否绑定admin用户
        $isbend = $this->isBindAdmin($uId);
        $ulInfo = Db::table('xcx_msg_person')->where(['mp_id' => $mpid])->find();
        //dump($ulInfo);
        $msg = new Loops();
        if($isbend){
            $adminId = $isbend['ad_id'];
            if($ulInfo['mp_ul_id'] == $adminId && $ulInfo['mp_ultype'] == 2 && $ulInfo['mp_utype'] == 1){
                $user['unickname'] = $msg->getUserNick($ulInfo['mp_u_id']);
                $user['uavaurl']  = $msg->getUserAvatar($ulInfo['mp_u_id']);
                $user['uid']  = $ulInfo['mp_u_id'];
            }
            if($ulInfo['mp_ul_id'] == $adminId && $ulInfo['mp_ultype'] == 2 && $ulInfo['mp_utype'] == 2){
                $user['unickname'] = $msg->getAdminNick($ulInfo['mp_u_id']);
                $user['uavaurl'] = $msg->getAdminAvatar($ulInfo['mp_u_id']);
                $user['uid']  = $ulInfo['mp_u_id'];
            }
            if($ulInfo['mp_ul_id'] == $uId && $ulInfo['mp_utype'] == 1 && $ulInfo['mp_ultype'] == 1){
                $user['unickname'] = $msg->getUserNick($ulInfo['mp_u_id']);
                $user['uavaurl'] = $msg->getUserAvatar($ulInfo['mp_u_id']);
                $user['uid']  = $ulInfo['mp_u_id'];
            }
            if($ulInfo['mp_u_id'] == $adminId && $ulInfo['mp_utype'] == 2 && $ulInfo['mp_ultype'] == 1){
                $user['unickname'] = $msg->getUserNick($ulInfo['mp_ul_id']);
                $user['uavaurl'] = $msg->getUserAvatar($ulInfo['mp_ul_id']);
                $user['uid']  = $ulInfo['mp_ul_id'];
            }
            if($ulInfo['mp_u_id'] == $uId && $ulInfo['mp_utype'] == 1 && $ulInfo['mp_ultype'] == 2){
                $user['unickname'] = $msg->getAdminNick($ulInfo['mp_ul_id']);
                $user['uavaurl'] = $msg->getAdminAvatar($ulInfo['mp_ul_id']);
                $user['uid']  = $ulInfo['mp_ul_id'];
            }
            if($ulInfo['mp_u_id'] == $uId && $ulInfo['mp_utype'] == 1 && $ulInfo['mp_ultype'] == 1){
                $user['unickname'] = $msg->getUserNick($ulInfo['mp_ul_id']);
                $user['uavaurl'] = $msg->getUserAvatar($ulInfo['mp_ul_id']);
                $user['uid']  = $ulInfo['mp_ul_id'];
            }
            return $user;
        }else{
            if($ulInfo['mp_u_id'] == $uId){
                if($ulInfo['mp_ultype'] == 2){
                    $user['unickname'] = $msg->getAdminNick($ulInfo['mp_ul_id']);
                    $user['uavaurl'] = $msg->getAdminAvatar($ulInfo['mp_ul_id']);
                    $user['uid']  = $ulInfo['mp_ul_id'];
                }else{
                    $user['unickname'] = $msg->getUserNick($ulInfo['mp_ul_id']);
                    $user['uavaurl'] = $msg->getUserAvatar($ulInfo['mp_ul_id']);
                    $user['uid']  = $ulInfo['mp_ul_id'];
                }
                return $user;
            }
            if($ulInfo['mp_ul_id'] == $uId){
                if($ulInfo['mp_utype'] == 2){
                    $user['unickname'] = $msg->getAdminNick($ulInfo['mp_u_id']);
                    $user['uavaurl'] = $msg->getAdminAvatar($ulInfo['mp_u_id']);
                    $user['uid']  = $ulInfo['mp_u_id'];
                }else{
                    $user['unickname'] = $msg->getUserNick($ulInfo['mp_u_id']);
                    $user['uavaurl'] = $msg->getUserAvatar($ulInfo['mp_u_id']);
                    $user['uid']  = $ulInfo['mp_u_id'];
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
    public function delTouch(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        //会话id
        $mp_id = intval(trim($this->request->param('mpid')));
        if(!$mp_id){
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        $msgList = Db::table('xcx_msg_person')
            ->where(['mp_id' => $mp_id])
            ->update(['mp_isable' =>2]);
        Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mp_id,'xcx_msg_isable' =>1])
            ->update(['xcx_msg_isable' =>2]);
        if($msgList){
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
    public function delMsg(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        //消息id
        $msgid = intval(trim($this->request->param('msgid')));
        if(!$msgid){
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        $msgList = Db::table('xcx_msg_content')
            ->where(['xcx_msg_id' => $msgid,'xcx_msg_isable' =>1])
            ->update(['xcx_msg_isable' =>2]);
        if($msgList){
            $res['code'] = 1;
            $res['msg'] = '删除成功！';
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '删除失败！';
        return json($res);
    }


    public function sendSms(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $phone = trim($this->request->param('phone'));
        if($phone == ''){
            return  json(['code' => '0','msg' => '手机号不能为空！']);
        }
        //判断手机号是否正确
        //判断是否为澳洲手机号
        $code = mt_rand(999, 9999);
        $myreg = "/^(\+?0?86\-?)?1[345789]\d{9}$/";
        $au = "/^(\+?61|0)4\d{8}$/";
        //匹配国内手机号成功返回1 失败返回0
        $res = preg_match($myreg,$phone);
        //匹配澳洲手机号，成功返回1 失败返回0
        $resAu = preg_match($au,$phone);
        if($res){
            Loader::import('aliyunSdk/api_demo/SmsDemo',EXTEND_PATH);
            $sems = new \SmsDemo();
            $sem1=$sems->sendSms1($phone,$code);
            $array=$this->object2array($sem1);
            $data['code'] = $code;
            $data['phone'] = $phone;
            if($array['Code'] == 'OK'){
                return  json(['code' => '1','msg' => '国内短信发送成功！','data' =>$code]);
            }else{
                return  json(['code' => '0','msg' => '短信发送失败！']);
            }
        }
        if($resAu){
            $msg = new Msgs();
            $res = $msg->sendAus($code,$phone);
            if($res == 200){
                return  json(['code' => '1','msg' => '澳洲短信发送成功！','data' =>$code]);
            }else{
                return json(['code'=>0,'msg'=>'发送失败！请联系管理员']);
            }
        }
    }


    //把对象转换成数组的方法；
    public function object2array($object) {
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                $array[$key] = $value;
            }
        }
        else {
            $array = $object;
        }
        return $array;
    }

    public function sendNot(){
        $id = trim($this->request->param('id'));
        if(!$id){
            return json(['code'=>0,'msg'=>'ID不为空']);
        }
        $userInfo = Db::connect('db2')->table('tk_user')
            ->where(['id' =>$id])
            ->field('tel,nickname')
            ->find();
        if(!$userInfo){
            return json(['code'=>0,'msg'=>'无此用户']);
        }
        if(!$userInfo['tel']){
            return json(['code'=>0,'msg'=>'该用户暂未绑定手机号，消息无法发送']);
        }
        $phone = $userInfo['tel'];
        $myreg = "/^(\+?0?86\-?)?1[345789]\d{9}$/";
        $au = "/^(\+?61|0)4\d{8}$/";
        //匹配国内手机号成功返回1 失败返回0
        $res = preg_match($myreg,$phone);
        //匹配澳洲手机号，成功返回1 失败返回0
        $resAu = preg_match($au,$phone);
        $name = json_decode($this->removeEmoji($userInfo['nickname']));
        if($res){
            Loader::import('aliyunSdk/api_demo/SmsDemo',EXTEND_PATH);
            $sems = new \SmsDemo();
            $sem1=$sems->sendNotice($phone,$name);
            $array=$this->object2array($sem1);
            if($array['Code'] == 'OK'){
                return  json(['code' => '1','msg' => '国内短信发送123123']);
            }else{
                return  json(['code' => '0','msg' => '短信发送失败！','data' => $sem1]);
            }
        }
        if($resAu){
            $msg = new Msgs();
            $res = $msg->sendNotice($name,$phone);
            if($res == 200){
                return  json(['code' => '1','msg' => '短信提醒发送成功！']);
            }else{
                return json(['code'=>0,'msg'=>'发送失败！请联系管理员']);
            }
        }

    }

    public function removeEmoji($message) {
        $message = json_encode($message);
        return preg_replace("#(\\\ud[0-9a-f]{3})#i", "", $message);
    }


}