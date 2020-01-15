<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21
 * Time: 11:26
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
class Msg extends Controller{
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


    public function msg(){
        return $this->fetch();
    }

    //短信基础配置
    public function setData(){
        $count=Db::table('super_setinfo')->where(['s_type' => 1])->count();
        $setInfo=Db::table('super_setinfo')
            ->where(['s_type' => 1])
            ->order('s_id desc')
            ->select();
        foreach($setInfo as $k =>$v){
            $setInfo[$k]['s_opeatime']=date('Y-m-d ',$v['s_opeatime']);
            if(!empty($v['s_admin']) && is_int($v['s_admin'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['s_admin']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $setInfo[$k]['s_admin']= $adName;
            if(!empty($v['s_opeatime']) && is_int($v['s_opeatime'])){
                $backtime = date('Y-m-d H:i:s',$v['s_opeatime']);
            }else{
                $backtime = "---";
            }
            $setInfo[$k]['s_opeatime']= $backtime;
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $setInfo;
        $res['count'] = $count;
        return json($res);
    }


    //短信签名
    public function msgsigns(){
        return $this->fetch();
    }

    //签名数据
    public function signData(){
        $ad_branch = intval(session('ad_branch'));
        $ad_role = intval(session('ad_role'));
        if($ad_role == 1 ){// 超级管理员
            $where=' 1 = 1 ';
        }else{
            $where=' ad_branch = '.$ad_branch;
        }
        if($ad_role == 6){ //站长
            $adminId=session('adminId');
            $where.=" and ad_id != ".$adminId;
        }
        $count=Db::table('super_alisign')
            ->join('super_admin','super_admin.ad_id = super_alisign.ali_sign_admin')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $sign=Db::table('super_alisign')
            ->join('super_admin','super_admin.ad_id = super_alisign.ali_sign_admin')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('ali_sign_id desc')
            ->select();
        foreach($sign as $k =>$v){
            $sign[$k]['ali_sign_addtime'] = date('Y-m-d H:i:s',$v['ali_sign_addtime']);
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $sign;
        $res['count'] = $count;
        return json($res);
    }
    //更改是否显示的状态
    public function status(){
        $ba_id = $_GET['sign_id'];
        $change = $_GET['change'];
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '显示';
                $data['ali_sign_able'] = '1';
            }else{
                $msg = '隐藏';
                $data['ali_sign_able'] = '2';
            }
            $changeStatus = Db::table('super_alisign')->where(['ali_sign_id' => $ba_id])->update($data);
            if($changeStatus){
                $res['code'] = 1;
                $res['msg'] = $msg.'成功！';
            }else{
                $res['code'] = 0;
                $res['msg'] = $msg.'失败！';
            }
        }else{
            $res['code'] = 0;
            $res['msg'] = '这是个意外！';
        }
        return $res;
    }
    //添加签名
    public function addSign(){
        if($_POST){
            $data['ali_sign_name']=$_POST['ali_sign_name'];
            $data['ali_sign_remarks']=$_POST['ali_sign_remarks'];
            $data['ali_sign_able']=$_POST['ali_sign_able'];
            $data['ali_sign_addtime']=time();
            $data['ali_sign_admin']=session('adminId');
            $add=Db::table('super_alisign')->insert($data);
            if($add){
                $this->success('添加短信签名成功！','msgsigns');
            }else{
                $this->error('添加短信签名失败！','msgsigns');
            }
        }else{
            return $this->fetch();
        }
    }

    //修改签名
    public function editSign(){
        $sign_id=intval($_GET['sign_id']);
        if($_POST){
            $data['ali_sign_name']=$_POST['ali_sign_name'];
            $data['ali_sign_remarks']=$_POST['ali_sign_remarks'];
            $data['ali_sign_able']=$_POST['ali_sign_able'];
            $data['ali_sign_addtime']=time();
            $data['ali_sign_admin']=session('adminId');
            $edit=Db::table('super_alisign')->where(['ali_sign_id' => $sign_id])->update($data);
            if($edit){
                $this->success('修改签名成功！','msgsigns');
            }else{
                $this->error('修改签名失败！','msgsigns');
            }
        }else{
            $signInfo=Db::table('super_alisign')->where(['ali_sign_id' => $sign_id])->find();
            $this->assign('sign',$signInfo);
            return $this->fetch();
        }
    }

    //删除一签名
    public function delSign(){
        $sign_id=intval($_GET['sign_id']);
        $del=Db::table('super_alisign')->where(['ali_sign_id' => $sign_id])->delete();
        if($del){
            $this->success('删除签名成功！','msgsigns');
        }else{
            $this->error('删除签名成功！','msgsigns');
        }
    }


    //短信模板
    public function msgtem(){
        return $this->fetch();
    }

    //短信模板数据
    public function temData(){
        $ad_branch = intval(session('ad_branch'));
        $ad_role = intval(session('ad_role'));
        if($ad_role == 1 ){// 超级管理员
            $where=' 1 = 1 ';
        }else{
            $where=' ad_branch = '.$ad_branch;
        }
        if($ad_role == 6){ //站长
            $adminId=session('adminId');
            $where.=" and ad_id != ".$adminId;
        }
        $count=Db::table('super_smstem')
            ->join('super_admin','super_admin.ad_id = super_smstem.sms_admin')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $sign=Db::table('super_smstem')
            ->join('super_admin','super_admin.ad_id = super_smstem.sms_admin')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('sms_id desc')
            ->select();
        foreach($sign as $k =>$v){
            $sign[$k]['sms_addtime'] = date('Y-m-d H:i:s',$v['sms_addtime']);
            $sms_type="";
            if($v['sms_type'] == 1){$sms_type="管理员通知";
            }elseif ($v['sms_type'] == 2){$sms_type="普通预约";
            }elseif ($v['sms_type'] == 3){$sms_type="报价预约";
            }elseif ($v['sms_type'] == 4){$sms_type="量房预约";
            }elseif ($v['sms_type'] == 5){$sms_type="活动预约";
            }elseif ($v['sms_type'] == 6){$sms_type="设计预约";}
            $sign[$k]['sms_type'] =$sms_type;
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $sign;
        $res['count'] = $count;
        return json($res);
    }

    //添加短信模板
    public function addTem(){
        if($_POST){
            $data['sms_title']=$_POST['sms_title'];
            $data['sms_code']=$_POST['sms_code'];
            $data['sms_content']=$_POST['sms_content'];
            $data['sms_remarks']=$_POST['sms_remarks'];
            $data['sms_type']=$_POST['sms_type'];
            $data['sms_addtime']=time();
            $data['sms_admin']=session('adminId');
            $add=Db::table('super_smstem')->insert($data);
            if($add){
                $this->success('添加模板成功！','msgtem');
            }else{
                $this->error('添加模板失败！','msgtem');
            }
        }else{
            return $this->fetch();
        }
    }

    //修改短信模板
    public function edittem(){
        $sign_id=intval($_GET['sms_id']);
        if($_POST){
            $data['sms_title']=$_POST['sms_title'];
            $data['sms_code']=$_POST['sms_code'];
            $data['sms_content']=$_POST['sms_content'];
            $data['sms_remarks']=$_POST['sms_remarks'];
            $data['sms_type']=$_POST['sms_type'];
            $data['sms_addtime']=time();
            $data['sms_admin']=session('adminId');
            $edit=Db::table('super_smstem')->where(['sms_id' => $sign_id])->update($data);
            if($edit){
                $this->success('修改模板成功！','msgtem');
            }else{
                $this->error('修改模板失败！','msgtem');
            }
        }else{
            $temInfo=Db::table('super_smstem')->where(['sms_id' => $sign_id])->find();
            $this->assign('tem',$temInfo);
            return $this->fetch();
        }
    }

    //删除一模板
    public function delTem(){
        $sms_id=intval($_GET['sms_id']);
        $del=Db::table('super_smstem')->where(['sms_id' => $sms_id])->delete();
        if($del){
            $this->success('删除模板成功！','msgtem');
        }else{
            $this->error('删除模板成功！','msgtem');
        }
    }
}