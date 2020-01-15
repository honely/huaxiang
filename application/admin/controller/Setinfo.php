<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/4/18
 * Time: 11:04
 */
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Setinfo extends Controller
{
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
    //配置信息列表
    public function setData(){
        $count=Db::table('super_setinfo')->count();
        $setInfo=Db::table('super_setinfo')
            ->where('s_type = 0')
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

    public function setlist(){
        return $this->fetch();
    }



    //更改是否显示的状态
    public function setstatus(){
        $ba_id = $_GET['s_id'];
        $change = $_GET['change'];
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '显示';
                $data['s_is_able'] = '1';
            }else{
                $msg = '隐藏';
                $data['s_is_able'] = '2';
            }
            $changeStatus = Db::table('super_setinfo')->where(['s_id' => $ba_id])->update($data);
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



    //添加配置信息；
    public function addset(){
        if($_POST){
            $data['s_key']=$_POST['s_key'];
            $data['s_value']=$_POST['s_value'];
            $data['s_desc']=$_POST['s_desc'];
            $data['s_is_able']=$_POST['s_is_able'];
            $data['s_type']=0;
            $data['s_opeatime']=time();
            $data['s_admin']=session('adminId');
            $addSet=Db::table('super_setinfo')->insert($data);
            if($addSet){
                $this->success('添加成功！','setlist');
            }else{
                $this->error('添加失败！','setlist');
            }
        }else{
            return $this->fetch();
        }
    }

    //修改信息配置：
    public function editSet(){
        $s_id=intval($_GET['s_id']);
        $type=intval($_GET['type']);
        if($_POST){
            $data['s_key']=$_POST['s_key'];
            $data['s_value']=$_POST['s_value'];
            $data['s_is_able']=$_POST['s_is_able'];
            $data['s_desc']=$_POST['s_desc'];
            $data['s_opeatime']=time();
            $data['s_admin']=session('adminId');
            $edit=Db::table('super_setinfo')->where(['s_id' => $s_id])->update($data);
            $s_type=Db::table('super_setinfo')->where(['s_id' => $s_id])->find();
            if($s_type['s_type'] == 1){
                if($edit){
                    $this->success('修改信息成功！','msg/msg');
                }else{
                    $this->error('未做任何修改！','msg/msg');
                }
            }else{
                if($edit){
                    $this->success('修改信息成功！','setlist');
                }else{
                    $this->error('未做任何修改！','setlist');
                }
            }
        }else{
            $setInfo=Db::table('super_setinfo')->where(['s_id' => $s_id])->find();
            $this->assign('type',$type);
            $this->assign('set',$setInfo);
            return $this->fetch();
        }
    }

    //删除配置
    public function delSet(){
        $s_id=intval($_GET['s_id']);
        $delSet=Db::table('super_setinfo')->where(['s_id' => $s_id])->delete();
        if($delSet){
            $this->success('删除配置成功！','setlist');
        }else{
            $this->error('删除配置失败！','setlist');
        }
    }
































    //分站列表
    public function branchData(){
        $ad_role=intval(session('ad_role'));
        //分站id
        $ad_branch = intval(session('ad_branch'));
        if($ad_role == 1 ){// 超级管理员
            $where = ' 1 = 1 ';
        }else{
            $where= ' b_id = '.$ad_branch;
        }
        $count=Db::table('super_branch')
            ->join('super_province','super_province.p_id = super_branch.b_province')
            ->join('super_city','super_city.c_id = super_branch.b_city')
            ->where($where)
            ->count();
        $branch=Db::table('super_branch')
            ->join('super_province','super_province.p_id = super_branch.b_province')
            ->join('super_city','super_city.c_id = super_branch.b_city')
            ->where($where)
            ->order('b_id desc')
            ->select();
        foreach($branch as $k =>$v){
            $branch[$k]['b_createtime']=date('Y-m-d',$v['b_createtime']);
            $branch[$k]['c_name']=$v['p_name']."-".$v['c_name'];
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $branch;
        $res['count'] = $count;
        return json($res);
    }



    public function branch(){
        $ad_role=intval(session('ad_role'));
        //分站id
        $all=Db::table('super_branch')->count();
        $this->assign('all',$all);
        $this->assign('ad_role',$ad_role);
        return $this->fetch();
    }


    //更改是否显示的状态
    public function status(){
        $ba_id = $_GET['b_id'];
        $change = $_GET['change'];
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '开通';
                $data['b_isopen'] = '1';
            }else{
                $msg = '关闭';
                $data['b_isopen'] = '2';
            }
            $changeStatus = Db::table('super_branch')->where(['b_id' => $ba_id])->update($data);
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
    //更改是否显示的状态
    public function autoSms(){
        $ba_id = $_GET['b_id'];
        $change = $_GET['change'];
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '开启';
                $data['b_autosms'] = '1';
            }else{
                $msg = '关闭';
                $data['b_autosms'] = '2';
            }
            $changeStatus = Db::table('super_branch')->where(['b_id' => $ba_id])->update($data);
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





    //添加分站信息；
    public function addBranch(){
        if($_POST){
            $stime=strtotime(date('Y-m-d 00:00:00'));
            $etime=strtotime(date('Y-m-d 23:59:59'));
            //获取当日预约的数量
            $buNum=Db::table('super_branch')->where('b_createtime','between',[$stime,$etime])->count();
            //生成用户编号；
            $data['b_bid'] = date('Ymd').sprintf("%04d", $buNum+1);
            $data['b_name']=$_POST['b_name'];
            $data['b_logo']=$_POST['b_logo'];
            $data['b_logo_alt']=$_POST['b_logo_alt'];
            $data['b_prex']=$_POST['b_prex'];
            $data['b_tel']=$_POST['b_tel'];
            $data['b_weichat']=$_POST['b_weichat'];
            $data['b_weibo']=$_POST['b_weibo'];
            $data['b_province']=$_POST['b_province'];
            $data['b_city']=$_POST['b_city'];
            $data['b_address']=$_POST['b_address'];
            $data['b_location']=$_POST['b_location'];
            $data['b_thridcode']=$_POST['b_thridcode'];
            $data['b_serviceurl']=$_POST['b_serviceurl'];
            $data['b_adminphone']=$_POST['b_adminphone'];
            $data['b_codecount']=$_POST['b_codecount'];
            $data['b_othercode']=$_POST['b_othercode'];
            $data['b_createtime']=strtotime($_POST['b_createtime'].' 12:12:21');
            $data['b_isopen']=$_POST['b_isopen'];
            $data['b_sign']=$_POST['b_sign'];
            $data['b_quote']=$_POST['b_quote'];
            $data['b_order']=$_POST['b_order'];
            $data['b_activity']=$_POST['b_activity'];
            $data['b_design']=$_POST['b_design'];
            $data['b_measure']=$_POST['b_measure'];
            $data['b_admin_tem']=$_POST['b_admin_tem'];
            $addBase=Db::table('super_branch')->insert($data);
            if($addBase){
                $this->success('站点信息添加成功！','branch');
            }else{
                $this->success('站点添加失败！','branch');
            }
        }else{
            //短信签名
            $sign=Db::table('super_alisign')->where(['ali_sign_able' => 1])->select();
            $this->assign('sign',$sign);
            //管理员通知模板
            $adminTem=Db::table('super_smstem')->where(['sms_type' => 1])->select();
            $this->assign('adminTem',$adminTem);
              //2.普通预约
            $orderTem=Db::table('super_smstem')->where(['sms_type' => 2])->select();
            $this->assign('orderTem',$orderTem);
              //3报价预约
            $quoteTem=Db::table('super_smstem')->where(['sms_type' => 3])->select();
            $this->assign('quoteTem',$quoteTem);
              //4量房预约
            $measureTem=Db::table('super_smstem')->where(['sms_type' => 4])->select();
            $this->assign('measureTem',$measureTem);
              //5活动预约
            $activityTem=Db::table('super_smstem')->where(['sms_type' => 5])->select();
            $this->assign('activityTem',$activityTem);
              //6设计预约
            $designTem=Db::table('super_smstem')->where(['sms_type' => 6])->select();
            $this->assign('designTem',$designTem);
            //省份
            $provInfo=Db::table('super_province')->select();
            $this->assign('prov',$provInfo);
            return $this->fetch();
        }
    }

    //修改站点信息
    public function editBranch(){
        $branch_id=intval($_GET['b_id']);
        if($_POST){
            $data['b_name']=$_POST['b_name'];
            $data['b_logo']=$_POST['b_logo'];
            $data['b_logo_alt']=$_POST['b_logo_alt'];
            $data['b_prex']=$_POST['b_prex'];
            $data['b_tel']=$_POST['b_tel'];
            $data['b_weichat']=$_POST['b_weichat'];
            $data['b_weibo']=$_POST['b_weibo'];
            $data['b_province']=$_POST['b_province'];
            $data['b_city']=$_POST['b_city'];
            $data['b_address']=$_POST['b_address'];
            $data['b_location']=$_POST['b_location'];
            $data['b_thridcode']=$_POST['b_thridcode'];
            $data['b_serviceurl']=$_POST['b_serviceurl'];
            $data['b_adminphone']=$_POST['b_adminphone'];
            $data['b_codecount']=$_POST['b_codecount'];
            $data['b_othercode']=$_POST['b_othercode'];
            $data['b_createtime']=strtotime($_POST['b_createtime'].' 12:12:21');
            $data['b_isopen']=$_POST['b_isopen'];
            $data['b_sign']=$_POST['b_sign'];
            $data['b_quote']=$_POST['b_quote'];
            $data['b_order']=$_POST['b_order'];
            $data['b_activity']=$_POST['b_activity'];
            $data['b_design']=$_POST['b_design'];
            $data['b_measure']=$_POST['b_measure'];
            $data['b_admin_tem']=$_POST['b_admin_tem'];
            $editBranch=Db::table('super_branch')->where(['b_id' =>$branch_id])->update($data);
            if($editBranch){
                $this->success('修改成功','branch');
            }else{
                $this->error('修改失败','branch');
            }
        }else{
            //短信签名
            $sign=Db::table('super_alisign')->where(['ali_sign_able' => 1])->select();
            $this->assign('sign',$sign);
            //管理员通知模板
            $adminTem=Db::table('super_smstem')->where(['sms_type' => 1])->select();
            $this->assign('adminTem',$adminTem);
            //2.普通预约
            $orderTem=Db::table('super_smstem')->where(['sms_type' => 2])->select();
            $this->assign('orderTem',$orderTem);
            //3报价预约
            $quoteTem=Db::table('super_smstem')->where(['sms_type' => 3])->select();
            $this->assign('quoteTem',$quoteTem);
            //4量房预约
            $measureTem=Db::table('super_smstem')->where(['sms_type' => 4])->select();
            $this->assign('measureTem',$measureTem);
            //5活动预约
            $activityTem=Db::table('super_smstem')->where(['sms_type' => 5])->select();
            $this->assign('activityTem',$activityTem);
            //6设计预约
            $designTem=Db::table('super_smstem')->where(['sms_type' => 6])->select();
            $this->assign('designTem',$designTem);
            $branchInfo=Db::table('super_branch')->where(['b_id' =>$branch_id])->find();
            $branchInfo['b_createtime']=date('Y-m-d',$branchInfo['b_createtime']);
            $provInfo=Db::table('super_province')->select();
            $provid=$branchInfo['b_province'];
            $cusCity=Db::table('super_city')->where(['p_id' => $provid])->select();
            $this->assign('prov',$provInfo);
            $this->assign('cusCity',$cusCity);
            $this->assign('branch',$branchInfo);
            return $this->fetch();
        }
    }

    //修改站点扩展信息
    public function extedit(){
        $branch_id=$_GET['b_id'];
        $data['b_title']=$_POST['b_title'];
        $data['b_keywords']=$_POST['b_keywords'];
        $data['b_desc']=$_POST['b_desc'];
        $data['b_codecount']=$_POST['b_codecount'];
        $data['b_thridcode']=$_POST['b_thridcode'];
        $data['b_serviceurl']=$_POST['b_serviceurl'];
        $updateExt=Db::table('super_branch')->where(['b_id' => $branch_id])->update($data);
        if($updateExt){
            $this->success('修改扩展信息成功!');
        }else{
            $this->error('修改扩展信息失败！');
        }
    }
    //删除某一站点
    public function delBranch(){
        $branch_id=intval($_GET['b_id']);
        $delBranch=Db::table('super_branch')->where(['b_id'=> $branch_id])->delete();
        if($delBranch){
            $this->success('删除成功','branch');
        }else{
            $this->error('删除失败','branch');
        }
    }

    public function typeList(){
        return $this->fetch();
    }
    public function userTip(){
        $count =Db::table('super_type')->where(['type_sort' => 1])->count();
        $userTip=Db::table('super_type')
            ->order('type_isable asc,type_order desc')
            ->where(['type_sort' => 1])
            ->select();
        foreach($userTip as $k =>$v){
            $userTip[$k]['type_addtime']=date('Y-m-d H:i:s',$v['type_addtime']);
            //操作人员对应当前登录的管理员
            if(!empty($v['type_admin']) && is_int($v['type_admin'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['type_admin']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $userTip[$k]['type_admin']= $adName;
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $userTip;
        $res['count'] = $count;
        return json($res);
    }

    //更改是否显示的状态
    public function userStatus(){
        $ba_id = $_GET['type_id'];
        $change = $_GET['change'];
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '显示';
                $data['type_isable'] = '1';
                $data['type_admin'] = session('adminId');
            }else{
                $msg = '隐藏';
                $data['type_isable'] = '2';
                $data['type_admin'] = session('adminId');
            }
            $changeStatus = Db::table('super_type')->where(['type_id' => $ba_id])->update($data);
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



    //修改排序
    public function reOrder(){
        $ba_id=$_POST['type_id'];
        $ba_order=intval(trim($_POST['value']));
        if(!empty($ba_order)){
            $reOrder=Db::table('super_type')->where(['type_id' => $ba_id])->update(['type_order' => $ba_order]);
            if($reOrder){
                $this->success('修改排序成功！');
            }else{
                $this->error('修改排序失败！');
            }
        }else{
            $this->error('请输入一个整数数字！');
        }
    }



    public function decStyle(){
        return $this->fetch();
    }
    public function styleData(){
        $count =Db::table('super_type')->where(['type_sort' => 2])->count();
        $userTip=Db::table('super_type')
            ->order('type_isable asc,type_order desc')
            ->where(['type_sort' => 2])
            ->select();
        foreach($userTip as $k =>$v){
            $userTip[$k]['type_addtime']=date('Y-m-d H:i:s',$v['type_addtime']);
            //操作人员对应当前登录的管理员
            if(!empty($v['type_admin']) && is_int($v['type_admin'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['type_admin']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $userTip[$k]['type_admin']= $adName;
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $userTip;
        $res['count'] = $count;
        return json($res);
    }
    //类型列表
    public function typeList123(){
        //类型参数
        $typeInfo=Db::table('super_type')
            ->order('type_id desc')
            ->where(['type_sort' => 1])
            ->select();
        //装修风格
        $styleInfo=Db::table('super_type')
            ->order('type_id desc')
            ->where(['type_sort' => 2])
            ->select();
        //装修品质
        $qualityInfo=Db::table('super_type')
            ->order('type_id desc')
            ->where(['type_sort' => 3])
            ->select();
        //房屋类型
        $houseInfo=Db::table('super_type')
            ->order('type_id desc')
            ->where(['type_sort' => 4])
            ->select();
        //房屋面积
        $areaInfo=Db::table('super_type')
            ->order('type_id desc')
            ->where(['type_sort' => 5])
            ->select();
        $this->assign('qualityInfo',$qualityInfo);
        $this->assign('styleInfo',$styleInfo);
        $this->assign('typeInfo',$typeInfo);
        $this->assign('houseInfo',$houseInfo);
        $this->assign('areaInfo',$areaInfo);
        return $this->fetch();
    }
    public function decLevel(){
        return $this->fetch();
    }
    public function levelData(){
        $count =Db::table('super_type')->where(['type_sort' => 3])->count();
        $userTip=Db::table('super_type')
            ->order('type_isable asc,type_order desc')
            ->where(['type_sort' => 3])
            ->select();
        foreach($userTip as $k =>$v){
            $userTip[$k]['type_addtime']=date('Y-m-d H:i:s',$v['type_addtime']);
            //操作人员对应当前登录的管理员
            if(!empty($v['type_admin']) && is_int($v['type_admin'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['type_admin']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $userTip[$k]['type_admin']= $adName;
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $userTip;
        $res['count'] = $count;
        return json($res);
    }
    public function houseType(){
        return $this->fetch();
    }
    public function houseData(){
        $count =Db::table('super_type')->where(['type_sort' => 2])->count();
        $userTip=Db::table('super_type')
            ->order('type_isable asc,type_order desc')
            ->where(['type_sort' => 2])
            ->select();
        foreach($userTip as $k =>$v){
            $userTip[$k]['type_addtime']=date('Y-m-d H:i:s',$v['type_addtime']);
            //操作人员对应当前登录的管理员
            if(!empty($v['type_admin']) && is_int($v['type_admin'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['type_admin']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $userTip[$k]['type_admin']= $adName;
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $userTip;
        $res['count'] = $count;
        return json($res);
    }
    public function houseArea(){
        return $this->fetch();
    }
    public function areaData(){
        $count =Db::table('super_type')->where(['type_sort' => 5])->count();
        $userTip=Db::table('super_type')
            ->order('type_isable asc,type_order desc')
            ->where(['type_sort' => 5])
            ->select();
        foreach($userTip as $k =>$v){
            $userTip[$k]['type_remarks']="￥".$v['type_remarks'];
            $userTip[$k]['type_addtime']=date('Y-m-d H:i:s',$v['type_addtime']);
            //操作人员对应当前登录的管理员
            if(!empty($v['type_admin']) && is_int($v['type_admin'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['type_admin']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $userTip[$k]['type_admin']= $adName;
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $userTip;
        $res['count'] = $count;
        return json($res);
    }


    public function from(){
        return $this->fetch();
    }
    public function fromData(){
        $count =Db::table('super_type')->where(['type_sort' => 5])->count();
        $userTip=Db::table('super_type')
            ->order('type_isable asc,type_order desc')
            ->where(['type_sort' => 6])
            ->select();
        foreach($userTip as $k =>$v){
            $userTip[$k]['type_addtime']=date('Y-m-d H:i:s',$v['type_addtime']);
            //操作人员对应当前登录的管理员
            if(!empty($v['type_admin']) && is_int($v['type_admin'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['type_admin']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $userTip[$k]['type_admin']= $adName;
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $userTip;
        $res['count'] = $count;
        return json($res);
    }


    public function origin(){
        return $this->fetch();
    }
    public function originData(){
        $count =Db::table('super_type')->where(['type_sort' => 5])->count();
        $userTip=Db::table('super_type')
            ->order('type_isable asc,type_order desc')
            ->where(['type_sort' => 7])
            ->select();
        foreach($userTip as $k =>$v){
            $userTip[$k]['type_addtime']=date('Y-m-d H:i:s',$v['type_addtime']);
            //操作人员对应当前登录的管理员
            if(!empty($v['type_admin']) && is_int($v['type_admin'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['type_admin']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $userTip[$k]['type_admin']= $adName;
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $userTip;
        $res['count'] = $count;
        return json($res);
    }



    /*
     * 添加房屋配置
     * */
    public function addConfig(){
        if($_POST){
            $data['type_sort']=2;
            $data['type_name']=trim($_POST['type_name']);
            $data['type_img']=trim($_POST['type_img']);
            $data['type_isable']=$_POST['type_isable'];
            $data['type_addtime']=time();
            $data['type_admin']=session('adminId');
            $addSet=Db::table('super_type')->insert($data);
            if($addSet){
                $this->success('添加成功！','houseType');
            }else{
                $this->error('添加失败！','houseType');
            }
        }else{
            return $this->fetch();
        }
    }

    /*
     *
     * 修改配置
     *
     */
    public function editConfig(){
        $type_id=intval($_GET['type_id']);
        if($_POST){
            $data['type_sort']=2;
            $data['type_name']=trim($_POST['type_name']);
            $data['type_img']=trim($_POST['type_img']);
            $data['type_isable']=$_POST['type_isable'];
            $data['type_addtime']=time();
            $data['type_admin']=session('adminId');
            $edit=Db::table('super_type')->where(['type_id' => $type_id])->update($data);
            if($edit){
                $this->success('修改成功！','houseType');
            }else{
                $this->error('修改失败！','houseType');
            }
        }else{
            $setInfo=Db::table('super_type')->where(['type_id' => $type_id])->find();
            $this->assign('conf',$setInfo);
            return $this->fetch();
        }
    }



















    //类型添加
    public function addType(){
        if($_POST){
            $type=$_GET['type'];
            $data['type_name']=$_POST['type_name'];
            if($type == 5){
                $data['type_remarks']=$_POST['minArea'].'-'.$_POST['maxArea'];
            }else{
                $data['type_remarks']=$_POST['type_remarks'];
            }
            if($type == 1){
                $data['type_sort']=1;
            }elseif($type == 2){
                $data['type_sort']=2;
            }elseif($type == 3){
                $data['type_sort']=3;
            }elseif($type == 4){
                $data['type_sort']=4;
            }elseif($type == 5){
                $data['type_sort']=5;
            }elseif($type == 6){
                $data['type_sort']=6;
            }elseif($type == 7){
                $data['type_sort']=7;
            }
            $data['type_isable']=$_POST['type_isable'];
            $data['type_addtime']=time();
            $data['type_admin'] = session('adminId');
            $addType=Db::table('super_type')->insert($data);
            if($addType){
                if($type == 1){
                    $this->success('添加房屋类型成功','typeList');
                }elseif($type == 2){
                    $this->success('添加装修风格成功','decStyle');
                }elseif($type == 3){
                    $this->success('添加装修品质成功','decLevel');
                }elseif($type == 4){
                    $this->success('添加房屋类型成功','houseType');
                }elseif($type == 5){
                    $this->success('添加租金范围成功','houseArea');
                }elseif($type == 6){
                    $this->success('添加推广来源成功','from');
                }elseif($type == 7){
                    $this->success('添加推广创意成功','origin');
                }
            }else{
                $this->error();
            }
        }else{
            //装修品质需要的站点名称
            $branchInfo=Db::table('super_branch')
                ->field('b_id,b_name')
                ->where(['b_isopen' => '1'])
                ->select();
            $type=$_GET['type'];
            $this->assign('branchInfo',$branchInfo);
            $this->assign('type',$type);
            return $this->fetch();
        }
    }

    //类型添加
    public function editType(){
        $typeId=intval($_GET['type_id']);
        $type=intval($_GET['type']);
        if($_POST){
            $data['type_name']=$_POST['type_name'];
            if($type == 5){
                $data['type_remarks']=$_POST['minArea'].'-'.$_POST['maxArea'];
            }else{
                $data['type_remarks']=$_POST['type_remarks'];
            }
            $data['type_isable']=$_POST['type_isable'];
            $data['type_addtime']=time();
            $data['type_admin'] = session('adminId');
            $addType=Db::table('super_type')->where(['type_id' => $typeId])->update($data);
            if($addType){
                if($type == 1){
                    $this->success('修改客户标记成功','typeList');
                }elseif($type == 2){
                    $this->success('修改装修风格成功','decStyle');
                }elseif($type == 3){
                    $this->success('修改装修品质成功','decLevel');
                }elseif($type == 4){
                    $this->success('修改房屋类型成功','houseType');
                }elseif($type == 5){
                    $this->success('修改房屋面积成功','houseArea');
                }elseif($type == 6){
                    $this->success('修改推广来源成功','from');
                }elseif($type == 7){
                    $this->success('添加推广创意成功','origin');
                }
            }else{
                $this->error();
            }
        }else{
            $typeInfo=Db::table('super_type')->where(['type_id' => $typeId])->find();
            if($type == 5){
                    $typeInfo['type_remarks']=explode('-',$typeInfo['type_remarks']);
            }
            if($typeInfo){
                $this->assign('type',$type);
                $this->assign('typeInfo',$typeInfo);
            }
            return $this->fetch();
        }
    }
    //删除一类型：
    public function delType(){
        $type_id=intval($_GET['type_id']);
        $delType=Db::table('super_type')->where(['type_id' =>$type_id])->delete();
        if($delType){
            $this->success('删除成功','typeList');
        }else{
            $this->success('删除失败','typeList');
        }
    }


    //图片上传的方法
    public function branchupload(){
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/branch');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/branch/".$path_date."/".$path_filename;
            // 成功上传后 返回上传信息
            return json(array('state'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
        }else{
            // 上传失败返回错误信息
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }

    //图片上传的方法
    public function upload(){
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/".$path_date."/".$path_filename;
            // 成功上传后 返回上传信息
            return json(array('state'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
        }else{
            // 上传失败返回错误信息
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }


}