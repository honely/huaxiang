<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/6/4
 * Time: 11:26
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;

class Worksite extends Controller{

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

    //在施工地
    public function index(){
        $provInfo=Db::table('super_province')->select();
        $this->assign('prov',$provInfo);
        //操作人管理员
        $admin = Db::table('super_admin')->select();
        $this->assign('admin',$admin);
        //设计师
        $design=Db::table('super_designer')->where(['des_isable' => '1'])->field('des_id,des_name')->select();
        $this->assign('design',$design);
        //工长
        $worker=Db::table('super_worker')->where(['wk_isable' => '1'])->field('wk_id,wk_name')->select();
        $this->assign('worker',$worker);
        //已展示
        $display=Db::table('super_worksite')
            ->join('super_city','super_city.c_id = super_worksite.w_c_id')
            ->join('super_province','super_province.p_id = super_worksite.w_p_id')
            ->join('super_designer','super_designer.des_id = super_worksite.w_desinger')
            ->where(['w_isable'=>1])->count();
        $this->assign('display',$display);
        //未展示
        $none=Db::table('super_worksite')
            ->join('super_city','super_city.c_id = super_worksite.w_c_id')
            ->join('super_province','super_province.p_id = super_worksite.w_p_id')
            ->join('super_designer','super_designer.des_id = super_worksite.w_desinger')
            ->where(['w_isable'=>2])->count();
        $this->assign('none',$none);
        $this->assign('all',intval($display)+intval($none));
        return $this->fetch();
    }

    public function siteData(){
        $ad_role=intval(session('ad_role'));
        //分站id
        $ad_branch = intval(session('ad_branch'));
        if($ad_role == 1 ){// 超级管理员
            $where =' 1 = 1';
        }else{
            $where=' des_b_id = '.$ad_branch;
        }
        $keywords=$this->request->param('keywords');
        $w_p_id=$this->request->param('case_p_id');
        $bu_c_id=$this->request->param('bu_c_id');
        $branch=$this->request->param('branch');
        $w_isable=$this->request->param('w_isable');
        $w_admin=$this->request->param('w_admin');
        $w_decotime=$this->request->param('w_decotime');
        $w_designer=$this->request->param('w_designer');

        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( w_title like '%".$keywords."%' or w_bid like '%".$keywords."%' )";
        }
        if(isset($w_p_id) && !empty($w_p_id) && $w_p_id){
            $where.=" and w_p_id = ".$w_p_id;
        }
        if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
            $where.=" and w_c_id = ".$bu_c_id;
        }
        if(isset($branch) && !empty($branch) && $branch){
            $where.=" and w_b_id = ".$branch;
        }
        if(isset($w_isable) && !empty($w_isable)){
            $where.=" and w_isable = ".$w_isable;
        }
        if(isset($w_admin) && !empty($w_admin)){
            $where.=" and w_admin = ".$w_admin;
        }
        if(isset($w_designer) && !empty($w_designer)){
            $where.=" and w_designer = ".$w_designer;
        }
        if(isset($w_decotime) && !empty($w_decotime)){
            $sdate=strtotime(substr($w_decotime,'0','10')." 00:00:00");
            $edate=strtotime(substr($w_decotime,'-10')." 23:59:59");
            $where.=" and ( w_decotime >= ".$sdate." and w_decotime <= ".$edate." ) ";
        }
        $count=Db::table('super_worksite')
            ->join('super_city','super_city.c_id = super_worksite.w_c_id')
            ->join('super_province','super_province.p_id = super_worksite.w_p_id')
            ->join('super_admin','super_admin.ad_id = super_worksite.w_admin')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $example=Db::table('super_worksite')
            ->join('super_city','super_city.c_id = super_worksite.w_c_id')
            ->join('super_province','super_province.p_id = super_worksite.w_p_id')
            ->join('super_admin','super_admin.ad_id = super_worksite.w_admin')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('w_istop ASC ,w_view desc')
            ->select();
        foreach($example as $k => $v ){
            $example[$k]['w_updatetime'] = date('Y-m-d H:i:s',$v['w_updatetime']);
            $example[$k]['c_name'] =$v['p_name']."-".$v['c_name'];
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $example;
        $res['count'] = $count;
        return json($res);
    }



    //发布案例
    public function add(){
        if($_POST){
            $stime=strtotime(date('Y-m-d 00:00:00'));
            $etime=strtotime(date('Y-m-d 23:59:59'));
            //获取当日预约的数量
            $buNum=Db::table('super_worksite')->where('w_decotime','between',[$stime,$etime])->count();
            //生成用户编号；
            $data['w_bid'] = date('Ymd').sprintf("%04d", $buNum+1);
            $data['w_img'] = implode(',',$_POST['w_img']);
            $data['w_img_title'] = implode(',',$_POST['w_img_title']);
            $data['w_img_desc'] = implode(',',$_POST['w_img_desc']);
            $data['w_img_alt'] = implode(',',$_POST['w_img_alt']);
            $data['w_title']=$_POST['w_title'];
            $data['w_style']=$_POST['w_style'];
            $data['w_p_id']=$_POST['w_p_id'];
            $data['w_c_id']=$_POST['w_c_id'];
            $data['w_b_id']=$_POST['w_b_id'];
            $data['w_price']=$_POST['w_price'];
            $data['w_type']=$_POST['dinner'].",".$_POST['room'].",".$_POST['wash'];
            $data['w_bulid']=$_POST['w_bulid'];
            $data['w_type_iamge']=$_POST['w_type_iamge'];
            $data['w_type_alt']=$_POST['w_type_alt'];
            $data['w_type_title']=$_POST['w_type_title'];
            $data['w_type_desc']=$_POST['w_type_desc'];
            $data['w_area']=$_POST['w_area'];
            $data['w_url']=$_POST['w_url'];
            $data['w_remarks']=$_POST['w_remarks'];
            $data['w_designer']=$_POST['w_designer'];
            $data['w_seo_tilte']=$_POST['w_seo_tilte'];
            $data['w_seo_keywords']=$_POST['w_seo_keywords'];
            $data['w_seo_desc']=$_POST['w_seo_desc'];
            $data['w_istop']=$_POST['w_istop'];
            $data['w_decotime']=time();
            $data['w_updatetime']=time();
            $data['w_isable']=$_POST['w_isable'];
            $data['w_admin'] = session('adminId');
            $add=Db::table('super_worksite')->insert($data);
            if($add){
                $this->success('发布案例成功！','example');
            }else{
                $this->error('发布案例失败！','example');
            }
        }else{
            //工长
            $worker=Db::table('super_worker')->where(['wk_isable' => '1'])->field('wk_id,wk_name')->select();
            $this->assign('worker',$worker);
            //设计师
            $design=Db::table('super_designer')->where(['des_isable' => '1'])->field('des_id,des_name')->select();
            $this->assign('design',$design);
            //风格
            $style=Db::table('super_type')->where(['type_isable' => '1','type_sort' => '2'])->field('type_id,type_name')->select();
            $this->assign('style',$style);
            //楼盘
            $build=Db::table('super_buildings')->where(['bu_isable' => '1'])->field('bu_id,bu_name')->select();
            $this->assign('build',$build);
            //房屋类型
            $houseType=Db::table('super_type')->where(['type_isable' => '1','type_sort' => '4'])->field('type_id,type_name')->select();
            $this->assign('houseType',$houseType);
            $provInfo=Db::table('super_province')->select();
            $this->assign('prov',$provInfo);
            return $this->fetch();
        }
    }




    //修改案例内容
    public function edit(){
        $w_id=intval($_GET['w_id']);
        if($_POST){
            $data['w_img'] = implode(',',$_POST['w_img']);
            $data['w_img_title'] = implode(',',$_POST['w_img_title']);
            $data['w_img_desc'] = implode(',',$_POST['w_img_desc']);
            $data['w_img_alt'] = implode(',',$_POST['w_img_alt']);
            $data['w_title']=$_POST['w_title'];
            $data['w_style']=$_POST['w_style'];
            $data['w_p_id']=$_POST['w_p_id'];
            $data['w_c_id']=$_POST['w_c_id'];
            $data['w_b_id']=$_POST['w_b_id'];
            $data['w_price']=$_POST['w_price'];
            $data['w_type']=$_POST['dinner'].",".$_POST['room'].",".$_POST['wash'];
            $data['w_bulid']=$_POST['w_bulid'];
            $data['w_type_iamge']=$_POST['w_type_iamge'];
            $data['w_type_alt']=$_POST['w_type_alt'];
            $data['w_type_title']=$_POST['w_type_title'];
            $data['w_type_desc']=$_POST['w_type_desc'];
            $data['w_area']=$_POST['w_area'];
            $data['w_url']=$_POST['w_url'];
            $data['w_remarks']=$_POST['w_remarks'];
            $data['w_designer']=$_POST['w_designer'];
            $data['w_seo_tilte']=$_POST['w_seo_tilte'];
            $data['w_seo_keywords']=$_POST['w_seo_keywords'];
            $data['w_seo_desc']=$_POST['w_seo_desc'];
            $data['w_istop']=$_POST['w_istop'];
            $data['w_updatetime']=time();
            $data['w_isable']=$_POST['w_isable'];
            $data['w_admin'] = session('adminId');
            $edit=Db::table('super_worksite')->where(['w_id'=>$w_id])->update($data);
            if($edit){
                $this->success('修改案例成功','example');
            }else{
                $this->error('修改案例失败','example');
            }
        }else{
            //设计师
            $design=Db::table('super_designer')->where(['des_isable' => '1'])->field('des_id,des_name')->select();
            $this->assign('design',$design);
            //风格
            $style=Db::table('super_type')->where(['type_isable' => '1','type_sort' => '2'])->field('type_id,type_name')->select();
            $this->assign('style',$style);
            //楼盘
            $build=Db::table('super_buildings')->where(['bu_isable' => '1'])->field('bu_id,bu_name')->select();
            $this->assign('build',$build);
            $provInfo=Db::table('super_province')->select();
            $this->assign('prov',$provInfo);
            $artInfo=Db::table('super_worksite')->where(['w_id'=>$w_id])->find();
            //案例图片
            $artInfo['w_img']=explode(',',$artInfo['w_img']);
            $artInfo['w_img_title']=explode(',',$artInfo['w_img_title']);
            $artInfo['w_img_alt']=explode(',',$artInfo['w_img_alt']);
            $artInfo['w_img_desc']=explode(',',$artInfo['w_img_desc']);
            $artInfo['w_type']=explode(',',$artInfo['w_type']);
            $provId=$artInfo['w_p_id'];
            $c_id=$artInfo['w_c_id'];
            $city=Db::table('super_city')->where(['p_id' => $provId])->select();
            $branchs=Db::table('super_branch')->where(['b_city' =>$c_id ])->field('b_id,b_name')->select();
            $this->assign('branchs',$branchs);
            $this->assign('city',$city);
            $this->assign('case',$artInfo);
            return $this->fetch();
        }
    }

    //刷新某一案例
    public function refresh(){
        $w_id=intval($_GET['w_id']);
        $refresh=Db::table('super_worksite')->where(['w_id' => $w_id])->update(['w_updatetime' => time()]);
        if($refresh){
            $this->success('刷新案例成功','example');
        }else{
            $this->error('刷新案例失败','example');
        }
    }

    //删除某一案例
    public function del(){
        $w_id=intval($_GET['w_id']);
        $delArt=Db::table('super_worksite')->where(['w_id' => $w_id])->delete();
        if($delArt){
            $this->success('删除案例成功','example');
        }else{
            $this->error('删除案例失败','example');
        }
    }


    //更改是否显示的状态
    public function status(){
        $ba_id = $_GET['w_id'];
        $change = $_GET['change'];
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '显示';
                $data['w_isable'] = '1';
                $data['w_admin'] = session('adminId');
            }else{
                $msg = '隐藏';
                $data['w_isable'] = '2';
                $data['w_istop'] = '2';
                $data['w_admin'] = session('adminId');
            }
            $changeStatus = Db::table('super_worksite')->where(['w_id' => $ba_id])->update($data);
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

    //top
    public function top(){
        $ba_id = $_GET['w_id'];
        $change = $_GET['change'];
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '置顶';
                $data['w_istop'] = '1';
                $data['w_admin'] = session('adminId');
            }else{
                $msg = '取消置顶';
                $data['w_istop'] = '2';
                $data['w_admin'] = session('adminId');
            }
            $changeStatus = Db::table('super_worksite')->where(['w_id' => $ba_id])->update($data);
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




    //在施工地图片上传
    public function upload(){
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/worksite');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/worksite/".$path_date."/".$path_filename;
            // 成功上传后 返回上传信息
            return json(array('state'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
        }else{
            // 上传失败返回错误信息
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }


}