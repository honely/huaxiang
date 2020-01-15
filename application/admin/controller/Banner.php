<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/4/18
 * Time: 10:52
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;

class Banner extends Controller{
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
    public function bannerPC(){
        $keywords=trim($this->request->param('keywords'));
        $ba_isable=intval(trim($this->request->param('ba_isable')));
        $where=" 1 = 1 ";
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( ba_title like '%".$keywords."%' or ba_bid like '%".$keywords."%')";
        }
        if(isset($ba_p_id) && !empty($ba_p_id) && $ba_p_id){
            $where.=" and ba_p_id = ".$ba_p_id;
        }
        if(isset($ba_c_id) && !empty($ba_c_id) && $ba_c_id){
            $where.=" and ba_c_id = ".$ba_c_id;
        }
        if(isset($ba_admin) && !empty($ba_admin)){
            $where.=" and ba_admin = ".$ba_admin;
        }
        if(isset($ba_isable) && !empty($ba_isable)){
            $where.=" and ba_isable = ".$ba_isable;
        }
        $count=Db::table('super_banner')
                ->join('super_admin','super_banner.ba_admin = super_admin.ad_id')
                ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',15,'intval');
        $pcBan=Db::table('super_banner')
            ->join('super_admin','super_banner.ba_admin = super_admin.ad_id')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->field('super_banner.*,super_admin.ad_realname')
            ->order('ba_isable,ba_branch desc ,ba_order desc ,ba_createtime desc')
            ->select();
        foreach ($pcBan as $k =>$v){
            $pcBan[$k]['ba_createtime']=date('Y-m-d H:i:s',$v['ba_createtime']);
            $pcBan[$k]['ba_img']="../../..".$v['ba_img'];
        }
        $res['where']=$where;
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $pcBan;
        $res['count'] = $count;
        return json($res);
    }
    //banner
    public function banner(){
        return $this->fetch();
    }



    //更改是否显示的状态
    public function status(){
        $ba_id = intval(trim($_GET['ba_id']));
        $change = intval(trim($_GET['change']));
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '显示';
                $data['ba_isable'] = '1';
                $data['ba_admin'] = session('adminId');
            }else{
                $msg = '隐藏';
                $data['ba_isable'] = '2';
                $data['ba_admin'] = session('adminId');
            }
            $changeStatus = Db::table('super_banner')->where(['ba_id' => $ba_id])->update($data);
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
        $ba_id=intval(trim($_POST['ba_id']));
        $ba_order=intval(trim($_POST['value']));
        if(!empty($ba_order)){
            $reOrder=Db::table('super_banner')->where(['ba_id' => $ba_id])->update(['ba_order' => $ba_order]);
            if($reOrder){
                $this->success('修改排序成功！');
            }else{
                $this->error('修改排序失败！');
            }
        }else{
            $this->error('请输入一个整数数字！');
        }
    }










    public function addBanner(){
        $adminId=intval(session('adminId'));
        $ad_role=intval(session('ad_role'));
        if($_POST){
            $stime=strtotime(date('Y-m-d 00:00:00'));
            $etime=strtotime(date('Y-m-d 23:59:59'));
            $buNum=Db::table('super_banner')->where('ba_createtime','between',[$stime,$etime])->count();
            //生成用户编号；
            $data['ba_bid'] = date('Ymd').sprintf("%04d", $buNum+1);
            $data['ba_title']=$_POST['ba_title'];
            $data['ba_alt']=$_POST['ba_alt'];
            $data['ba_img']=$_POST['ba_img'];
            $data['ba_type']=1;
            $data['ba_order']=$_POST['ba_order'];
            $data['ba_isable']=$_POST['ba_isable'];
            $data['ba_url']=$_POST['ba_url'];
            $data['ba_admin'] = $adminId;
            $data['ba_createtime']=time();
            $addBan=Db::table('super_banner')->insert($data);
            if($addBan){
                $this->success('添加banner成功！','banner');
            }else{
                $this->error('添加banner失败!','banner');
            }
        }else{
            if($ad_role == 1 ){// 超级管理员
                $provInfo=Db::table('super_province')->select();
                $this->assign('prov',$provInfo);
            }else{
                $adminInfo=Db::table('super_admin')
                    ->where(['ad_id' => $adminId])
                    ->find();
                $this->assign('admin',$adminInfo);
            }
            $this->assign('ad_role',$ad_role);
            return $this->fetch();
        }
    }

    public function editBanner(){
        $adminId=intval(session('adminId'));
        $ad_role=intval(session('ad_role'));
        $ba_id=$_GET['ba_id'];
        if($_POST){
            $data['ba_title']=$_POST['ba_title'];
            $data['ba_alt']=$_POST['ba_alt'];
            $data['ba_img']=$_POST['ba_img'];
            $data['ba_order']=$_POST['ba_order'];
            $data['ba_isable']=$_POST['ba_isable'];
            $data['ba_url']=$_POST['ba_url'];
            $data['ba_createtime']=time();
            $data['ba_admin'] = $adminId;
            $update=Db::table('super_banner')->where(['ba_id'=> $ba_id])->update($data);
            if($update){
                $this->success('修改banner成功！','banner');
            }else{
                $this->error('您未做任何修改！','banner');
            }
        }else{
            $banInfo=Db::table('super_banner')
                ->where(['ba_id'=> $ba_id])
                ->find();
            $this->assign('ban',$banInfo);
            $this->assign('ad_role',$ad_role);
            return $this->fetch();
        }
    }

    //删除banner图；
    public function delBanner(){
        $ba_id=intval(trim($_GET['ba_id']));
        $delBan=Db::table('super_banner')->where(['ba_id'=>$ba_id])->delete();
        if($delBan){
            $this->success('删除成功！','banner');
        }else{
            $this->error('删除失败！','banner');
        }
    }


    //banner图片上传
    public function upload(){
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/banner');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/banner/".$path_date."/".$path_filename;
            // 成功上传后 返回上传信息
            return json(array('state'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
        }else{
            // 上传失败返回错误信息
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }












    //产品效果图
    public function product(){
        //操作人管理员
        $admin = Db::table('super_admin')->select();
        $this->assign('admin',$admin);
        $ad_role=intval(session('ad_role'));
        $this->assign('ad_role',$ad_role);
        return $this->fetch();
    }



    public function proData(){
        $ad_role=intval(session('ad_role'));
        //分站id
        $ad_branch = intval(session('ad_branch'));
        if($ad_role == 1 ){// 超级管理员
            $where =' 1 = 1 and case_sort = 2 ';
        }else{
            $where='case_sort = 2 and case_b_id = '.$ad_branch;
        }
        $case_p_id=intval(trim($this->request->param('case_p_id')));
        $bu_c_id=intval(trim($this->request->param('bu_c_id')));
        $branch=intval(trim($this->request->param('branch')));
        $case_admin=intval(trim($this->request->param('case_admin')));
        $case_decotime=trim($this->request->param('case_decotime'));
        if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
            $where.=" and case_p_id = ".$case_p_id;
        }
        if(isset($bu_c_id) && !empty($bu_c_id) && $case_p_id){
            $where.=" and case_c_id = ".$bu_c_id;
        }
        if(isset($branch) && !empty($branch) && $branch){
            $where.=" and case_b_id = ".$branch;
        }
        if(isset($case_admin) && !empty($case_admin)){
            $where.=" and case_admin = ".$case_admin;
        }
        if(isset($case_decotime) && !empty($case_decotime)){
            $sdate=strtotime(substr($case_decotime,'0','10')." 00:00:00");
            $edate=strtotime(substr($case_decotime,'-10')." 23:59:59");
            $where.=" and ( case_decotime >= ".$sdate." and case_decotime <= ".$edate." ) ";
        }
        $count=Db::table('super_case')
            ->join('super_province','super_province.p_id = super_case.case_p_id')
            ->join('super_city','super_city.c_id = super_case.case_c_id')
            ->join('super_branch','super_branch.b_id = super_case.case_b_id')
            ->join('super_admin','super_admin.ad_id = super_case.case_admin')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $example=Db::table('super_case')
            ->join('super_province','super_province.p_id = super_case.case_p_id')
            ->join('super_city','super_city.c_id = super_case.case_c_id')
            ->join('super_branch','super_branch.b_id = super_case.case_b_id')
            ->join('super_admin','super_admin.ad_id = super_case.case_admin')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('case_istop ASC ,case_view desc')
            ->select();
        foreach($example as $k => $v ){
            $example[$k]['case_updatetime'] = date('Y-m-d H:i:s',$v['case_updatetime']);
            $example[$k]['c_name'] =$v['p_name']."-".$v['c_name']."-".$v['b_name'];
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $example;
        $res['count'] = $count;
        return json($res);
    }




    public function add(){
        $adminId=intval(session('adminId'));
        $ad_role=intval(session('ad_role'));
        if($_POST){
            $stime=strtotime(date('Y-m-d 00:00:00'));
            $etime=strtotime(date('Y-m-d 23:59:59'));
            //获取当日预约的数量
            $buNum=Db::table('super_case')->where('case_decotime','between',[$stime,$etime])->count();
            //生成用户编号；
            $data['case_bid'] = date('Ymd').sprintf("%04d", $buNum+1);
            $data['case_img'] = implode(',',$_POST['case_img']);
            $data['case_img_alt'] = implode(',',$_POST['case_img_alt']);
            $data['case_title']=$_POST['case_title'];
            $data['case_p_id'] = $ad_role == 1 ? $_POST['case_p_id']: session('ad_p_id');
            $data['case_c_id'] = $ad_role == 1 ? $_POST['case_c_id']: session('ad_c_id');
            $data['case_b_id'] = $ad_role == 1 ? $_POST['case_b_id']: session('ad_branch');
            $data['case_sort']=2;
            $data['case_updatetime']=time();
            $data['case_admin'] = session('adminId');
            $add=Db::table('super_case')->insert($data);
            if($add){
                $this->success('发布效果图成功！','product');
            }else{
                $this->error('发布效果图失败！','product');
            }
        }else{

            if($ad_role == 1 ){// 超级管理员
                $provInfo=Db::table('super_province')->select();
                $this->assign('prov',$provInfo);
            }else{
                $adminInfo=Db::table('super_admin')
                    ->join('super_province','super_province.p_id = super_admin.ad_p_id')
                    ->join('super_city','super_city.c_id = super_admin.ad_c_id')
                    ->join('super_role','super_role.r_id = super_admin.ad_role')
                    ->join('super_branch','super_branch.b_id = super_admin.ad_branch')
                    ->field('super_admin.ad_realname,super_province.p_name,super_city.c_name,super_branch.b_name,super_role.r_name')
                    ->where(['ad_id' => $adminId])
                    ->find();
                $this->assign('admin',$adminInfo);
            }
            $this->assign('ad_role',$ad_role);
            return $this->fetch();
        }
    }


    public function edit(){
        $ad_role=intval(session('ad_role'));
        $case_id=intval($_GET['case_id']);
        if($_POST){
            $data['case_img'] = implode(',',$_POST['case_img']);
            $data['case_img_alt'] = implode(',',$_POST['case_img_alt']);
            $data['case_title']=$_POST['case_title'];
            $data['case_p_id'] = $ad_role == 1 ? $_POST['case_p_id']: session('ad_p_id');
            $data['case_c_id'] = $ad_role == 1 ? $_POST['case_c_id']: session('ad_c_id');
            $data['case_b_id'] = $ad_role == 1 ? $_POST['case_b_id']: session('ad_branch');
            $data['case_updatetime']=time();
            $data['case_admin'] = session('adminId');
            $edit=Db::table('super_case')->where(['case_id'=>$case_id])->update($data);
            if($edit){
                $this->success('修改效果图成功','product');
            }else{
                $this->error('修改效果图失败','product');
            }
        }else{
            $provInfo=Db::table('super_province')->select();
            $this->assign('prov',$provInfo);
            $artInfo=Db::table('super_case')
                ->join('super_province','super_province.p_id = super_case.case_p_id')
                ->join('super_city','super_city.c_id = super_case.case_c_id')
                ->join('super_branch','super_branch.b_id = super_case.case_b_id')
                ->where(['case_id'=>$case_id])
                ->field('super_case.*,super_province.p_name,super_city.c_name,super_branch.b_name')
                ->find();
            //案例图片
            $artInfo['case_img']=explode(',',$artInfo['case_img']);
            $artInfo['case_img_alt']=explode(',',$artInfo['case_img_alt']);
            $provId=$artInfo['case_p_id'];
            $c_id=$artInfo['case_c_id'];
            $city=Db::table('super_city')->where(['p_id' => $provId])->select();
            $branchs=Db::table('super_branch')->where(['b_city' =>$c_id ])->field('b_id,b_name')->select();
            $this->assign('branchs',$branchs);
            $this->assign('city',$city);
            $this->assign('case',$artInfo);
            return $this->fetch();
        }
    }




    //文章banner
    public function artbanner(){
        if($_POST){
            $where=" 1 = 1";
            $keywords=trim($this->request->param('keywords'));
            $ba_p_id=intval(trim($this->request->param('ba_p_id')));
            $ba_c_id=intval(trim($this->request->param('bu_c_id')));
            $ba_branch=intval(trim($this->request->param('ba_branch')));
            $ba_admin=intval(trim($this->request->param('ba_admin')));
            if(isset($keywords) && !empty($keywords)){
                $where.=" and ( ba_title like '%".$keywords."%' or ba_bid like '%".$keywords."%')";
            }
            if(isset($ba_p_id) && !empty($ba_p_id) && $ba_p_id){
                $where.=" and ba_p_id = ".$ba_p_id;
            }
            if(isset($ba_c_id) && !empty($ba_c_id) && $ba_c_id){
                $where.=" and ba_c_id = ".$ba_c_id;
            }
            if(isset($ba_branch) && !empty($ba_branch) && $ba_branch){
                $where.=" and ba_branch = ".$ba_branch;
            }
            if(isset($ba_admin) && !empty($ba_admin)){
                $where.=" and ba_admin = ".$ba_admin;
            }
            $data['display']=Db::table('super_banner')
                ->join('super_province','super_banner.ba_p_id = super_province.p_id')
                ->join('super_city','super_banner.ba_c_id = super_city.c_id')
                ->join('super_admin','super_banner.ba_admin = super_admin.ad_id')
                ->join('super_branch','super_banner.ba_branch = super_branch.b_id')
                ->where($where)
                ->where(['ba_isable' => 1,'ba_type' =>2])
                ->count();
            //未展示
            $data['none']=Db::table('super_banner')
                ->join('super_province','super_banner.ba_p_id = super_province.p_id')
                ->join('super_city','super_banner.ba_c_id = super_city.c_id')
                ->join('super_admin','super_banner.ba_admin = super_admin.ad_id')
                ->join('super_branch','super_banner.ba_branch = super_branch.b_id')
                ->where($where)
                ->where(['ba_isable' => 2,'ba_type' =>2])
                ->count();
            $data['all']=intval($data['display'])+intval($data['none']);
            return $data;
        }
        //分站id
        $ad_role=intval(session('ad_role'));
        $ad_branch = intval(session('ad_branch'));
        if($ad_role == 1 ){// 超级管理员
            $where = ' ba_type = 2 ';
        }else{
            $where= ' ba_type = 2 and  ba_branch = '.$ad_branch;
        }
        $disShow=Db::table('super_banner')
            ->where($where)
            ->where(['ba_isable' => 1])
            ->count();
        $disNone=Db::table('super_banner')
            ->where($where)
            ->where(['ba_isable' => 2])
            ->count();
        $this->assign('show',$disShow);
        $this->assign('none',$disNone);
        $this->assign('all',intval($disShow)+intval($disNone));
        $provInfo=Db::table('super_province')->select();
        $this->assign('prov',$provInfo);
        //操作人管理员
        $admin = Db::table('super_admin')->select();
        $this->assign('admin',$admin);
        return $this->fetch();
    }

    //文章banner数据
    public function bannerArt(){
        $ad_role=intval(session('ad_role'));
        //分站id
        $ad_branch = intval(session('ad_branch'));
        if($ad_role == 1 ){// 超级管理员
            $where = ' ba_type = 2 ';
        }else{
            $where= ' ba_type = 2 and  ba_branch = '.$ad_branch;
        }
        $keywords=trim($this->request->param('keywords'));
        $ba_p_id=intval(trim($this->request->param('ba_p_id')));
        $ba_c_id=intval(trim($this->request->param('bu_c_id')));
        $ba_branch=intval(trim($this->request->param('ba_branch')));
        $ba_admin=intval(trim($this->request->param('ba_admin')));
        $ba_isable=intval(trim($this->request->param('ba_isable')));

        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( ba_title like '%".$keywords."%' or ba_bid like '%".$keywords."%')";
        }
        if(isset($ba_p_id) && !empty($ba_p_id) && $ba_p_id){
            $where.=" and ba_p_id = ".$ba_p_id;
        }
        if(isset($ba_c_id) && !empty($ba_c_id) && $ba_c_id){
            $where.=" and ba_c_id = ".$ba_c_id;
        }
        if($ad_role == 1 ){
            if(isset($ba_branch) && !empty($ba_branch) && $ba_branch){
                $where.=" and ba_branch = ".$ba_branch;
            }
        }
        if(isset($ba_admin) && !empty($ba_admin)){
            $where.=" and ba_admin = ".$ba_admin;
        }
        if(isset($ba_isable) && !empty($ba_isable)){
            $where.=" and ba_isable = ".$ba_isable;
        }
        $count=Db::table('super_banner')
            ->join('super_province','super_banner.ba_p_id = super_province.p_id')
            ->join('super_city','super_banner.ba_c_id = super_city.c_id')
            ->join('super_admin','super_banner.ba_admin = super_admin.ad_id')
            ->join('super_branch','super_banner.ba_branch = super_branch.b_id')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',15,'intval');
        $pcBan=Db::table('super_banner')
            ->join('super_province','super_banner.ba_p_id = super_province.p_id')
            ->join('super_city','super_banner.ba_c_id = super_city.c_id')
            ->join('super_admin','super_banner.ba_admin = super_admin.ad_id')
            ->join('super_branch','super_banner.ba_branch = super_branch.b_id')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->field('super_banner.*,super_city.c_name,super_province.p_name,super_admin.ad_realname,super_branch.b_name')
            ->order('ba_isable,ba_branch desc ,ba_order desc ,ba_createtime desc')
            ->select();
        foreach ($pcBan as $k =>$v){
            $pcBan[$k]['ba_createtime']=date('Y-m-d H:i:s',$v['ba_createtime']);
            $pcBan[$k]['b_name']=$v['p_name']."-".$v['c_name']."-".$v['b_name'];
            $pcBan[$k]['ba_img']="../../..".$v['ba_img'];
        }
        $res['where']=$where;
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $pcBan;
        $res['count'] = $count;
        return json($res);
    }
    //添加文章banner
    public function addart(){
        $adminId=intval(session('adminId'));
        $ad_role=intval(session('ad_role'));
        if($_POST){
            $stime=strtotime(date('Y-m-d 00:00:00'));
            $etime=strtotime(date('Y-m-d 23:59:59'));
            $buNum=Db::table('super_banner')->where('ba_createtime','between',[$stime,$etime])->count();
            //生成用户编号；
            $data['ba_bid'] = date('Ymd').sprintf("%04d", $buNum+1);
            $data['ba_title']=$_POST['ba_title'];
            $data['ba_alt']=$_POST['ba_alt'];
            $data['ba_img']=$_POST['ba_img'];
            $data['ba_type']=2;
            $data['ba_p_id'] = $ad_role == 1 ? $_POST['ba_p_id']: session('ad_p_id');
            $data['ba_c_id'] = $ad_role == 1 ? $_POST['ba_c_id']: session('ad_c_id');
            $data['ba_branch'] = $ad_role == 1 ? $_POST['ba_branch']: session('ad_branch');
            $data['ba_order']=$_POST['ba_order'];
            $data['ba_isable']=$_POST['ba_isable'];
            $data['ba_url']=$_POST['ba_url'];
            $data['ba_admin'] = $adminId;
            $data['ba_createtime']=time();
            $addBan=Db::table('super_banner')->insert($data);
            if($addBan){
                $this->success('添加banner成功！','artbanner');
            }else{
                $this->error('添加banner失败!','artbanner');
            }
        }else{
            if($ad_role == 1 ){// 超级管理员
                $provInfo=Db::table('super_province')->select();
                $this->assign('prov',$provInfo);
            }else{
                $adminInfo=Db::table('super_admin')
                    ->join('super_province','super_province.p_id = super_admin.ad_p_id')
                    ->join('super_city','super_city.c_id = super_admin.ad_c_id')
                    ->join('super_role','super_role.r_id = super_admin.ad_role')
                    ->join('super_branch','super_branch.b_id = super_admin.ad_branch')
                    ->field('super_admin.ad_realname,super_province.p_name,super_city.c_name,super_branch.b_name,super_role.r_name')
                    ->where(['ad_id' => $adminId])
                    ->find();
                $this->assign('admin',$adminInfo);
            }
            $this->assign('ad_role',$ad_role);
            return $this->fetch();
        }
    }

    //修改文章banner
    public function editart(){
        $adminId=intval(session('adminId'));
        $ad_role=intval(session('ad_role'));
        $ba_id=$_GET['ba_id'];
        if($_POST){
            $data['ba_title']=$_POST['ba_title'];
            $data['ba_alt']=$_POST['ba_alt'];
            $data['ba_img']=$_POST['ba_img'];
            $data['ba_order']=$_POST['ba_order'];
            $data['ba_isable']=$_POST['ba_isable'];
            $data['ba_url']=$_POST['ba_url'];
            $data['ba_createtime']=time();
            $data['ba_admin'] = $adminId;
            $update=Db::table('super_banner')->where(['ba_id'=> $ba_id])->update($data);
            if($update){
                $this->success('修改banner成功！','artbanner');
            }else{
                $this->error('您未做任何修改！','artbanner');
            }
        }else{
            $banInfo=Db::table('super_banner')
                ->join('super_province','super_province.p_id = super_banner.ba_p_id')
                ->join('super_city','super_city.c_id = super_banner.ba_c_id')
                ->join('super_branch','super_branch.b_id = super_banner.ba_branch')
                ->where(['ba_id'=> $ba_id])
                ->field('super_banner.*,super_province.p_name,super_city.c_name,super_branch.b_name')
                ->find();
            $this->assign('ban',$banInfo);
            $this->assign('ad_role',$ad_role);
            return $this->fetch();
        }
    }
}