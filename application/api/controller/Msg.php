<?php
namespace app\api\controller;
use app\xcx\model\Loops;
use app\xcx\model\Msgs;
use think\Controller;
use think\Db;

class Msg extends Controller
{


    /****
     * 1.创建会话
     * @return \think\response\Json
     */
    public function touch(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid')));
        $ulId = intval(trim($this->request->param('ulid')));
        if(!$uId || !$ulId){
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        $msgm = new Msgs();
        $createTouch = $msgm->createTouch($uId,$ulId);
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
    public function getMsgList(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid')));
        if(!$uId){
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        $list = Db::table('xcx_msg_person')
            ->where("(mp_u_id = ".$uId." and mp_isable = 1) or (mp_ul_id = ".$uId." and  mp_isable = 1)")
//            ->where(['mp_u_id' => $uId,'mp_isable' => 1])
//            ->whereOr(['mp_ul_id' => $uId,'mp_isable' => 1])
            ->order('mp_mod_time desc')
            ->select();
        if($list){
            $msg = new Loops();
            foreach ($list as $k => $v){
                if($list[$k]['mp_u_id'] == $uId){
                    $list[$k]['nickname'] = $msg->getUserNick($v['mp_ul_id']);
                    $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_ul_id']);
                }else{
                    $list[$k]['nickname'] = $msg->getUserNick($v['mp_u_id']);
                    $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_u_id']);
                }
                $list[$k]['count'] = $msg->getUnread($v['mp_id']);
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $list;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = null;
        return json($res);
    }

    public function unRead(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid')));
        $list = Db::table('xcx_msg_person')
            ->where(['mp_u_id' => $uId,'mp_isable' => 1])
            ->whereOr(['mp_ul_id' => $uId,'mp_isable' => 1])
            ->field('mp_id')
            ->select();
        if($list){
            $msg = new Loops();
            $count = 0;
            foreach ($list as $k => $v){
                $count += $msg->getUnread($v['mp_id']);
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
    public function sendMsg(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        //发送人id
        $mpid = intval(trim($this->request->param('mpid')));
        //会话id
        $uId = intval(trim($this->request->param('uid')));
        //会话内容
        $content = trim($this->request->param('content'));
        if(!$mpid || !$uId){
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        if(!$content){
            $res['code'] = 0;
            $res['msg'] = '发送内容不能为空！';
            return json($res);
        }
        $data['xcx_msg_mp_id'] = $mpid;
        $data['xcx_msg_uid'] = $uId;
        $data['xcx_msg_content'] = $content;
        $data['xcx_msg_add_time'] = date('Y-m-d H:i:s');
        $sendMsg = Db::table('xcx_msg_content')->insertGetId($data);
        if($sendMsg){
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


    /***
     * 获取消息会话内容
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function getMsg(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        //会话id
        $uid = intval(trim($this->request->param('uid')));
        $mpid = intval(trim($this->request->param('mpid')));
        $page = trim($this->request->param('page','0'));
        $limit = 20;
        if(!$mpid){
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        //更新已读状态
        Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpid,'xcx_msg_isable' =>1])
            ->update(['xcx_msg_isread' => 1]);
        $msgList = Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpid,'xcx_msg_isable' =>1])
            ->order('xcx_msg_add_time')
            ->limit($limit,$page)
            ->select();
        if($msgList){
            $mpids= Db::table('xcx_msg_person')
                ->where(['mp_id' =>$mpid])
                ->field('mp_u_id,mp_ul_id')
                ->find();
            if($mpids['mp_u_id'] == $uid){
                $otherid = $mpids['mp_ul_id'];
            }else{
                $otherid = $mpids['mp_u_id'];
            }
            $msg = new Loops();
            $user['inickname'] =$msg->getUserNick($uid);
            $user['unickname'] = $msg->getUserNick($otherid);
            $user['iavaurl'] = $msg->getUserAvatar($uid);
            $user['uavaurl'] = $msg->getUserAvatar($otherid);
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $msgList;
            $res['user'] = $user;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空';
        $res['data'] = null;
        return json($res);

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
}