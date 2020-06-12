<?php
namespace app\api\controller;
use app\xcx\model\Loops;
use app\xcx\model\Msgs;
use think\Controller;
use think\Db;
use think\Loader;

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
        //发起者id
        $uId = intval(trim($this->request->param('uid')));
        //接受者id
        $ulId = intval(trim($this->request->param('ulid')));
        $hId = intval(trim($this->request->param('hid','0')));
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
                $list[$k]['count'] = $msg->getUnread($v['mp_id'],$uId);
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
            ->where("(mp_u_id = ".$uId." and mp_isable = 1) or (mp_ul_id = ".$uId." and  mp_isable = 1)")
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
        date_default_timezone_set("Australia/Melbourne");
        $data['xcx_msg_add_time'] = date('Y-m-d H:i:s');
        $datas['mp_mod_time'] = date('Y-m-d H:i:s');
        $sendMsg = Db::table('xcx_msg_content')->insertGetId($data);
        //更新会话修改时间
        Db::table('xcx_msg_person')->where(['mp_id' => $mpid])->update($datas);
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
        if(!$mpid && $uid){
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