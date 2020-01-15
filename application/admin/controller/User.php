<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/4/18
 * Time: 14:02
 */
namespace app\admin\controller;
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

    //客户列表2018/06/20正在用的；
    public function user(){
        $where=" 1 = 1";
        //根据role_id 去判断这个登录的人是超管 1  ？站长 6？ 客服 8  ？ 推广 12 ；目前就是这4个身份；
        $ad_role=intval(session('ad_role'));
        //分站id
        $ad_branch = intval(session('ad_branch'));
        if($ad_role == 1 ){// 超级管理员
            $where.=' and cus_isdelete = 1';
        }else{
            $where='cus_isdelete = 1 and  cus_branchid = '.$ad_branch;
        }
        if($_POST){
            $keywords=trim($_POST['keywords']);
            $case_p_id=trim($_POST['case_p_id']);
            $bu_c_id=trim($_POST['bu_c_id']);
            $branch=trim($_POST['branch']);
            $cus_opptime=trim($_POST['cus_opptime']);
            $case_admin=intval(trim($_POST['case_admin']));
            if(isset($keywords) && !empty($keywords)){
                $where.=" and ( cus_name like '%".$keywords."%' or cus_phone like '%".$keywords."%' or cus_from like '%".$keywords."%' )";
            }
            if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
                $where.=" and cus_provid = ".$case_p_id;
            }
            if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
                $where.=" and cus_cityid = ".$bu_c_id;
            }
            if(isset($branch) && !empty($branch) && $branch){
                $where.=" and cus_branchid = ".$branch;
            }
            if(isset($case_admin) && !empty($case_admin)){
                $where.=" and cus_opeater = ".$case_admin;
            }
            if(isset($cus_opptime) && !empty($cus_opptime)){
                $sdate=strtotime(substr($cus_opptime,'0','10')." 00:00:00");
                $edate=strtotime(substr($cus_opptime,'-10')." 23:59:59");
                $where.=" and ( cus_opptime>= ".$sdate." and cus_opptime <= ".$edate." ) ";
            }
            //手机端
            $data['display']=Db::table('super_customer')
                ->join('super_province','super_customer.cus_provid = super_province.p_id')
                ->join('super_city','super_customer.cus_cityid = super_city.c_id')
                ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
                ->join('super_type','super_customer.cus_status = super_type.type_id')
                ->where($where)
                ->where(['cus_sys' => 1])
                ->count();
            //pc端
            $data['none']=Db::table('super_customer')
                ->join('super_province','super_customer.cus_provid = super_province.p_id')
                ->join('super_city','super_customer.cus_cityid = super_city.c_id')
                ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
                ->join('super_type','super_customer.cus_status = super_type.type_id')
                ->where($where)
                ->where(['cus_sys' => 2])
                ->count();
            $decStyle=Db::table('super_type')
                ->where(['type_sort' => '1','type_isable' => '1'])
                ->order('type_order desc')
                ->field('type_id,type_name')
                ->select();
            foreach($decStyle as $k =>$v){
                $decStyle[$k]['count']=Db::table('super_customer')
                    ->join('super_province','super_customer.cus_provid = super_province.p_id')
                    ->join('super_city','super_customer.cus_cityid = super_city.c_id')
                    ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
                    ->join('super_type','super_customer.cus_status = super_type.type_id')
                    ->where($where)
                    ->where(['cus_status' => $v['type_id']])
                    ->count();
            }
            $data['decStyle']=$decStyle;
            $data['all']=intval($data['display'])+intval($data['none']);
            return $data;
        }
        //获取客户标签
        $userTip=Db::table('super_type')
            ->where(['type_sort' => '1','type_isable' => '1'])
            ->order('type_order desc')
            ->field('type_id,type_name')
            ->select();
        foreach($userTip as $k =>$v){
            $userTip[$k]['count']=Db::table('super_customer')
                ->where($where)
                ->where(['cus_status' => $v['type_id'],'cus_isdelete' => 1])
                ->count();
        }
        $tipsConut=Db::table('super_customer')->where($where)->where(['cus_isdelete' => 1])->count();
        $this->assign('tipsConut',$tipsConut);
        $this->assign('userTip',$userTip);
        //操作人管理员
        $admin = Db::table('super_admin')->select();
        $this->assign('admin',$admin);
        $mobileCount=Db::table('super_customer')->where($where)->where(['cus_isdelete' => 1,'cus_sys' => 1])->count();
        $pcCount=Db::table('super_customer')->where($where)->where(['cus_isdelete' => 1,'cus_sys' => 2])->count();
        $this->assign('mobileCount',$mobileCount);
        $this->assign('pcCount',$pcCount);
        if($ad_role == 12 ){ //推广
            return $this->fetch('spread');
        }
        if($ad_role == 8 ){ // 客服
            return $this->fetch('cusservice');
        }
        $this->assign('ad_role',$ad_role);
        return $this->fetch();
    }



    //客服列表
    public function cusservice(){
        //根据role_id 去判断这个登录的人是超管 1  ？站长 6？ 客服 8  ？ 推广 12 ；目前就是这4个身份；
        $ad_role=intval(session('ad_role'));
        //分站id
        $ad_branch = intval(session('ad_branch'));
        $where='cus_isdelete = 1 and  cus_branchid = '.$ad_branch;
        if($_POST){
            $keywords=trim($_POST['keywords']);
            $case_p_id=trim($_POST['case_p_id']);
            $bu_c_id=trim($_POST['bu_c_id']);
            $branch=trim($_POST['branch']);
            $cus_opptime=trim($_POST['cus_opptime']);
            $case_admin=intval(trim($_POST['case_admin']));
            if(isset($keywords) && !empty($keywords)){
                $where.=" and ( cus_name like '%".$keywords."%' or cus_phone like '%".$keywords."%' or cus_from like '%".$keywords."%' )";
            }
            if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
                $where.=" and cus_provid = ".$case_p_id;
            }
            if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
                $where.=" and cus_cityid = ".$bu_c_id;
            }
            if(isset($branch) && !empty($branch) && $branch){
                $where.=" and cus_branchid = ".$branch;
            }
            if(isset($case_admin) && !empty($case_admin)){
                $where.=" and cus_opeater = ".$case_admin;
            }
            if(isset($cus_opptime) && !empty($cus_opptime)){
                $sdate=strtotime(substr($cus_opptime,'0','10')." 00:00:00");
                $edate=strtotime(substr($cus_opptime,'-10')." 23:59:59");
                $where.=" and ( cus_opptime>= ".$sdate." and cus_opptime <= ".$edate." ) ";
            }
            //手机端
            $data['display']=Db::table('super_customer')
                ->join('super_province','super_customer.cus_provid = super_province.p_id')
                ->join('super_city','super_customer.cus_cityid = super_city.c_id')
                ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
                ->join('super_type','super_customer.cus_status = super_type.type_id')
                ->where($where)
                ->where(['cus_sys' => 1])
                ->count();
            //pc端
            $data['none']=Db::table('super_customer')
                ->join('super_province','super_customer.cus_provid = super_province.p_id')
                ->join('super_city','super_customer.cus_cityid = super_city.c_id')
                ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
                ->join('super_type','super_customer.cus_status = super_type.type_id')
                ->where($where)
                ->where(['cus_sys' => 2])
                ->count();
            $decStyle=Db::table('super_type')
                ->where(['type_sort' => '1','type_isable' => '1'])
                ->order('type_order desc')
                ->field('type_id,type_name')
                ->select();
            foreach($decStyle as $k =>$v){
                $decStyle[$k]['count']=Db::table('super_customer')
                    ->join('super_province','super_customer.cus_provid = super_province.p_id')
                    ->join('super_city','super_customer.cus_cityid = super_city.c_id')
                    ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
                    ->join('super_type','super_customer.cus_status = super_type.type_id')
                    ->where($where)
                    ->where(['cus_status' => $v['type_id']])
                    ->count();
            }
            $data['decStyle']=$decStyle;
            $data['all']=intval($data['display'])+intval($data['none']);
            return $data;
        }
        //获取客户标签
        $userTip=Db::table('super_type')
            ->where(['type_sort' => '1','type_isable' => '1'])
            ->order('type_order desc')
            ->field('type_id,type_name')
            ->select();
        foreach($userTip as $k =>$v){
            $userTip[$k]['count']=Db::table('super_customer')
                ->where($where)
                ->where(['cus_status' => $v['type_id'],'cus_isdelete' => 1])
                ->count();
        }
        $tipsConut=Db::table('super_customer')->where($where)->where(['cus_isdelete' => 1])->count();
        $this->assign('tipsConut',$tipsConut);
        $this->assign('userTip',$userTip);
        //操作人管理员
        $admin = Db::table('super_admin')->select();
        $this->assign('admin',$admin);
        $mobileCount=Db::table('super_customer')->where($where)->where(['cus_isdelete' => 1,'cus_sys' => 1])->count();
        $pcCount=Db::table('super_customer')->where($where)->where(['cus_isdelete' => 1,'cus_sys' => 2])->count();
        $this->assign('mobileCount',$mobileCount);
        $this->assign('pcCount',$pcCount);
        $this->assign('ad_role',$ad_role);
        return $this->fetch();
    }

    //客服列表
    public function spread(){
        //根据role_id 去判断这个登录的人是超管 1  ？站长 6？ 客服 8  ？ 推广 12 ；目前就是这4个身份；
        $ad_role=intval(session('ad_role'));
        //分站id
        $ad_branch = intval(session('ad_branch'));
        $where='cus_isdelete = 1 and  cus_branchid = '.$ad_branch;
        if($_POST){
            $keywords=trim($_POST['keywords']);
            $case_p_id=trim($_POST['case_p_id']);
            $bu_c_id=trim($_POST['bu_c_id']);
            $branch=trim($_POST['branch']);
            $cus_opptime=trim($_POST['cus_opptime']);
            $case_admin=intval(trim($_POST['case_admin']));
            if(isset($keywords) && !empty($keywords)){
                $where.=" and ( cus_name like '%".$keywords."%' or cus_phone like '%".$keywords."%' or cus_from like '%".$keywords."%' )";
            }
            if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
                $where.=" and cus_provid = ".$case_p_id;
            }
            if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
                $where.=" and cus_cityid = ".$bu_c_id;
            }
            if(isset($branch) && !empty($branch) && $branch){
                $where.=" and cus_branchid = ".$branch;
            }
            if(isset($case_admin) && !empty($case_admin)){
                $where.=" and cus_opeater = ".$case_admin;
            }
            if(isset($cus_opptime) && !empty($cus_opptime)){
                $sdate=strtotime(substr($cus_opptime,'0','10')." 00:00:00");
                $edate=strtotime(substr($cus_opptime,'-10')." 23:59:59");
                $where.=" and ( cus_opptime>= ".$sdate." and cus_opptime <= ".$edate." ) ";
            }
            //手机端
            $data['display']=Db::table('super_customer')
                ->join('super_province','super_customer.cus_provid = super_province.p_id')
                ->join('super_city','super_customer.cus_cityid = super_city.c_id')
                ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
                ->join('super_type','super_customer.cus_status = super_type.type_id')
                ->where($where)
                ->where(['cus_sys' => 1])
                ->count();
            //pc端
            $data['none']=Db::table('super_customer')
                ->join('super_province','super_customer.cus_provid = super_province.p_id')
                ->join('super_city','super_customer.cus_cityid = super_city.c_id')
                ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
                ->join('super_type','super_customer.cus_status = super_type.type_id')
                ->where($where)
                ->where(['cus_sys' => 2])
                ->count();
            $decStyle=Db::table('super_type')
                ->where(['type_sort' => '1','type_isable' => '1'])
                ->order('type_order desc')
                ->field('type_id,type_name')
                ->select();
            foreach($decStyle as $k =>$v){
                $decStyle[$k]['count']=Db::table('super_customer')
                    ->join('super_province','super_customer.cus_provid = super_province.p_id')
                    ->join('super_city','super_customer.cus_cityid = super_city.c_id')
                    ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
                    ->join('super_type','super_customer.cus_status = super_type.type_id')
                    ->where($where)
                    ->where(['cus_status' => $v['type_id']])
                    ->count();
            }
            $data['decStyle']=$decStyle;
            $data['all']=intval($data['display'])+intval($data['none']);
            return $data;
        }
        //获取客户标签
        $userTip=Db::table('super_type')
            ->where(['type_sort' => '1','type_isable' => '1'])
            ->order('type_order desc')
            ->field('type_id,type_name')
            ->select();
        foreach($userTip as $k =>$v){
            $userTip[$k]['count']=Db::table('super_customer')
                ->where($where)
                ->where(['cus_status' => $v['type_id'],'cus_isdelete' => 1])
                ->count();
        }
        $tipsConut=Db::table('super_customer')->where($where)->where(['cus_isdelete' => 1])->count();
        $this->assign('tipsConut',$tipsConut);
        $this->assign('userTip',$userTip);
        //操作人管理员
        $admin = Db::table('super_admin')->select();
        $this->assign('admin',$admin);
        $mobileCount=Db::table('super_customer')->where($where)->where(['cus_isdelete' => 1,'cus_sys' => 1])->count();
        $pcCount=Db::table('super_customer')->where($where)->where(['cus_isdelete' => 1,'cus_sys' => 2])->count();
        $this->assign('mobileCount',$mobileCount);
        $this->assign('pcCount',$pcCount);
        $this->assign('ad_role',$ad_role);
        return $this->fetch();
    }











    //该方法暂时无效 2018-05-30
    //客户列表三可拖动列宽、左右有固定列、滑动表格数据，固定表头
    public function user1(){
        $ad_role=intval(session('ad_role'));
        //获取客户标签
        $userTip=Db::table('super_type')
            ->where(['type_sort' => '1','type_isable' => '1'])
            ->field('type_id,type_name')
            ->select();
        $provInfo=Db::table('super_province')->select();
        $this->assign('prov',$provInfo);
        //操作人管理员
        $admin = Db::table('super_admin')->select();
        $this->assign('admin',$admin);
        $this->assign('userTip',$userTip);
        if($ad_role == 12 ){ //推广
            return $this->fetch('spread');
        }
        if($ad_role == 8 ){ // 客服
            return $this->fetch('cusservice');
        }
        return $this->fetch();
    }
    //该方法暂时无效 2018-05-30
    //客户列表三可拖动列宽、左右有固定列、滑动表格数据，固定表头
    public function userData(){
        $where=" 1 = 1";
        //根据role_id 去判断这个登录的人是超管 1  ？站长 6？ 客服 8  ？ 推广 12 ；目前就是这4个身份；
        $ad_role=intval(session('ad_role'));
        //分站id
        $ad_branch = intval(session('ad_branch'));
        if($ad_role == 1 ){// 超级管理员
            $where.=' and cus_isdelete = 1';
        }else{
            $where='cus_isdelete = 1 and  cus_branchid = '.$ad_branch;
        }
        $keywords=trim($this->request->param('keywords'));
        $case_p_id=intval(trim($this->request->param('case_p_id')));
        $bu_c_id=intval(trim($this->request->param('bu_c_id')));
        $branch=intval(trim($this->request->param('branch')));
        $style_id=intval(trim($this->request->param('style_id')));
        $sys_id=intval(trim($this->request->param('sys_id')));
        $case_admin=intval(trim($this->request->param('case_admin')));
        $cus_opptime=$this->request->param('cus_opptime');


        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( cus_name like '%".$keywords."%' or cus_phone like '%".$keywords."%' or cus_from like '%".$keywords."%' )";
        }
        if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
            $where.=" and cus_provid = ".$case_p_id;
        }
        if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
            $where.=" and cus_cityid = ".$bu_c_id;
        }
        if(isset($branch) && !empty($branch) && $branch){
            $where.=" and cus_branchid = ".$branch;
        }
        if(isset($case_admin) && !empty($case_admin)){
            $where.=" and cus_opeater = ".$case_admin;
        }
        if(isset($style_id) && !empty($style_id) && $style_id){
            $where.=" and cus_status = ".$style_id;
        }
        if(isset($sys_id) && !empty($sys_id) && $sys_id){
            $where.=" and cus_sys = ".$sys_id;
        }
        if(isset($cus_opptime) && !empty($cus_opptime)){
            $sdate=strtotime(substr($cus_opptime,'0','10')." 00:00:00");
            $edate=strtotime(substr($cus_opptime,'-10')." 23:59:59");
            $where.=" and ( cus_opptime>= ".$sdate." and cus_opptime <= ".$edate." ) ";
        }
        //分页统计总数；
        $count=Db::table('super_customer')
            ->join('super_province','super_customer.cus_provid = super_province.p_id')
            ->join('super_city','super_customer.cus_cityid = super_city.c_id')
            ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
            ->join('super_type','super_customer.cus_status = super_type.type_id')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('super_customer')
            ->join('super_province','super_customer.cus_provid = super_province.p_id')
            ->join('super_city','super_customer.cus_cityid = super_city.c_id')
            ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
            ->join('super_type','super_customer.cus_status = super_type.type_id')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('cus_id desc')
            ->select();
        foreach($cusInfo as $k => $v){
            $cusInfo[$k]['c_name']=$v['p_name']."-".$v['c_name']."-".$v['b_name'];
			$cusInfo[$k]['cus_from']=$v['cus_from']."&nbsp;&nbsp;".$v['cus_origin'];
            $cusInfo[$k]['cus_link']=$v['cus_device']."&nbsp;&nbsp;".$v['cus_position']."<br/>".$v['cus_link'];
            $cusInfo[$k]['cus_opptime']=date('Y-m-d H:i:s',$v['cus_opptime']);
            //操作人员对应当前登录的管理员
            if(!empty($v['cus_opeater']) && is_int($v['cus_opeater'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['cus_opeater']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $cusInfo[$k]['ad_realname']= $adName;
            //操作时间
            if(!empty($v['cus_backtime']) && is_int($v['cus_backtime'])){
                $backtime = date('Y-m-d H:i:s',$v['cus_backtime']);
            }else{
                $backtime = "暂未回访";
            }
            $cusInfo[$k]['cus_backtime']= $backtime;
            if($ad_role == 12){
                $cusInfo[$k]['cus_phone'] = substr_replace($v['cus_phone'],'****',3,4);
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }
    //该方法暂时无效 2018-05-30
    public function user2(){
        //获取客户标签
        $userTip=Db::table('super_type')
            ->order('type_order desc')
            ->where(['type_sort' => '1','type_isable' => '1'])
            ->field('type_id,type_name')
            ->select();
        $provInfo=Db::table('super_province')->select();
        $this->assign('prov',$provInfo);
        $where=" 1 = 1";
        //根据role_id 去判断这个登录的人是超管 1  ？站长 6？ 客服 8  ？ 推广 12 ；目前就是这4个身份；
        $ad_role=intval(session('ad_role'));
        //分站id
        $ad_branch = intval(session('ad_branch'));
        if($ad_role == 1 ){// 超级管理员
            $where.=' and cus_isdelete = 1';
        }else{
            $where='cus_isdelete = 1 and  cus_branchid = '.$ad_branch;
        }
        $keywords=$this->request->param('keywords');
        $cus_status=$this->request->param('cus_status');
        $cus_sys=$this->request->param('cus_sys');
        $case_p_id=$this->request->param('case_p_id');
        $bu_c_id=$this->request->param('bu_c_id');
        $branch=$this->request->param('branch');
        $case_admin=$this->request->param('case_admin');
        $cus_opptime=$this->request->param('cus_opptime');
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( cus_name like '%".$keywords."%' or cus_phone like '%".$keywords."%' )";
        }
        if(isset($cus_status) && !empty($cus_status)){
            $where.=" and cus_status = ".$cus_status;
        }
        if(isset($cus_sys) && !empty($cus_sys)){
            $where.=" and cus_sys = ".$cus_sys;
        }
        if(isset($case_p_id) && !empty($case_p_id)){
            $where.=" and cus_provid = ".$case_p_id;
        }
        if(isset($bu_c_id) && !empty($bu_c_id)){
            $where.=" and cus_cityid = ".$bu_c_id;
        }
        if(isset($branch) && !empty($branch)){
            $where.=" and cus_branchid = ".$branch;
        }
        if(isset($case_admin) && !empty($case_admin)){
            $where.=" and cus_opeater = ".$case_admin;
        }
        if(isset($cus_opptime) && !empty($cus_opptime)){
            $sdate=strtotime(substr($cus_opptime,'0','10')." 00:00:00");
            $edate=strtotime(substr($cus_opptime,'-10')." 23:59:59");
            $where.=" and ( cus_opptime>= ".$sdate." and cus_opptime <= ".$edate." ) ";
        }
        //分页统计总数；
        $count=Db::table('super_customer')
            ->join('super_province','super_customer.cus_provid = super_province.p_id')
            ->join('super_city','super_customer.cus_cityid = super_city.c_id')
            ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
            ->join('super_type','super_customer.cus_status = super_type.type_id')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('super_customer')
            ->join('super_province','super_customer.cus_provid = super_province.p_id')
            ->join('super_city','super_customer.cus_cityid = super_city.c_id')
            ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
            ->join('super_type','super_customer.cus_status = super_type.type_id')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('cus_id desc')
            ->select();
        foreach($cusInfo as $k => $v){
            $cusInfo[$k]['cus_opptime']=date('Y-m-d H:i:s',$v['cus_opptime']);
            //操作人员对应当前登录的管理员
            if(!empty($v['cus_opeater']) && is_int($v['cus_opeater'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['cus_opeater']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $cusInfo[$k]['ad_realname']= $adName;
            //操作时间
            if(!empty($v['cus_backtime']) && is_int($v['cus_backtime'])){
                $backtime = date('Y-m-d H:i:s',$v['cus_backtime']);
            }else{
                $backtime = "暂未回访";
            }
            $cusInfo[$k]['cus_backtime']= $backtime;
            $cusInfo[$k]['cus_sys']=$v['cus_sys'] == 1  ? '手机端': 'PC端';
            if($ad_role == 12){
                $cusInfo[$k]['cus_phone'] = substr_replace($v['cus_phone'],'****',3,4);
            }
            //入库链接显示
            $cusInfo[$k]['cus_link']=explode('/',$v['cus_link']);
        }
        dump($cusInfo);
        //操作人管理员
        $admin = Db::table('super_admin')->select();
        $this->assign('admin',$admin);
        $this->assign('count',$count);
        $this->assign('limit',$limit);
        $this->assign('page',$page);
        $this->assign('userTip',$userTip);
        $this->assign('ad_role',$ad_role);
        $this->assign('cusInfo',$cusInfo);
        if($ad_role == 12 ){ //推广
            return $this->fetch('spread');
        }
        if($ad_role == 8 ){ // 客服
            return $this->fetch('cusservice');
        }
        return $this->fetch();
    }









































    public function details(){
        $ad_role=intval(session('ad_role'));
        $cus_id=intval($_GET['user_id']);
        //获取客户信息；
        $cusInfo=Db::table('super_customer')->where(['cus_id' => $cus_id])->find();
        //用户系统
        if($cusInfo['cus_sys'] == '1'){
            $cusInfo['cus_sys']='手机端';
        }elseif ($cusInfo['cus_sys'] == '2'){
            $cusInfo['cus_sys']='PC端';
        }
        if($ad_role == 12){
            $cusInfo['cus_phone']=substr_replace($cusInfo['cus_phone'],'****',3,5);
        }
        $cusInfo['cus_opptime']=date('Y-m-d H:i',$cusInfo['cus_opptime']);
        $cus_provid=$cusInfo['cus_provid'];
        $cusCity=Db::table('super_city')->where(['p_id' => $cus_provid])->select();
        //获取客户标签
        $userTip=Db::table('super_type')
            ->where(['type_sort' => '1','type_isable' => '1'])
            ->field('type_id,type_name')
            ->select();
        $provInfo=Db::table('super_province')->select();

        //获取装修品质：
        $decLevel=Db::table('super_type')
            ->where(['type_sort' => '3','type_isable' => '1'])
            ->select();
        //获取装修风格：
        $decStyle=Db::table('super_type')
            ->where(['type_sort' => '2','type_isable' => '1'])
            ->select();
        $this->assign('ad_role',$ad_role);
        $this->assign('level',$decLevel);
        $this->assign('style',$decStyle);
        $this->assign('prov',$provInfo);
        $this->assign('userTip',$userTip);
        $this->assign('cus',$cusInfo);
        $this->assign('cusCity',$cusCity);
        return $this->fetch();
    }

    //修改客户信息
    public function editUser(){
        $cus_id=intval($_GET['cus_id']);
        $data=$_POST;
        $data['cus_opeater'] = session('adminId');
        $data['cus_backtime'] =time();
        $editCus=Db::table('super_customer')->where(['cus_id' => $cus_id])->update($data);
        if($editCus){
            $this->success('修改成功','user');
        }else{
            $this->error('修改失败','user');
        }
    }

    //删除某一客户、
    public function delUser(){
        $data['cus_opeater'] = session('adminId');
        $data['cus_isdelete'] = '2';
        $cus_id=intval($this->request->param('cus_id'));
        $delCus=Db::table('super_customer')->where(['cus_id' => $cus_id])->update($data);
        if($delCus){
            $this->success('删除成功','user');
        }else{
            $this->error('删除失败','user');
        }
    }

    //批量删除；
    public function delBatch(){
        // ids 格式为： 15,13
        $ids=rtrim($this->request->param('ids'),',');
        $res=Db::table('super_customer')
            ->where('cus_id','in',$ids)
            ->update(['cus_isdelete' => '2']);
        if($res){
            return  json(['code' => '1']);
        }else{
            return  json(['code' => '0']);
        }
    }

    //全部删除客户数据
    public function delAll(){
        $res=Db::table('super_customer')->update(['cus_isdelete' => '2']);
        if($res){
            return  json(['code' => '1']);
        }else{
            return  json(['code' => '0']);
        }
    }



    //给某一客户发送短信；
//
     public function sendMsg(){
        $cus_id=intval($_GET['cus_id']);
        $cusInfo=Db::table('super_customer')->field('cus_phone')->where(['cus_id'=> $cus_id])->find();
        $cus_phone=$cusInfo['cus_phone'];
//        dump($cus_phone);
        Loader::import('aliyun/api_demo/SmsDemo',EXTEND_PATH);
        $sems = new \SmsDemo();
        $sem1=$sems->sendSms($cus_phone,'SMS_133976891');
        $array=$this->object2array($sem1);
//        dump($array);
        if($array['Code'] == 'OK'){
            return  json(['code' => '1']);
        }else{
            return  json(['code' => '0']);
        }
    }


    //回收站
    public function back(){
        $where=" cus_isdelete = 2";
        if($_POST){
            $keywords=trim($_POST['keywords']);
            $case_p_id=intval(trim($_POST['case_p_id']));
            $bu_c_id=intval(trim($_POST['bu_c_id']));
            $branch=intval(trim($_POST['branch']));
            $cus_opptime=trim($_POST['cus_opptime']);
            $case_admin=intval(intval(trim($_POST['case_admin'])));
            if(isset($keywords) && !empty($keywords)){
                $where.=" and ( cus_name like '%".$keywords."%' or cus_phone like '%".$keywords."%' or cus_from like '%".$keywords."%' )";
            }
            if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
                $where.=" and cus_provid = ".$case_p_id;
            }
            if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
                $where.=" and cus_cityid = ".$bu_c_id;
            }
            if(isset($branch) && !empty($branch) && $branch){
                $where.=" and cus_branchid = ".$branch;
            }
            if(isset($case_admin) && !empty($case_admin)){
                $where.=" and cus_opeater = ".$case_admin;
            }
            if(isset($cus_opptime) && !empty($cus_opptime)){
                $sdate=strtotime(substr($cus_opptime,'0','10')." 00:00:00");
                $edate=strtotime(substr($cus_opptime,'-10')." 23:59:59");
                $where.=" and ( cus_opptime>= ".$sdate." and cus_opptime <= ".$edate." ) ";
            }
            //手机端
            $data['display']=Db::table('super_customer')
                ->join('super_province','super_customer.cus_provid = super_province.p_id')
                ->join('super_city','super_customer.cus_cityid = super_city.c_id')
                ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
                ->join('super_type','super_customer.cus_status = super_type.type_id')
                ->where($where)
                ->where(['cus_sys' => 1])
                ->count();
            //pc端
            $data['none']=Db::table('super_customer')
                ->join('super_province','super_customer.cus_provid = super_province.p_id')
                ->join('super_city','super_customer.cus_cityid = super_city.c_id')
                ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
                ->join('super_type','super_customer.cus_status = super_type.type_id')
                ->where($where)
                ->where(['cus_sys' => 2])
                ->count();
            $decStyle=Db::table('super_type')
                ->where(['type_sort' => '1','type_isable' => '1'])
                ->order('type_order desc')
                ->field('type_id,type_name')
                ->select();
            foreach($decStyle as $k =>$v){
                $decStyle[$k]['count']=Db::table('super_customer')
                    ->join('super_province','super_customer.cus_provid = super_province.p_id')
                    ->join('super_city','super_customer.cus_cityid = super_city.c_id')
                    ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
                    ->join('super_type','super_customer.cus_status = super_type.type_id')
                    ->where($where)
                    ->where(['cus_status' => $v['type_id']])
                    ->count();
            }
            $data['decStyle']=$decStyle;
            $data['all']=intval($data['display'])+intval($data['none']);
            return $data;
        }
        //分页统计总数；
        $count=Db::table('super_customer')
            ->join('super_province','super_customer.cus_provid = super_province.p_id')
            ->join('super_city','super_customer.cus_cityid = super_city.c_id')
            ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
            ->join('super_type','super_customer.cus_status = super_type.type_id')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('super_customer')
            ->join('super_province','super_customer.cus_provid = super_province.p_id')
            ->join('super_city','super_customer.cus_cityid = super_city.c_id')
            ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
            ->join('super_type','super_customer.cus_status = super_type.type_id')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('cus_id desc')
            ->select();
        foreach($cusInfo as $k => $v){
            $cusInfo[$k]['cus_opptime']=date('Y-m-d H:i:s',$v['cus_opptime']);
            //操作人员对应当前登录的管理员
            if(!empty($v['cus_opeater']) && is_int($v['cus_opeater'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['cus_opeater']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $cusInfo[$k]['ad_realname']= $adName;
            //操作时间
            if(!empty($v['cus_backtime']) && is_int($v['cus_backtime'])){
                $backtime = date('Y-m-d H:i:s',$v['cus_backtime']);
            }else{
                $backtime = "暂未回访";
            }
            $cusInfo[$k]['cus_backtime']= $backtime;
            $cusInfo[$k]['cus_sys']=$v['cus_sys'] == 1  ? '手机端': 'PC端';
            //入库链接显示
            $cusInfo[$k]['cus_link']=explode('/',$v['cus_link'],4)[3];
        }
        //获取客户标签
        $userTip=Db::table('super_type')
            ->where(['type_sort' => '1','type_isable' => '1'])
            ->order('type_order desc')
            ->field('type_id,type_name')
            ->select();
        foreach($userTip as $k =>$v){
            $userTip[$k]['count']=Db::table('super_customer')->where(['cus_status' => $v['type_id'],'cus_isdelete' => 2])->count();
        }
        $tipsConut=Db::table('super_customer')->where(['cus_isdelete' => 2])->count();
        $this->assign('tipsConut',$tipsConut);
        $this->assign('userTip',$userTip);
        //操作人管理员
        $admin = Db::table('super_admin')->select();
        $this->assign('admin',$admin);
        $mobileCount=Db::table('super_customer')->where(['cus_isdelete' => 2,'cus_sys' => 1])->count();
        $pcCount=Db::table('super_customer')->where(['cus_isdelete' => 2,'cus_sys' => 2])->count();
        $this->assign('mobileCount',$mobileCount);
        $this->assign('pcCount',$pcCount);
        $this->assign('cusInfo',$cusInfo);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('limit',$limit);
        return $this->fetch();
    }

    //信息回收站动态
    public function back1(){
        $provInfo=Db::table('super_province')->select();
        $this->assign('prov',$provInfo);
        //操作人管理员
        $admin = Db::table('super_admin')->select();
        $this->assign('admin',$admin);
        //获取客户标签
        $userTip=Db::table('super_type')
            ->where(['type_sort' => '1','type_isable' => '1'])
            ->field('type_id,type_name')
            ->select();
        $this->assign('userTip',$userTip);
        return $this->fetch();
    }

    //信息回收站收据
    public function backData(){
        $where=" 1 = 1";
        //根据role_id 去判断这个登录的人是超管 1  ？站长 6？ 客服 8  ？ 推广 12 ；目前就是这4个身份；
        $ad_role=intval(session('ad_role'));
        //分站id
        $ad_branch = intval(session('ad_branch'));
        if($ad_role == 1 ){// 超级管理员
            $where.=' and cus_isdelete = 2';
        }else{
            $where='cus_isdelete = 2 and  cus_branchid = '.$ad_branch;
        }
        $keywords=trim($this->request->param('keywords'));
        $style_id=intval(trim($this->request->param('style_id')));
        $sys_id=intval(trim($this->request->param('sys_id')));
        $case_p_id=intval(trim($this->request->param('case_p_id')));
        $bu_c_id=intval(trim($this->request->param('bu_c_id')));
        $branch=intval(trim($this->request->param('branch')));
        $case_admin=intval(trim($this->request->param('case_admin')));
        $cus_opptime=trim($this->request->param('cus_opptime'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( cus_name like '%".$keywords."%' or cus_phone like '%".$keywords."%' or cus_from like '%".$keywords."%' )";
        }
        if(isset($style_id) && !empty($style_id) && $style_id){
            $where.=" and cus_status = ".$style_id;
        }
        if(isset($sys_id) && !empty($sys_id) && $sys_id){
            $where.=" and cus_sys = ".$sys_id;
        }
        if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
            $where.=" and cus_provid = ".$case_p_id;
        }
        if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
            $where.=" and cus_cityid = ".$bu_c_id;
        }
        if(isset($branch) && !empty($branch) && $branch){
            $where.=" and cus_branchid = ".$branch;
        }
        if(isset($case_admin) && !empty($case_admin)){
            $where.=" and cus_opeater = ".$case_admin;
        }
        if(isset($cus_opptime) && !empty($cus_opptime)){
            $sdate=strtotime(substr($cus_opptime,'0','10')." 00:00:00");
            $edate=strtotime(substr($cus_opptime,'-10')." 23:59:59");
            $where.=" and ( cus_opptime>= ".$sdate." and cus_opptime <= ".$edate." ) ";
        }
        //分页统计总数；
        $count=Db::table('super_customer')
            ->join('super_province','super_customer.cus_provid = super_province.p_id')
            ->join('super_city','super_customer.cus_cityid = super_city.c_id')
            ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
            ->join('super_type','super_customer.cus_status = super_type.type_id')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('super_customer')
            ->join('super_province','super_customer.cus_provid = super_province.p_id')
            ->join('super_city','super_customer.cus_cityid = super_city.c_id')
            ->join('super_branch','super_customer.cus_branchid = super_branch.b_id')
            ->join('super_type','super_customer.cus_status = super_type.type_id')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('cus_id desc')
            ->select();
        foreach($cusInfo as $k => $v){
            $cusInfo[$k]['cus_opptime']=date('Y-m-d H:i:s',$v['cus_opptime']);
            $cusInfo[$k]['c_name']=$v['p_name']."-".$v['c_name']."-".$v['b_name'];
            $cusInfo[$k]['cus_link']=$v['cus_device']."&nbsp;&nbsp;".$v['cus_position']."<br/>".explode('/',$v['cus_link'],4)[3];
            //操作人员对应当前登录的管理员
            if(!empty($v['cus_opeater']) && is_int($v['cus_opeater'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['cus_opeater']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $cusInfo[$k]['ad_realname']= $adName;
            //操作时间
            if(!empty($v['cus_backtime']) && is_int($v['cus_backtime'])){
                $backtime = date('Y-m-d H:i:s',$v['cus_backtime']);
            }else{
                $backtime = "暂未回访";
            }
            $cusInfo[$k]['cus_backtime']= $backtime;
            $cusInfo[$k]['cus_sys']=$v['cus_sys'] == 1  ? '手机端': 'PC端';
            if($ad_role == 12){
                $cusInfo[$k]['cus_phone'] = substr_replace($v['cus_phone'],'****',3,4);
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }






















    //恢复某一用户（单个恢复）
    public function backNormal(){
        $cus_id=intval($_GET['cus_id']);
        $back=Db::table('super_customer')
            ->where(['cus_id' =>$cus_id,'cus_isdelete' => '2'])
            ->update(['cus_isdelete' => '1']);
        if($back){
            $this->success('恢复成功','back');
        }else{
            $this->error('恢复失败','back');
        }
    }

    //彻底删除某一用户
    public function absdelete(){
        $cus_id=intval($_GET['cus_id']);
        $abs=Db::table('super_customer')
            ->where(['cus_id' => $cus_id ,'cus_isdelete' => '2'])
            ->delete();
        if($abs){
            $this->success('删除成功','back');
        }else{
            $this->error('删除失败','back');
        }
    }

    //批量彻底删除
    public function absdelBatch(){
        $ids=rtrim($this->request->param('ids'),',');
        $res=Db::table('super_customer')
            ->where('cus_id','in',$ids)
            ->where(['cus_isdelete' => '2'])
            ->delete();
        if($res){
            return  json(['code' => '1']);
        }else{
            return  json(['code' => '0']);
        }
    }

    //批量恢复
    public function backBatch(){
        $ids=rtrim($this->request->param('ids'),',');
        $res=Db::table('super_customer')
            ->where('cus_id','in',$ids)
            ->where(['cus_isdelete' => '2'])
            ->update(['cus_isdelete' => '1']);
        if($res){
            return  json(['code' => '1']);
        }else{
            return  json(['code' => '0']);
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



    //二级联动根据传过来的省份id获取对应的城市名称
    public function getCityName(){
        $p_id=intval($_GET['p_id']);
        $cityNames=Db::table('super_city')->where(['p_id' => $p_id])->select();
        if($cityNames){
            return  json(['code' => '1','data' => $cityNames]);
        }else{
            return  json(['code' => '0','data' => ['']]);
        }
    }


    /***
     * Name: ***方法
     * @return string
     * Created by DangMengmeng at 2019/9/12 9:35
     */
    public function level(){
        return '会员等级';
    }
}