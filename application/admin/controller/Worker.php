<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/6/4
 * Time: 11:24
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;

class Worker extends Controller{

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

    //工长
    public function workerData(){

        $ad_role=intval(session('ad_role'));
        //分站id
        $ad_branch = intval(session('ad_branch'));
        if($ad_role == 1 ){// 超级管理员
            $where =' 1 = 1';
        }else{
            $where=' wk_b_id = '.$ad_branch;
        }
        $keywords = trim($this->request->param('keywords'));
        $case_p_id = intval(trim($this->request->param('case_p_id')));
        $bu_c_id = intval(trim($this->request->param('bu_c_id')));
        $branch = intval(trim($this->request->param('branch')));
        $case_admin = intval(trim($this->request->param('case_admin')));
        $case_isable = intval(trim($this->request->param('case_isable')));
        $case_decotime=trim($this->request->param('case_decotime'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( wk_name like '%".$keywords."%' or wk_bid like '%".$keywords."%' )";
        }
        if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
            $where.=" and wk_p_id = ".$case_p_id;
        }
        if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
            $where.=" and wk_c_id = ".$bu_c_id;
        }
        if(isset($branch) && !empty($branch) && $branch){
            $where.=" and wk_b_id = ".$branch;
        }
        if(isset($case_isable) && !empty($case_isable)){
            $where.=" and wk_isable = ".$case_isable;
        }
        if(isset($case_admin) && !empty($case_admin)){
            $where.=" and wk_admin = ".$case_admin;
        }
        if(isset($case_decotime) && !empty($case_decotime)){
            $sdate=strtotime(substr($case_decotime,'0','10')." 00:00:00");
            $edate=strtotime(substr($case_decotime,'-10')." 23:59:59");
            $where.=" and ( wk_addtime >= ".$sdate." and wk_addtime <= ".$edate." ) ";
        }
        $count=Db::table('super_worker')
            ->join('super_province','super_province.p_id = super_worker.wk_p_id')
            ->join('super_city','super_city.c_id = super_worker.wk_c_id')
            ->join('super_branch','super_branch.b_id = super_worker.wk_b_id')
            ->join('super_admin','super_admin.ad_id = super_worker.wk_admin')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $worker=Db::table('super_worker')
            ->join('super_province','super_province.p_id = super_worker.wk_p_id')
            ->join('super_city','super_city.c_id = super_worker.wk_c_id')
            ->join('super_branch','super_branch.b_id = super_worker.wk_b_id')
            ->join('super_admin','super_admin.ad_id = super_worker.wk_admin')
            ->limit(($page-1)*$limit,$limit)
            ->order('wk_istop asc,wk_view desc')
            ->where($where)
            ->select();
        if($worker){
            foreach($worker as $key => $val){
                $worker[$key]['wk_updatetime'] = date('Y-m-d H:i:s',$val['wk_updatetime']);
                $worker[$key]['c_name'] = $val['p_name']."-".$val['c_name'];
                $worker[$key]['site_num']=Db::table('super_worksite')->where(['w_worker' => $val['wk_id']])->count();
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $worker;
        $res['count'] = $count;
        return json($res);
    }

    //施工团队
    public function index(){
        if($_POST){
            $where = " 1 = 1";
            $keywords=trim($_POST['keywords']);
            $case_p_id=trim($_POST['case_p_id']);
            $bu_c_id=trim($_POST['bu_c_id']);
            $branch=trim($_POST['branch']);
            $case_decotime=trim($_POST['case_decotime']);
            $case_admin=intval(trim($_POST['case_admin']));

            if(isset($keywords) && !empty($keywords)){
            $where.=" and ( wk_name like '%".$keywords."%' or wk_bid like '%".$keywords."%' )";
            }
            if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
                $where.=" and wk_p_id = ".$case_p_id;
            }
            if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
                $where.=" and wk_c_id = ".$bu_c_id;
            }
            if(isset($branch) && !empty($branch) && $branch){
                $where.=" and wk_b_id = ".$branch;
            }
            if(isset($case_isable) && !empty($case_isable)){
                $where.=" and wk_isable = ".$case_isable;
            }
            if(isset($case_admin) && !empty($case_admin)){
                $where.=" and wk_admin = ".$case_admin;
            }
            if(isset($case_decotime) && !empty($case_decotime)){
                $sdate=strtotime(substr($case_decotime,'0','10')." 00:00:00");
                $edate=strtotime(substr($case_decotime,'-10')." 23:59:59");
                $where.=" and ( wk_addtime >= ".$sdate." and wk_addtime <= ".$edate." ) ";
            }
            //已展示
            $data['display']=Db::table('super_worker')
                ->join('super_province','super_province.p_id = super_worker.wk_p_id')
                ->join('super_city','super_city.c_id = super_worker.wk_c_id')
                ->join('super_branch','super_branch.b_id = super_worker.wk_b_id')
                ->join('super_admin','super_admin.ad_id = super_worker.wk_admin')
                ->where($where)
                ->where(['wk_isable' => 1])
                ->count();
            //未展示
            $data['none']=Db::table('super_worker')
                ->join('super_province','super_province.p_id = super_worker.wk_p_id')
                ->join('super_city','super_city.c_id = super_worker.wk_c_id')
                ->join('super_branch','super_branch.b_id = super_worker.wk_b_id')
                ->join('super_admin','super_admin.ad_id = super_worker.wk_admin')
                ->where($where)
                ->where(['wk_isable' => 2])
                ->count();
            $data['all']=intval($data['display'])+intval($data['none']);
            return $data;
        }
        $disShow=Db::table('super_worker')
        ->where(['wk_isable' => 1])
        ->count();
        $disNone=Db::table('super_worker')
            ->where(['wk_isable' => 2])
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

    //更改是否显示的状态
    public function status(){
        $wk_id = intval($_GET['wk_id']);
        $change = $_GET['change'];
        if($wk_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '显示';
                $data['wk_isable'] = '1';
            }else{
                $msg = '隐藏';
                $data['wk_isable'] = '2';
            }
            $changeStatus = Db::table('super_worker')->where(['wk_id' => $wk_id])->update($data);
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
        $wk_id = $_GET['wk_id'];
        $change = $_GET['change'];
        if($wk_id && isset($change)){
            if($change){
                $msg = '置顶';
                $data['wk_istop'] = '1';
            }else{
                $msg = '取消置顶';
                $data['wk_istop'] = '2';
            }
            $changeStatus = Db::table('super_worker')->where(['wk_id' => $wk_id])->update($data);
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


    //添加工长
    public function add(){
        if($_POST){
            $stime=strtotime(date('Y-m-d 00:00:00'));
            $etime=strtotime(date('Y-m-d 23:59:59'));
            //获取当日预约的数量
            $buNum=Db::table('super_worker')->where('wk_addtime','between',[$stime,$etime])->count();
            //生成用户编号；
            $data['wk_bid'] = date('Ymd').sprintf("%04d", $buNum+1);
            $data['wk_name'] = $_POST['wk_name'];
            $data['wk_img'] = $_POST['wk_img'];
            $data['wk_avatar'] = $_POST['wk_avatar'];
            $data['wk_img_alt'] = $_POST['wk_img_alt'];
            $data['wk_des'] = $_POST['wk_des'];
            $data['wk_p_id'] = $_POST['wk_p_id'];
            $data['wk_c_id'] = $_POST['wk_c_id'];
            $data['wk_b_id'] = $_POST['wk_b_id'];
            $data['wk_istop'] = $_POST['wk_istop'];
            $data['wk_seo_keywords'] = $_POST['wk_seo_keywords'];
            $data['wk_addtime'] = time();
            $data['wk_updatetime'] = time();
            $data['wk_admin'] = session('adminId');
            $add=Db::table('super_worker')->insert($data);
            if($add){
                $this->success('添加工长成功','index');
            }else{
                $this->error('添加工长失败','index');
            }
        }else{
            $provInfo=Db::table('super_province')->select();
            $this->assign('prov',$provInfo);
            return $this->fetch();
        }
    }


    //修改工长
    public function edit(){
        $wk_id=intval($_GET['wk_id']);
        if($_POST){
            $data['wk_name'] = $_POST['wk_name'];
            $data['wk_img'] = $_POST['wk_img'];
            $data['wk_avatar'] = $_POST['wk_avatar'];
            $data['wk_img_alt'] = $_POST['wk_img_alt'];
            $data['wk_des'] = $_POST['wk_des'];
            $data['wk_p_id'] = $_POST['wk_p_id'];
            $data['wk_c_id'] = $_POST['wk_c_id'];
            $data['wk_b_id'] = $_POST['wk_b_id'];
            $data['wk_istop'] = $_POST['wk_istop'];
            $data['wk_seo_keywords'] = $_POST['wk_seo_keywords'];
            $data['wk_updatetime'] = time();
            $data['wk_admin'] = session('adminId');
            $edit=Db::table('super_worker')->where(['wk_id' => $wk_id])->update($data);
            if($edit){
                $this->success('修改工长成功！','index');
            }else{
                $this->error('修改工长失败！','index');
            }
        }else{
            $workerInfo=Db::table('super_worker')->where(['wk_id' => $wk_id])->find();
            $provInfo=Db::table('super_province')->select();
            $provid=$workerInfo['wk_p_id'];
            $cusCity=Db::table('super_city')->where(['p_id' => $provid])->select();
            $c_id=$workerInfo['wk_c_id'];
            $branch=Db::table('super_branch')->where(['b_city' =>$c_id ])->field('b_id,b_name')->select();
            $this->assign('branchs',$branch);
            $this->assign('prov',$provInfo);
            $this->assign('city',$cusCity);
            $this->assign('worker',$workerInfo);
            return $this->fetch();
        }
    }



    //删除工长
    public function del(){
        $wk_id=intval($_GET['wk_id']);
        $del=Db::table('super_worker')->where(['wk_id' => $wk_id])->delete();
        if($del){
            $this->success('删除工长成功','index');
        }else{
            $this->error('删除工长失败','index');
        }
    }

    //刷新工长
    public function refresh(){
        $wk_id=intval($_GET['wk_id']);
        $del=Db::table('super_worker')->where(['wk_id' => $wk_id])->update(['wk_updatetime' => time()]);
        if($del){
            $this->success('刷新工长成功','index');
        }else{
            $this->error('刷新工长失败','index');
        }
    }


    //工长图片上传
    public function upload(){
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/worker');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/worker/".$path_date."/".$path_filename;
            // 成功上传后 返回上传信息
            return json(array('state'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
        }else{
            // 上传失败返回错误信息
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }
}