<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/5/2
 * Time: 10:15
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
class Building extends Controller{
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

    //小区楼盘
    public function buildsData(){
        $ad_role=intval(session('ad_role'));
        //分站id
        $ad_branch = intval(session('ad_branch'));
        if($ad_role == 1 ){// 超级管理员
            $where =' 1 = 1';
        }else{
            $where=' bu_branch = '.$ad_branch;
        }
        $keywords=trim($this->request->param('keywords'));
        $case_p_id=intval(trim($this->request->param('case_p_id')));
        $bu_c_id=intval(trim($this->request->param('bu_c_id')));
        $branch=intval(trim($this->request->param('branch')));
        $bu_isable=intval(trim($this->request->param('bu_isable')));
        $case_admin=intval(trim($this->request->param('case_admin')));
        $case_decotime=trim($this->request->param('case_decotime'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( bu_name like '%".$keywords."%' or bu_bid like '%".$keywords."%' )";
        }
        if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
            $where.=" and bu_p_id = ".$case_p_id;
        }
        if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
            $where.=" and bu_c_id = ".$bu_c_id;
        }
        if(isset($branch) && !empty($branch) && $branch){
            $where.=" and bu_branch = ".$branch;
        }
        if(isset($bu_isable) && !empty($bu_isable)){
            $where.=" and bu_isable = ".$bu_isable;
        }
        if(isset($case_admin) && !empty($case_admin)){
            $where.=" and bu_admin = ".$case_admin;
        }
        if(isset($case_decotime) && !empty($case_decotime)){
            $sdate=strtotime(substr($case_decotime,'0','10')." 00:00:00");
            $edate=strtotime(substr($case_decotime,'-10')." 23:59:59");
            $where.=" and ( bu_createtime >= ".$sdate." and bu_createtime <= ".$edate." ) ";
        }
        $count=Db::table('super_buildings')
                ->join('super_province','super_province.p_id = super_buildings.bu_p_id')
                ->join('super_city','super_city.c_id = super_buildings.bu_c_id')
                ->join('super_branch','super_branch.b_id = super_buildings.bu_branch')
                ->join('super_admin','super_admin.ad_id = super_buildings.bu_admin')
                ->where($where)
                ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $builds=Db::table('super_buildings')
            ->join('super_province','super_province.p_id = super_buildings.bu_p_id')
            ->join('super_city','super_city.c_id = super_buildings.bu_c_id')
            ->join('super_branch','super_branch.b_id = super_buildings.bu_branch')
            ->join('super_admin','super_admin.ad_id = super_buildings.bu_admin')
            ->limit(($page-1)*$limit,$limit)
            ->where($where)
            ->order('bu_istop ASC,bu_view desc')
            ->select();
        foreach ($builds as $k =>$v){
            $builds[$k]['bu_updatetime'] = date('Y-m-d H:i:s',$v['bu_updatetime']);
            $builds[$k]['c_name'] = $v['p_name']."-".$v['c_name'];
            $builds[$k]['bu_case_num'] = Db::table('super_case')->where(['case_bulid' => $v['bu_id'],'case_sort' => 1,'case_isable' =>1])->count();
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $builds;
        $res['count'] = $count;
        return json($res);

    }



    public function builds(){
        $ad_role=intval(session('ad_role'));
        $this->assign('ad_role',$ad_role);
        //分站id
        $ad_branch = intval(session('ad_branch'));
        if($ad_role == 1 ){// 超级管理员
            $design=Db::table('super_designer')->where(['des_isable' => '1'])->field('des_id,des_name')->select();
            $admin = Db::table('super_admin')->where(['ad_isable' => 1])->select();
            $where =' 1 = 1';
        }else{
            $design=Db::table('super_designer')->where(['des_isable' => '1','des_b_id' => $ad_branch])->field('des_id,des_name')->select();
            $admin = Db::table('super_admin')->where(['ad_isable' => 1,'ad_branch' => $ad_branch])->select();
            $where=' bu_branch = '.$ad_branch;
        }
        $this->assign('design',$design);
        $this->assign('admin',$admin);
        if($_POST){
            $where = " 1 = 1";
            $keywords=trim($_POST['keywords']);
            $case_p_id=trim($_POST['case_p_id']);
            $bu_c_id=trim($_POST['bu_c_id']);
            $branch=trim($_POST['branch']);
            $case_decotime=trim($_POST['case_decotime']);
            $case_admin=intval(trim($_POST['case_admin']));

            if(isset($keywords) && !empty($keywords)){
                $where.=" and ( bu_name like '%".$keywords."%' or bu_bid like '%".$keywords."%' )";
            }
            if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
                $where.=" and bu_p_id = ".$case_p_id;
            }
            if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
                $where.=" and bu_c_id = ".$bu_c_id;
            }
            if(isset($branch) && !empty($branch) && $branch){
                $where.=" and bu_branch = ".$branch;
            }
            if(isset($case_isable) && !empty($case_isable)){
                $where.=" and bu_isable = ".$case_isable;
            }
            if(isset($case_admin) && !empty($case_admin)){
                $where.=" and bu_admin = ".$case_admin;
            }
            if(isset($case_decotime) && !empty($case_decotime)){
                $sdate=strtotime(substr($case_decotime,'0','10')." 00:00:00");
                $edate=strtotime(substr($case_decotime,'-10')." 23:59:59");
                $where.=" and ( bu_createtime >= ".$sdate." and bu_createtime <= ".$edate." ) ";
            }
            //已展示
            $data['display']=Db::table('super_buildings')
                ->join('super_province','super_province.p_id = super_buildings.bu_p_id')
                ->join('super_city','super_city.c_id = super_buildings.bu_c_id')
                ->join('super_branch','super_branch.b_id = super_buildings.bu_branch')
                ->join('super_admin','super_admin.ad_id = super_buildings.bu_admin')
                ->where($where)
                ->where(['bu_isable' => 1])
                ->count();
            //未展示
            $data['none']=Db::table('super_buildings')
                ->join('super_province','super_province.p_id = super_buildings.bu_p_id')
                ->join('super_city','super_city.c_id = super_buildings.bu_c_id')
                ->join('super_branch','super_branch.b_id = super_buildings.bu_branch')
                ->join('super_admin','super_admin.ad_id = super_buildings.bu_admin')
                ->where($where)
                ->where(['bu_isable' => 2])
                ->count();
            $data['all']=intval($data['display'])+intval($data['none']);
            return $data;
        }else{
            $disShow=Db::table('super_buildings')
                ->where($where)
                ->where(['bu_isable' => 1])
                ->count();
            $disNone=Db::table('super_buildings')
                ->where($where)
                ->where(['bu_isable' => 2])
                ->count();
            $this->assign('show',$disShow);
            $this->assign('none',$disNone);
            $this->assign('all',intval($disShow)+intval($disNone));
            return $this->fetch();
        }
    }


    //检测楼盘名称的唯一性
    public function checkBuname(){
        $bu_id=$_POST['bu_id'];
        $bu_name=$_POST['bu_name'];
        if($bu_id){
            $isRepeat=Db::table('super_buildings')
                ->where('bu_id','neq',$bu_id)
                ->where(['bu_name' => $bu_name])
                ->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '此楼盘名称与已有重复，请换一个！';
            }else{
                $res['code'] = 1;
                $res['msg'] = '此名称经过检测可用。';
            }
        }else{
            $isRepeat=Db::table('super_buildings')->where(['bu_name' => $bu_name])->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '此楼盘名称与已有重复，请换一个！';
            }else {
                $res['code'] = 1;
                $res['msg'] = '此名称经过检测可用。';
            }
        }
        return $res;
    }







    //更改是否显示的状态
    public function status(){
        $ba_id = intval($_GET['bu_id']);
        $change = intval($_GET['change']);
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '显示';
                $data['bu_isable'] = '1';
                $data['bu_admin'] = session('adminId');
            }else{
                $msg = '隐藏';
                $data['bu_isable'] = '2';
                $data['bu_admin'] = session('adminId');
            }
            $changeStatus = Db::table('super_buildings')->where(['bu_id' => $ba_id])->update($data);
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
    public function top(){
        $ba_id = intval($_GET['bu_id']);
        $change = intval($_GET['change']);
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '置顶';
                $data['bu_istop'] = '1';
                $data['bu_admin'] = session('adminId');
            }else{
                $msg = '取消置顶';
                $data['bu_istop'] = '2';
                $data['bu_admin'] = session('adminId');
            }
            $changeStatus = Db::table('super_buildings')->where(['bu_id' => $ba_id])->update($data);
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



    //添加楼盘
    public function add(){
        $adminId=intval(session('adminId'));
        $ad_role=intval(session('ad_role'));
        if($_POST){
            $stime=strtotime(date('Y-m-d 00:00:00'));
            $etime=strtotime(date('Y-m-d 23:59:59'));
            //获取当日预约的数量
            $buNum=Db::table('super_buildings')->where('bu_createtime','between',[$stime,$etime])->count();
            //生成用户编号；
            $data['bu_bid'] = date('Ymd').sprintf("%04d", $buNum+1);
            $data['bu_name'] = $_POST['bu_name'];
            $isRepeat=Db::table('super_buildings')->where(['bu_name' => $data['bu_name']])->find();
            if($isRepeat){
                $this->error('此楼盘名称与已有重复，请换一个！','add');
            }
            $data['bu_desc'] = $_POST['bu_desc'];
            $data['bu_location'] = $_POST['bu_location'];
            $data['bu_address'] = $_POST['bu_address'];
            $data['bu_p_id'] = $ad_role == 1 ? $_POST['bu_p_id']: session('ad_p_id');
            $data['bu_c_id'] = $ad_role == 1 ? $_POST['bu_c_id']: session('ad_c_id');
            $data['bu_branch'] = $ad_role == 1 ? $_POST['bu_branch']: session('ad_branch');
            $data['bu_img_alt'] = $_POST['bu_img_alt'];
            $data['bu_img'] = $_POST['bu_img'];
            $data['bu_seo_keywords'] = $_POST['bu_seo_keywords'];
            $data['bu_activity'] = $_POST['bu_activity'];
            $data['bu_url'] = $_POST['bu_url'];
            $data['bu_istop'] = $_POST['bu_istop'];
            $data['bu_createtime'] =time();
            $data['bu_updatetime'] =time();
            $data['bu_admin'] =$adminId;
            $add=Db::table('super_buildings')->insert($data);
            if($add){
                $this->success('添加楼盘成功','builds');
            }else{
                $this->error('添加楼盘失败','builds');
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

    //修改楼盘
    public function edit(){
        $ad_role=intval(session('ad_role'));
        $bu_id=intval(trim($this->request->param('bu_id')));
        if($_POST){
            $data['bu_name'] = $_POST['bu_name'];
            $isRepeat=Db::table('super_buildings')
                ->where('bu_id','neq',$bu_id)
                ->where(['bu_name' => $data['bu_name']])
                ->find();
            if($isRepeat){
                $this->error('此楼盘名称与已有重复，请换一个！','builds');
                //$this->error('此楼盘名称已被占用','edit',array('bu_id'=>$bu_id));
            }
            $data['bu_desc'] = $_POST['bu_desc'];
            $data['bu_location'] = $_POST['bu_location'];
            $data['bu_address'] = $_POST['bu_address'];
            $data['bu_img'] = $_POST['bu_img'];
            if($ad_role == 1){
                $data['bu_p_id'] = $_POST['bu_p_id'];
                $data['bu_c_id'] = $_POST['bu_c_id'];
                $data['bu_branch'] = $_POST['bu_branch'];
            }
            $data['bu_img_alt'] = $_POST['bu_img_alt'];
            $data['bu_seo_keywords'] = $_POST['bu_seo_keywords'];
            $data['bu_activity'] = $_POST['bu_activity'];
            $data['bu_url'] = $_POST['bu_url'];
            $data['bu_istop'] = $_POST['bu_istop'];
            $data['bu_updatetime'] =time();
            $data['bu_admin'] = session('adminId');
            $edit=Db::table('super_buildings')->where(['bu_id' => $bu_id])->update($data);
            if($edit){
                $this->success('修改楼盘成功！','builds');
            }else{
                $this->error('修改楼盘失败！','builds');
            }
        }else{
            $buildsInfo=Db::table('super_buildings')
                ->join('super_province','super_province.p_id = super_buildings.bu_p_id')
                ->join('super_city','super_city.c_id = super_buildings.bu_c_id')
                ->join('super_branch','super_branch.b_id = super_buildings.bu_branch')
                ->where(['bu_id' => $bu_id])
                ->field('super_buildings.*,super_province.p_name,super_city.c_name,super_branch.b_name')
                ->find();
            $provInfo=Db::table('super_province')->select();
            $provid=$buildsInfo['bu_p_id'];
            $cusCity=Db::table('super_city')->where(['p_id' => $provid])->select();
            $c_id=$buildsInfo['bu_c_id'];
            $branch=Db::table('super_branch')->where(['b_city' =>$c_id ])->field('b_id,b_name')->select();
            $this->assign('branchs',$branch);
            $this->assign('prov',$provInfo);
            $this->assign('city',$cusCity);
            $this->assign('builds',$buildsInfo);
            $this->assign('ad_role',$ad_role);
            return $this->fetch();
        }
    }


    //删除楼盘
    public function del(){
        $bu_id=intval($_GET['bu_id']);
        $del=Db::table('super_buildings')->where(['bu_id' => $bu_id])->delete();
        if($del){
            $this->success('删除楼盘成功','builds');
        }else{
            $this->error('删除楼盘失败','builds');
        }
    }



    //刷新某一楼盘数据
    public function refresh(){
        $bu_id=intval($_GET['bu_id']);
        $refresh=Db::table('super_buildings')->where(['bu_id' => $bu_id])->update(['bu_updatetime' => time()]);
        if($refresh){
            $this->success('刷新楼盘成功','builds');
        }else{
            $this->error('刷新楼盘失败','builds');
        }
    }

    //楼盘图片上传
    public function upload(){
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/building');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/building/".$path_date."/".$path_filename;
            // 成功上传后 返回上传信息
            return json(array('state'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
        }else{
            // 上传失败返回错误信息
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }



}