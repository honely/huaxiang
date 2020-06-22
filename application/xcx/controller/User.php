<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/4/18
 * Time: 14:02
 */
namespace app\xcx\controller;
use app\xcx\model\Loops;
use app\xcx\model\Msgs;
use app\xcx\model\Rolem;
use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

class User extends Controller{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $adminName=session('adminName');
        if(empty($adminName)){
            $this->error('请先登录！','login/login');
        }
        if(isset($_SESSION['expiretime'])) {
            if($_SESSION['expiretime'] < time()) {
                unset($_SESSION['expiretime']);
                $this->error('您的登录身份已过期，请重新登录！','login/login');
                exit(0);
            } else {
                $_SESSION['expiretime'] = time() + 1800; // 刷新时间戳
            }
        }
    }
    public function details(){
        $cus_id=intval($_GET['id']);
        //获取客户信息；
        $cusInfo=Db::table('tk_user')->where(['id' => $cus_id])->find();
        //收藏记录
        $collect=Db::table('xcx_collect')
            ->where(['cl_user_id' => $cus_id])
            ->order('cl_addtime desc')
            ->select();
        //浏览记录
        $view=Db::table('xcx_view_history')
            ->where(['vh_userid' => $cus_id])
            ->select();
        //发布房源
        $house = Db::table('tk_houses')
            ->where(['user_id' => $cus_id])
            ->select();
        //发布找室友
        $mate = Db::table('tk_roommates')
            ->where(['user_id' => $cus_id])
            ->select();
        //搜索记录
        $querys = Db::table('xcx_search_keywords')
            ->where(['sk_userid' => $cus_id])
            ->where("sk_keywords != '' ")
            ->select();
        $this->assign('house',$house);
        $this->assign('collect',$collect);
        $this->assign('view',$view);
        $this->assign('mate',$mate);
        $this->assign('querys',$querys);
        $this->assign('cus',$cusInfo);
        return $this->fetch();
    }

    public function index(){
        $weChat = session('ad_wechat');
        $weChat = $weChat== null ? 0: $weChat;
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        //会话
        $addable = in_array('274',$power_list,true);
        //角色
        $editable = in_array('275',$power_list,true);
        $this->assign('addable',$addable);
        $this->assign('editable',$editable);
        $this->assign('wechat',$weChat);
        return $this->fetch();
    }


    public function userData(){
        $where ='1 = 1 ';
        $keywords = trim($this->request->param('keywords'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( id like '%".$keywords."%' or nickname like '%".$keywords."%')";
        }
        $count=Db::table('tk_user')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $example=Db::table('tk_user')->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('cdate desc')
            ->select();
        if($example){
            foreach ($example as $k => $v){
                $example[$k]['roleId'] = $v['role_id'] == 0 ? '否': '是';
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $example;
        $res['count'] = $count;
        return json($res);
    }

    public function serlog(){
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $addable = in_array('256',$power_list,true);
        $this->assign('addable',$addable);
        return $this->fetch();
    }

    public function logData(){
        $today = date('Y-m-d')." 23:59:59";
        $month = date( 'Y-m-d', strtotime($today.' -1 month')).' 00:00:00';
        $where ="sk_keywords != '' and sk_addtime >= '".$month."' and sk_addtime <= '".$today."'";
        //$where ="1 = 1";
        $keywords = trim($this->request->param('keywords'));
        $user = trim($this->request->param('user'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( sk_keywords like '%".$keywords."%')";
        }
        if(isset($user) && !empty($user)){
            $where.=" and ( nickname like '%".$user."%')";
        }
        $count=Db::table('xcx_search_keywords')
            ->join('tk_user','tk_user.id = xcx_search_keywords.sk_userid')
            ->where($where)
            ->field('xcx_search_keywords.*,tk_user.nickname')
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $example=Db::table('xcx_search_keywords')
            ->join('tk_user','tk_user.id = xcx_search_keywords.sk_userid')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('sk_addtime desc')
            ->field('xcx_search_keywords.*,tk_user.nickname')
            ->select();
        $loopd = new Loops();
        if($example){
            foreach ($example as $k => $v){
                $example[$k]['sk_type'] = $v['sk_type'] == 1 ? '房源' : '找室友';
                $example[$k]['sk_username'] = $loopd->getUserNick($v['sk_userid']);
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $example;
        $res['count'] = $count;
        return json($res);
    }

    public function touchs(){
        $mpid = trim($this->request->param('mp_id',0,'intval'));
        $uId = session('adminId');
        //是否绑定前端用户
        $isUser = $this->isBendUser($uId);
        $mpinfo = Db::table('xcx_msg_person')->where(['mp_id' => $mpid])->find();
        //dump($mpinfo);
        $loop = new Loops();
        //绑定了前端用户
        //绑定了前端用户
        //dump('当前admin'.$uId);
        //dump('admin绑定的user'.$isUser);
        if($isUser){
            $ulId = $mpinfo['mp_u_id'] == $isUser ? $mpinfo['mp_ul_id'] : $mpinfo['mp_u_id'];
            if($mpinfo['mp_ul_id'] == $uId && $mpinfo['mp_ultype'] == 2){
                //说明对方是user
                //dump('说明对方是user');
                $uavatar = $loop->getUserAvatar($ulId);
                $unickname = $loop->getUserNick($ulId);
            }
            if($mpinfo['mp_u_id'] == $isUser && $mpinfo['mp_ultype'] == 2){
                //说明对方是admin
                //dump('说明对方是admin');
                $uavatar = $loop->getAdminAvatar($ulId);
                $unickname = $loop->getAdminNick($ulId);
            }
            if($mpinfo['mp_ul_id'] == $isUser && $mpinfo['mp_ultype'] == 1  && $mpinfo['mp_utype'] == 2){
                $uavatar = $loop->getAdminAvatar($ulId);
                $unickname = $loop->getAdminNick($ulId);
            }
            if($mpinfo['mp_u_id'] == $isUser && $mpinfo['mp_ultype'] == 1 && $mpinfo['mp_utype'] == 1){
                $uavatar = $loop->getUserAvatar($ulId);
                $unickname = $loop->getUserNick($ulId);
            }
            if($mpinfo['mp_ul_id'] == $isUser && $mpinfo['mp_ultype'] == 1 && $mpinfo['mp_utype'] == 1){
                $uavatar = $loop->getUserAvatar($ulId);
                $unickname = $loop->getUserNick($ulId);
            }
            if($mpinfo['mp_u_id'] == $uId && $mpinfo['mp_utype'] == 2){
                //dump('说明对方是user');
                $ulId = $mpinfo['mp_ul_id'];
                $uavatar = $loop->getUserAvatar($ulId);
                $unickname = $loop->getUserNick($ulId);
            }
        }else{
            //没有绑定前端用户
            $ulId = $mpinfo['mp_u_id'] == $uId ? $mpinfo['mp_ul_id'] : $mpinfo['mp_u_id'];
            if($mpinfo['mp_ul_id'] == $uId &&  $mpinfo['mp_ultype'] == 2 &&  $mpinfo['mp_utype'] == 2){
                $uavatar = $loop->getAdminAvatar($ulId);
                $unickname = $loop->getAdminNick($ulId);
            }
            if($mpinfo['mp_ul_id'] == $uId &&  $mpinfo['mp_ultype'] == 2 &&  $mpinfo['mp_utype'] == 1){
                $uavatar = $loop->getUserAvatar($ulId);
                $unickname = $loop->getUserNick($ulId);
            }
        }
        //不管有没有绑定前端用户 我的头像都是admin_id
        $avatar = $loop->getAdminAvatar($uId);
        $nickname = $loop->getAdminNick($uId);
        Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpid,'xcx_msg_isable' =>1])
            ->update(['xcx_msg_isread' => 1]);
        $msgList = Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpid,'xcx_msg_isable' =>1])
            ->order('xcx_msg_add_time')
            ->select();
        //dump($msgList);
        foreach ($msgList  as $k => $v){
            if($isUser){
                if($uId == $v['xcx_msg_uid'] || $isUser == $v['xcx_msg_uid']){
                    $msgList[$k]['postit'] = 'message-r';
                }else{
                    $msgList[$k]['postit'] = 'message-l';
                }
            }else{
                $msgList[$k]['postit'] = $uId == $v['xcx_msg_uid'] ? 'message-r': 'message-l';
            }
        }
        //dump($unickname);
        //dump($uavatar);
        $msg = '我和'.$unickname.'的聊天';
        $this->assign('titleMsg',$msg);
        $this->assign('uavatar',$avatar);
        $this->assign('unickname',$nickname);
        $this->assign('avatar',$uavatar);
        $this->assign('nickname',$unickname);
        $this->assign('mpid',$mpid);
        $this->assign('msgList',$msgList);
        return $this->fetch('touch');
    }

    public function isBendUser($adminId){
        $isBend = Db::table('super_admin')
            ->where(['ad_id' => $adminId])
            ->field('ad_wechat')
            ->find();
        return $isBend['ad_wechat'] ? $isBend['ad_wechat'] : '';
    }


    public function getUnread($mpId,$adminid){
        $isBendUser = $this->isBendUser($adminid);
        $unRead=0;
        if($isBendUser){
            $unRead += Db::table('xcx_msg_content')
                ->where(['xcx_msg_mp_id' => $mpId,'xcx_msg_isread' => 2,'xcx_msg_isable' =>1])
                ->where('xcx_msg_uid != '.$isBendUser)
                ->count('xcx_msg_id');
        }
        $unRead = Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpId,'xcx_msg_isread' => 2,'xcx_msg_isable' =>1])
            ->where('xcx_msg_uid != '.$adminid)
            ->count('xcx_msg_id');
        return $unRead ? $unRead : 0;
    }

    /***
     * 后端管理员与前端用户发起沟通
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function touch(){
        //发起目标为前端用户
        $ulId = trim($this->request->param('id',0,'intval'));
        //发起者为后端管理员
        $adminId = session('adminId');
        $msgm = new Msgs();
        $mpid = $msgm->adminCreateTouch($adminId,$ulId);
        $loop = new Loops();
        $avatar = $loop->getUserAvatar($ulId);
        $nickname = $loop->getUserNick($ulId);
        $uavatar = $loop->getAdminAvatar($adminId);
        $unickname = $loop->getAdminNick($adminId);
        $msg = '我和'.$nickname.'的聊天';
        //更新已读状态
        Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpid,'xcx_msg_isable' =>1])
            ->update(['xcx_msg_isread' => 1]);
        $msgList = Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpid,'xcx_msg_isable' =>1])
            ->order('xcx_msg_add_time')
            ->select();
        foreach ($msgList  as $k => $v){
            $msgList[$k]['postit'] = $adminId == $v['xcx_msg_uid'] ? 'message-r': 'message-l';
            $msgList[$k]['uavatar'] = $adminId == $v['xcx_msg_uid'] ? $uavatar: $avatar;
            $msgList[$k]['nickname'] = $adminId == $v['xcx_msg_uid'] ? $unickname : $nickname;
        }
        $this->assign('msgList',$msgList);
        $this->assign('avatar',$avatar);
        $this->assign('nickname',$nickname);
        $this->assign('mpid',$mpid);
        $this->assign('uavatar',$uavatar);
        $this->assign('unickname',$unickname);
        $this->assign('titleMsg',$msg);
        return $this->fetch();

    }

    public function msgs(){
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $addable = in_array('277',$power_list,true);
        $editable = in_array('278',$power_list,true);
        $this->assign('editable',$editable);
        $this->assign('addable',$addable);
        return $this->fetch();
    }

    public function msgData(){
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',20,'intval');
        $adminid = session('adminId');
        $adWechat = session('ad_wechat');
        $where = "(mp_u_id = ".$adminid." and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = ".$adminid." and mp_ultype = 2 and  mp_isable = 1)";
        if($adWechat){
            $where .= " or (mp_u_id = ".$adWechat." and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = ".$adWechat." and mp_ultype = 1 and  mp_isable = 1)";
        }
        $list = Db::table('xcx_msg_person')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('mp_mod_time desc')
            ->select();
        // dump($adWechat);
        //dump($adminid);
        $count=Db::table('xcx_msg_person')
            ->where($where)
            ->count();
        if($list){
            $msg = new Loops();
            foreach ($list as $k => $v){
                if($adWechat){
                    if($list[$k]['mp_u_id'] == $adWechat && $list[$k]['mp_utype'] == 1 && $list[$k]['mp_ultype'] == 2 ){
                        $list[$k]['nickname'] = $msg->getAdminNick($v['mp_ul_id']);
                        $list[$k]['avaurl'] = $msg->getAdminAvatar($v['mp_ul_id']);
                    }
                    if($list[$k]['mp_ul_id'] == $adWechat && $list[$k]['mp_utype'] == 2 && $list[$k]['mp_ultype'] == 1 ){
                        $list[$k]['nickname'] = $msg->getAdminNick($v['mp_u_id']);
                        $list[$k]['avaurl'] = $msg->getAdminAvatar($v['mp_u_id']);
                    }
                    if($list[$k]['mp_u_id'] == $adWechat && $list[$k]['mp_ultype'] == 1 && $list[$k]['mp_utype'] == 1){
                        $list[$k]['nickname'] = $msg->getUserNick($v['mp_ul_id']);
                        $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_ul_id']);
                    }
                    if($list[$k]['mp_ul_id'] == $adminid && $list[$k]['mp_ultype'] == 2 && $list[$k]['mp_utype'] == 1){
                        $list[$k]['nickname'] = $msg->getUserNick($v['mp_u_id']);
                        $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_u_id']);
                    }
                    if($list[$k]['mp_ul_id'] == $adWechat && $list[$k]['mp_ultype'] == 1 && $list[$k]['mp_utype'] == 1){
                        $list[$k]['nickname'] = $msg->getUserNick($v['mp_u_id']);
                        $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_u_id']);
                    }
                    if($list[$k]['mp_u_id'] == $adminid && $list[$k]['mp_ultype'] == 1 && $list[$k]['mp_utype'] == 2){
                        $list[$k]['nickname'] = $msg->getUserNick($v['mp_ul_id']);
                        $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_ul_id']);
                    }
                }else{
                    if($list[$k]['mp_u_id'] == $adminid &&  $list[$k]['mp_utype'] == 2 && $list[$k]['mp_ultype'] == 1){
                        $list[$k]['nickname'] = $msg->getUserNick($v['mp_ul_id']);
                        $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_ul_id']);
                    }
                    if($list[$k]['mp_ul_id'] == $adminid &&  $list[$k]['mp_utype'] == 1 && $list[$k]['mp_ultype'] == 2){
                        $list[$k]['nickname'] = $msg->getUserNick($v['mp_u_id']);
                        $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_u_id']);
                    }

                }

                $list[$k]['count'] = $this->getUnread($v['mp_id'],$adminid);
            }
        }
        //dump($list);
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $list;
        $res['count'] = $count;
        $res['where'] = $where;
        return json($res);
    }

    public function delmsg(){
        $mp_id = intval(trim($this->request->param('mpid')));
        $msgList = Db::table('xcx_msg_person')
            ->where(['mp_id' => $mp_id])
            ->update(['mp_isable' =>2]);
        Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mp_id,'xcx_msg_isable' =>1])
            ->update(['xcx_msg_isable' =>2]);
        if($msgList){
            $this->success('删除成功！','msgs');
        }else{
            $this->error('删除失败！','msgs');
        }
    }


    public function sendmsg(){
        $mpid = trim($this->request->param('mpid','1','intval'));
        $content = trim($this->request->param('content'));
        $uId = session('adminId');
        //消息接受者信息
        $ulInfo = $this->getUlidAndType($mpid,$uId);
        $data['xcx_msg_mp_id'] = $mpid;
        $data['xcx_msg_uid'] = $uId;
        $data['xcx_msg_ul_id'] = $ulInfo['ul_id'];
        $data['xcx_msg_ul_type'] = $ulInfo['ul_type'];
        //后端发送
        $data['xcx_msg_u_type'] = 2;
        $data['xcx_msg_content'] = $content;
        date_default_timezone_set("Australia/Melbourne");
        $data['xcx_msg_add_time'] = date('Y-m-d H:i:s');
        $datas['mp_mod_time'] = date('Y-m-d H:i:s');
        $sendMsg = Db::table('xcx_msg_content')->insertGetId($data);
        //更新会话修改时间
        Db::table('xcx_msg_person')->where(['mp_id' => $mpid])->update($datas);
    }

    public function getUlidAndType($mpid,$uId){
        $ulInfo = Db::table('xcx_msg_person')->where(['mp_id' => $mpid])->find();
        //是否绑定前端用户
        $isUser = $this->isBendUser($uId);
        if($isUser){
            if($ulInfo['mp_u_id'] == $isUser){
                $res['ul_id'] = $ulInfo['mp_ul_id'];
                $res['ul_type'] = $ulInfo['mp_ultype'];
            }else{
                $res['ul_id'] = $ulInfo['mp_u_id'];
                $res['ul_type'] = $ulInfo['mp_utype'];
            }
        }else{
            if($ulInfo['mp_u_id'] == $uId){
                $res['ul_id'] = $ulInfo['mp_ul_id'];
                $res['ul_type'] = $ulInfo['mp_ultype'];
            }else{
                $res['ul_id'] = $ulInfo['mp_u_id'];
                $res['ul_type'] = $ulInfo['mp_utype'];
            }
        }
        return $res;
    }
    public function admin(){
        $id = $this->request->param('id',22,'intval');
        $role_id = $this->request->param('role_id',0,'intval');
        $role_id = $role_id == 0 ? 1 : 0;
        $del = Db::table('tk_user')
            ->where(['id' => $id])
            ->update(['role_id' => $role_id]);
        if($del){
            $this->success('修改成功！','index');
        }else{
            $this->error('修改失败！','index');
        }
    }

    public function newui(){
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',20,'intval');
        $adminid = session('adminId');
        $adWechat = session('ad_wechat');
        $where = "(mp_u_id = ".$adminid." and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = ".$adminid." and mp_ultype = 2 and  mp_isable = 1)";
        if($adWechat){
            $where .= " or (mp_u_id = ".$adWechat." and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = ".$adWechat." and mp_ultype = 1 and  mp_isable = 1)";
        }
        $list = Db::table('xcx_msg_person')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('mp_mod_time desc')
            ->select();
        $count=Db::table('xcx_msg_person')
            ->where($where)
            ->count();
        $msg = new Loops();
        if($list){
            foreach ($list as $k => $v){
                if($list[$k]['mp_u_id'] == $adminid &&  $list[$k]['mp_ultype'] == 1){
                    $list[$k]['nickname'] = $msg->getUserNick($v['mp_ul_id']);
                    $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_ul_id']);
                }elseif($list[$k]['mp_u_id'] == $adWechat && $list[$k]['mp_ultype'] == 2){
                    $list[$k]['nickname'] = $msg->getAdminNick($v['mp_ul_id']);
                    $list[$k]['avaurl'] = $msg->getAdminAvatar($v['mp_ul_id']);
                }else{
                    $list[$k]['nickname'] = $msg->getUserNick($v['mp_u_id']);
                    $list[$k]['avaurl'] = $msg->getUserAvatar($v['mp_u_id']);
                }
                $list[$k]['count'] = $this->getUnread($v['mp_id'],$adminid);
            }
        }
        $avatar = $msg->getAdminAvatar($adminid);
        $nickname = $msg->getAdminNick($adminid);
        $this->assign('avatar',$avatar);
        $this->assign('nickname',$nickname);
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function getmsgcon(){
        $mpid = trim($this->request->param('mp_id',0,'intval'));
        $uId = session('adminId');
        //是否绑定前端用户
        $isUser = $this->isBendUser($uId);
        $mpinfo = Db::table('xcx_msg_person')->where(['mp_id' => $mpid])->find();
        //dump($mpinfo);
        $loop = new Loops();
        //绑定了前端用户
        //绑定了前端用户
        //dump('当前admin'.$uId);
        //dump('admin绑定的user'.$isUser);
        if($isUser){
            $ulId = $mpinfo['mp_u_id'] == $isUser ? $mpinfo['mp_ul_id'] : $mpinfo['mp_u_id'];
            //dump($ulId);
            if($mpinfo['mp_ul_id'] == $uId && $mpinfo['mp_ultype'] == 2){
                //说明对方是user
                //dump('说明对方是user');
                $uavatar = $loop->getUserAvatar($ulId);
                $unickname = $loop->getUserNick($ulId);
            }
            if($mpinfo['mp_u_id'] == $isUser && $mpinfo['mp_ultype'] == 2){
                //说明对方是admin
                //dump('说明对方是admin');
                $uavatar = $loop->getAdminAvatar($ulId);
                $unickname = $loop->getAdminNick($ulId);
            }
            if($mpinfo['mp_ul_id'] == $isUser && $mpinfo['mp_ultype'] == 1){
                $uavatar = $loop->getUserAvatar($ulId);
                $unickname = $loop->getUserNick($ulId);
            }
            if($mpinfo['mp_u_id'] == $uId && $mpinfo['mp_utype'] == 2){
                //dump('说明对方是user');
                $ulId = $mpinfo['mp_ul_id'];
                $uavatar = $loop->getUserAvatar($ulId);
                $unickname = $loop->getUserNick($ulId);
            }
        }else{
            //没有绑定前端用户
            $ulId = $mpinfo['mp_u_id'] == $uId ? $mpinfo['mp_ul_id'] : $mpinfo['mp_u_id'];
            if($mpinfo['mp_ul_id'] == $uId &&  $mpinfo['mp_ultype'] == 2 &&  $mpinfo['mp_utype'] == 2){
                $uavatar = $loop->getAdminAvatar($ulId);
                $unickname = $loop->getAdminNick($ulId);
            }
            if($mpinfo['mp_ul_id'] == $uId &&  $mpinfo['mp_ultype'] == 2 &&  $mpinfo['mp_utype'] == 1){
                $uavatar = $loop->getUserAvatar($ulId);
                $unickname = $loop->getUserNick($ulId);
            }
        }
        //不管有没有绑定前端用户 我的头像都是admin_id
        $avatar = $loop->getAdminAvatar($uId);
        $nickname = $loop->getAdminNick($uId);
        Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpid,'xcx_msg_isable' =>1])
            ->update(['xcx_msg_isread' => 1]);
        $msgList = Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpid,'xcx_msg_isable' =>1])
            ->order('xcx_msg_add_time')
            ->select();
        $user['unickname']=$unickname;
        $user['uavatar']=$uavatar;
        $user['avatar']=$avatar;
        $user['nickname']=$nickname;
        if($msgList){
            foreach ($msgList  as $k => $v){
                if($isUser){
                    if($uId == $v['xcx_msg_uid'] || $isUser == $v['xcx_msg_uid']){
                        $msgList[$k]['postit'] = 'message-r';
                    }else{
                        $msgList[$k]['postit'] = 'message-l';
                    }
                }else{
                    $msgList[$k]['postit'] = $uId == $v['xcx_msg_uid'] ? 'message-r': 'message-l';
                }
            }
            return json(['code' => 1 ,'msg' => '读取成功！','data' => $msgList,'user' => $user]);
        }else{
            $msgList = null;
            return json(['code' => 0 ,'msg' => '读取失败！','data' => $msgList,'user' => $user]);
        }
    }

}