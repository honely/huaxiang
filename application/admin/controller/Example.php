<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/4/28
 * Time: 11:11
 * Name: 案例管理
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
use  think\Request;

class Example extends Controller{
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
    //案例列表
    public function example(){
        $ad_role=intval(session('ad_role'));
        //分站id
        $ad_branch = intval(session('ad_branch'));
        //操作人管理员
        $admin = Db::table('super_admin')->where(['ad_c_id' => $ad_branch])->select();
        $this->assign('admin',$admin);
        if($ad_role == 1 ){// 超级管理员
            $design=Db::table('super_designer')->where(['des_isable' => '1'])->field('des_id,des_name')->select();
            $admin = Db::table('super_admin')->where(['ad_isable' => 1])->select();
            $where =' case_sort = 1 ';
        }else{
            $design=Db::table('super_designer')->where(['des_isable' => '1','des_b_id' => $ad_branch])->field('des_id,des_name')->select();
            $admin = Db::table('super_admin')->where(['ad_isable' => 1,'ad_branch' => $ad_branch])->select();
            $where=' case_sort = 1 and case_b_id = '.$ad_branch;
        }
        $this->assign('design',$design);
        $this->assign('admin',$admin);
        if($_POST){
            $keywords=trim($_POST['keywords']);
            $case_p_id=trim($_POST['case_p_id']);
            $bu_c_id=trim($_POST['bu_c_id']);
            $branch=trim($_POST['branch']);
            $case_area=trim($_POST['case_area']);
            $case_decotime=trim($_POST['case_decotime']);
            $case_designer=trim($_POST['case_designer']);
            $case_admin=intval(trim($_POST['case_admin']));

            if(isset($keywords) && !empty($keywords)){
                $where.=" and ( case_title like '%".$keywords."%' or case_bid like '%".$keywords."%' )";
            }
            if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
                $where.=" and case_p_id = ".$case_p_id;
            }
            if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
                $where.=" and case_c_id = ".$bu_c_id;
            }
            if(isset($branch) && !empty($branch) && $branch){
                $where.=" and case_b_id = ".$branch;
            }
            if(isset($case_area) && !empty($case_area)){
                $areaInfo=Db::table('super_type')->where(['type_id' =>$case_area])->find();
                $areaRange=explode('-',$areaInfo['type_remarks']);
                $where.=" and case_area >= ".$areaRange[0]." and case_area <= ".$areaRange[1];
            }
            if(isset($case_admin) && !empty($case_admin)){
                $where.=" and case_admin = ".$case_admin;
            }
            if(isset($case_designer) && !empty($case_designer)){
                $where.=" and case_designer = ".$case_designer;
            }
            if(isset($case_decotime) && !empty($case_decotime)){
                $sdate=strtotime(substr($case_decotime,'0','10')." 00:00:00");
                $edate=strtotime(substr($case_decotime,'-10')." 23:59:59");
                $where.=" and ( case_decotime >= ".$sdate." and case_decotime <= ".$edate." ) ";
            }
            $data['none']=Db::table('super_case')
                ->join('super_city','super_city.c_id = super_case.case_c_id')
                ->join('super_province','super_province.p_id = super_case.case_p_id')
                ->join('super_designer','super_designer.des_id = super_case.case_designer')
                ->join('super_type','super_type.type_id = super_case.case_style')
                ->join('super_admin','super_admin.ad_id = super_case.case_admin')
                ->where(['case_isable'=>2])
                ->where($where)
                ->count();
            //已展示
            $data['display']=Db::table('super_case')
                ->join('super_city','super_city.c_id = super_case.case_c_id')
                ->join('super_province','super_province.p_id = super_case.case_p_id')
                ->join('super_designer','super_designer.des_id = super_case.case_designer')
                ->join('super_type','super_type.type_id = super_case.case_style')
                ->join('super_admin','super_admin.ad_id = super_case.case_admin')
                ->where(['case_isable'=>1])
                ->where($where)
                ->count();
            //未展示
            $data['all']=intval($data['display'])+intval($data['none']);
            $decStyle=Db::table('super_type')
                ->where(['type_sort' => '2','type_isable' => '1'])
                ->order('type_order desc')
                ->field('type_id,type_name')
                ->select();
            foreach($decStyle as $k =>$v){
                $decStyle[$k]['count']=Db::table('super_case')
                    ->join('super_city','super_city.c_id = super_case.case_c_id')
                    ->join('super_province','super_province.p_id = super_case.case_p_id')
                    ->join('super_designer','super_designer.des_id = super_case.case_designer')
                    ->join('super_type','super_type.type_id = super_case.case_style')
                    ->join('super_admin','super_admin.ad_id = super_case.case_admin')
                    ->where($where)
                    ->where(['case_style' => $v['type_id']])
                    ->count();
            }
            $data['decStyle']=$decStyle;
            return $data;
        }
        //已展示
        $display=Db::table('super_case')
            ->join('super_city','super_city.c_id = super_case.case_c_id')
            ->join('super_province','super_province.p_id = super_case.case_p_id')
            ->join('super_designer','super_designer.des_id = super_case.case_designer')
            ->join('super_type','super_type.type_id = super_case.case_style')
            ->join('super_admin','super_admin.ad_id = super_case.case_admin')
            ->where($where)
            ->where(['case_isable'=>1])->count();
        $this->assign('display',$display);
        //未展示
        $none=Db::table('super_case')
            ->join('super_city','super_city.c_id = super_case.case_c_id')
            ->join('super_province','super_province.p_id = super_case.case_p_id')
            ->join('super_designer','super_designer.des_id = super_case.case_designer')
            ->join('super_type','super_type.type_id = super_case.case_style')
            ->join('super_admin','super_admin.ad_id = super_case.case_admin')
            ->where($where)
            ->where(['case_isable'=>2])->count();
        $this->assign('none',$none);
        //获取装修风格
        $decStyle=Db::table('super_type')
            ->where(['type_sort' => '2','type_isable' => '1'])
            ->order('type_order desc')
            ->field('type_id,type_name')
            ->select();
        foreach($decStyle as $k =>$v){
            $decStyle[$k]['count']=Db::table('super_case')
                ->join('super_city','super_city.c_id = super_case.case_c_id')
                ->join('super_province','super_province.p_id = super_case.case_p_id')
                ->join('super_designer','super_designer.des_id = super_case.case_designer')
                ->join('super_type','super_type.type_id = super_case.case_style')
                ->join('super_admin','super_admin.ad_id = super_case.case_admin')
                ->where($where)
                ->where(['case_style' => $v['type_id'],'case_isable' => 1])
                ->count();
        }
        //面积区间
        $areaRange=Db::table('super_type')
            ->where(['type_sort' => '5','type_isable' => '1'])
            ->order('type_order desc')
            ->field('type_id,type_name')
            ->select();
        $this->assign('areaRange',$areaRange);
        $styleConut=intval($display)+intval($none);
        $this->assign('styleConut',$styleConut);
        $this->assign('decStyle',$decStyle);
        $this->assign('ad_role',$ad_role);
        return $this->fetch();
    }



    public function expData(){
        $ad_role=intval(session('ad_role'));
        //分站id
        $ad_branch = intval(session('ad_branch'));
        if($ad_role == 1 ){// 超级管理员
            $where ='case_sort = 1 ';
        }else{
            $where='case_sort = 1 and case_b_id = '.$ad_branch;
        }
        $keywords=trim($this->request->param('keywords'));
        $case_p_id=intval(trim($this->request->param('case_p_id')));
        $bu_c_id=intval(trim($this->request->param('bu_c_id')));
        $branch=intval(trim($this->request->param('branch')));
        $case_area=trim($this->request->param('case_area'));
        $style_id=intval(trim($this->request->param('style_id')));
        $case_admin=intval(trim($this->request->param('case_admin')));
        $case_isable=intval(trim($this->request->param('case_isable')));
        $case_decotime=trim($this->request->param('case_decotime'));
        $case_designer=intval(trim($this->request->param('case_designer')));

        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( case_title like '%".$keywords."%' or case_bid like '%".$keywords."%' )";
        }
        if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
            $where.=" and case_p_id = ".$case_p_id;
        }
        if(isset($bu_c_id) && !empty($bu_c_id) && $case_p_id){
            $where.=" and case_c_id = ".$bu_c_id;
        }
        if(isset($branch) && !empty($branch) && $branch){
            $where.=" and case_b_id = ".$branch;
        }
        if(isset($style_id) && !empty($style_id) && $style_id){
            $where.=" and case_style = ".$style_id;
        }if(isset($case_isable) && !empty($case_isable) && $case_isable){
            $where.=" and case_isable = ".$case_isable;
        }
        if(isset($case_area) && !empty($case_area)){
            $areaInfo=Db::table('super_type')->where(['type_id' =>$case_area])->find();
            $areaRange=explode('-',$areaInfo['type_remarks']);
            $where.=" and case_area >= ".$areaRange[0]." and case_area <= ".$areaRange[1];
        }

        if(isset($case_isable) && !empty($case_isable)){
            $where.=" and case_isable = ".$case_isable;
        }
        if(isset($case_admin) && !empty($case_admin)){
            $where.=" and case_admin = ".$case_admin;
        }
        if(isset($case_designer) && !empty($case_designer)){
            $where.=" and case_designer = ".$case_designer;
        }
        if(isset($case_decotime) && !empty($case_decotime)){
            $sdate=strtotime(substr($case_decotime,'0','10')." 00:00:00");
            $edate=strtotime(substr($case_decotime,'-10')." 23:59:59");
            $where.=" and ( case_decotime >= ".$sdate." and case_decotime <= ".$edate." ) ";
        }
        $count=Db::table('super_case')
            ->join('super_city','super_city.c_id = super_case.case_c_id')
            ->join('super_province','super_province.p_id = super_case.case_p_id')
            ->join('super_designer','super_designer.des_id = super_case.case_designer')
            ->join('super_type','super_type.type_id = super_case.case_style')
            ->join('super_admin','super_admin.ad_id = super_case.case_admin')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $example=Db::table('super_case')
            ->join('super_city','super_city.c_id = super_case.case_c_id')
            ->join('super_province','super_province.p_id = super_case.case_p_id')
            ->join('super_designer','super_designer.des_id = super_case.case_designer')
            ->join('super_type','super_type.type_id = super_case.case_style')
            ->join('super_admin','super_admin.ad_id = super_case.case_admin')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('case_istop ASC ,case_isable Asc,case_view desc')
            ->select();
        foreach($example as $k => $v ){
            $example[$k]['case_updatetime'] = date('Y-m-d H:i:s',$v['case_updatetime']);
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
            $isRepeat=Db::table('super_case')->where(['case_title' => $data['case_title']])->find();
            if($isRepeat){
                $this->error('此案例名称与已有重复，请换一个！','add');
            }
            $data['case_style']=$_POST['case_style'];
            $data['case_p_id']= $ad_role == 1 ? $_POST['case_p_id']: session('ad_p_id');
            $data['case_c_id']=$ad_role == 1 ? $_POST['case_c_id']: session('ad_c_id');
            $data['case_b_id']=$ad_role == 1 ? $_POST['case_b_id']: session('ad_branch');
            $data['case_price']=intval($_POST['case_price']);
            $data['case_bulid']=$_POST['case_bulid'];
            $data['case_type_iamge']=$_POST['case_type_iamge'];
            $data['case_type_alt']=$_POST['case_type_alt'];
            $data['case_area']=$_POST['case_area'];
            $data['case_url']=$_POST['case_url'];
            $data['case_sort']=1;
            $data['case_remarks']=$_POST['case_remarks'];
            $data['case_designer']=$_POST['case_designer'];
            $data['case_istop']=$_POST['case_istop'];
            $data['case_seo_keywords']=$_POST['case_seo_keywords'];
            $data['case_decotime']=time();
            $data['case_updatetime']=time();
            $data['case_admin'] = session('adminId');
            $add=Db::table('super_case')->insert($data);
            if($add){
                $this->success('发布案例成功！','example');
            }else{
                $this->error('发布案例失败！','example');
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
            //房屋类型
            $houseType=Db::table('super_type')->where(['type_isable' => '1','type_sort' => '4'])->field('type_id,type_name')->select();
            $this->assign('houseType',$houseType);
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
            $provInfo=Db::table('super_province')->select();
            $this->assign('prov',$provInfo);
            return $this->fetch();
        }
    }




    //修改案例内容
    public function edit(){
        $ad_role=intval(session('ad_role'));
        $case_id=intval($_GET['case_id']);
        if($_POST){
            $data['case_img'] = implode(',',$_POST['case_img']);
            $data['case_img_alt'] = implode(',',$_POST['case_img_alt']);
            $data['case_title']=$_POST['case_title'];
            $isRepeat=Db::table('super_case')
                ->where('case_id','neq',$case_id)
                ->where(['case_title' => $data['case_title']])
                ->find();
            if($isRepeat){
                $this->error('此楼盘名称与已有重复，请换一个！','example');
                //$this->error('此楼盘名称已被占用','edit',array('bu_id'=>$bu_id));
            }
            $data['case_style']=$_POST['case_style'];
            $data['case_price']=intval($_POST['case_price']);
            $data['case_bulid']=$_POST['case_bulid'];
            if($ad_role == 1){
                $data['case_p_id']=$_POST['case_p_id'];
                $data['case_c_id']=$_POST['case_c_id'];
                $data['case_b_id']=$_POST['case_b_id'];
            }
            $data['case_type_iamge']=$_POST['case_type_iamge'];
            $data['case_type_alt']=$_POST['case_type_alt'];
            $data['case_area']=$_POST['case_area'];
            $data['case_url']=$_POST['case_url'];
            $data['case_remarks']=$_POST['case_remarks'];
            $data['case_designer']=$_POST['case_designer'];
            $data['case_istop']=$_POST['case_istop'];
            $data['case_seo_keywords']=$_POST['case_seo_keywords'];
            $data['case_updatetime']=time();
            $data['case_admin'] = session('adminId');
            $edit=Db::table('super_case')->where(['case_id'=>$case_id])->update($data);
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
            //房屋类型
            $houseType=Db::table('super_type')->where(['type_isable' => '1','type_sort' => '4'])->field('type_id,type_name')->select();
            $this->assign('houseType',$houseType);
            $this->assign('city',$city);
            $this->assign('case',$artInfo);
            $this->assign('ad_role',$ad_role);
            return $this->fetch();
        }
    }

    //刷新某一案例
    public function refresh(){
        $case_id=intval($_GET['case_id']);
        $refresh=Db::table('super_case')->where(['case_id' => $case_id])->update(['case_updatetime' => time()]);
        if($refresh){
            $this->success('刷新案例成功','example');
        }else{
            $this->error('刷新案例失败','example');
        }
    }




    //检测楼盘名称的唯一性
    public function checkBuname(){
        $case_id=$_POST['case_id'];
        $case_title=$_POST['case_title'];
        if(isset($case_id)){
            $isRepeat=Db::table('super_case')
                ->where('case_id','neq',$case_id)
                ->where(['case_title' => $case_title])
                ->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '此案例名称与已有重复，请换一个！';
            }else{
                $res['code'] = 1;
                $res['msg'] = '此名称经过检测可用。';
            }
        }else{
            $isRepeat=Db::table('super_case')->where(['case_title' => $case_title])->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '此案例名称与已有重复，请换一个！';
            }else {
                $res['code'] = 1;
                $res['msg'] = '此名称经过检测可用。';
            }
        }
        return $res;
    }












    //删除某一案例
    public function del(){
        $case_id=intval($_GET['case_id']);
        $delArt=Db::table('super_case')->where(['case_id' => $case_id])->delete();
        if($delArt){
            $this->success('删除案例成功','example');
        }else{
            $this->error('删除案例失败','example');
        }
    }


    //更改是否显示的状态
    public function status(){
        $ba_id = $_GET['case_id'];
        $change = $_GET['change'];
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '显示';
                $data['case_isable'] = '1';
                $data['case_admin'] = session('adminId');
            }else{
                $msg = '隐藏';
                $data['case_isable'] = '2';
                $data['case_istop'] = '2';
                $data['case_admin'] = session('adminId');
            }
            $changeStatus = Db::table('super_case')->where(['case_id' => $ba_id])->update($data);
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
        $ba_id = $_GET['case_id'];
        $change = $_GET['change'];
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '置顶';
                $data['case_istop'] = '1';
                $data['case_admin'] = session('adminId');
            }else{
                $msg = '取消置顶';
                $data['case_istop'] = '2';
                $data['case_admin'] = session('adminId');
            }
            $changeStatus = Db::table('super_case')->where(['case_id' => $ba_id])->update($data);
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


    public function editUpload(Request $request)
    {
        $file 	= $request->file('file');
        $info 	= $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $name_path =str_replace('\\',"/",$info->getSaveName());
            $result['data']["src"] = "/uploads/layui/".$name_path;
            $url 	= $info->getSaveName();
            //图片上传成功后，组好json格式，返回给前端
            $arr   = array(
                'code' => 0,
                'message'=>'',
                'data' =>array(
                    'src' => "/uploads/".$name_path
                ),
            );
        }
        echo json_encode($arr);
    }


    //案例图片上传
    public function upload(){
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/example');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/example/".$path_date."/".$path_filename;
            // 成功上传后 返回上传信息
            return json(array('state'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
        }else{
            // 上传失败返回错误信息
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }

//    public function upload(){
//        $pathName  =  $this->request->param('path');//图片存放的目录
//        $file = request()->file('file');//获取文件信息
//        $path =  'static/uploads/' . (!empty($pathName) ? $pathName : 'case_images');//文件目录
//        //创建文件夹
//        if(!is_dir($path)){
//            mkdir($path, 0755, true);
//        }
//        $info = $file->move($path);//保存在目录文件下
//        if ($info && $info->getPathname()) {
//            $data = [
//                'status' => 1,
//                'data' =>  '/'.$info->getPathname(),
//            ];
//            echo exit(json_encode($data));
//        } else {
//            echo exit(json_encode($file->getError()));
//        }
//    }
}