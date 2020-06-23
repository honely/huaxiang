<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/4/18
 * Time: 10:52
 */
namespace app\xcx\controller;
use app\xcx\model\Rolem;
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
    //banner
    public function index(){
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $addable = in_array('257',$power_list,true);
        $editable = in_array('258',$power_list,true);
        $delable = in_array('259',$power_list,true);
        $offable = in_array('280',$power_list,true);
        $this->assign('addable',$addable);
        $this->assign('editable',$editable);
        $this->assign('delable',$delable);
        $this->assign('offable',$offable);
        return $this->fetch();
    }

    public function baData(){
        $where ='b_status = 1 ';
        $count=Db::table('xcx_banner')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',50,'intval');
        $example=Db::table('xcx_banner')->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('b_order desc,b_update_time desc')
            ->select();
        if($example){
            foreach ($example as $k => $v){
                $example[$k]['b_class'] = $this->getType($v['b_class']);
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $example;
        $res['count'] = $count;
        return json($res);
    }

    public function getType($type){
        switch ($type){
//        一室，两室，三室，三室以上
            case 1:
                $room = '首页轮播';
                break;
            case 2:
                $room = '详情页广告';
                break;
            case 3:
                $room = '列表广告';
                break;
            default:
                $room ='首页轮播';
        }
        return $room;
    }

    public function loop(){
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
                $data['b_status'] = '1';
            }else{
                $msg = '隐藏';
                $data['b_status'] = '2';
            }
            $changeStatus = Db::table('xcx_banner')->where(['b_id' => $ba_id])->update($data);
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
            $reOrder=Db::table('xcx_banner')->where(['b_id' => $ba_id])->update(['b_order' => $ba_order]);
            if($reOrder){
                $this->success('修改排序成功！');
            }else{
                $this->error('修改排序失败！');
            }
        }else{
            $this->error('请输入一个整数数字！');
        }
    }










    public function add(){
        $adminId=intval(session('adminId'));
        if($_POST){
            $data['b_title']=$_POST['b_title'];
            $data['b_cover']=$_POST['b_cover'];
            $data['b_class']=$_POST['b_class'];
            $data['b_content']=$_POST['b_content'];
            $data['b_url']=$_POST['b_url'];
            $data['b_add_time']= date('Y-m-d H:i:s');
            $data['b_update_time']= date('Y-m-d H:i:s');
            $data['b_order']=$_POST['b_order'];
            $data['b_status']=1;
            $data['b_admin'] = $adminId;
            $addBan=Db::table('xcx_banner')->insert($data);
            if($addBan){
                $this->success('添加banner成功！','index');
            }else{
                $this->error('添加banner失败!','index');
            }
        }else{
            return $this->fetch();
        }
    }

    public function edit(){
        $adminId=intval(session('adminId'));
        $ba_id=$_GET['b_id'];
        if($_POST){
            $data['b_title']=$_POST['b_title'];
            $data['b_cover']=$_POST['b_cover'];
            $data['b_url']=$_POST['b_url'];
            $data['b_class']=$_POST['b_class'];
            $data['b_content']=$_POST['b_content'];
            $data['b_add_time']= date('Y-m-d H:i:s');
            $data['b_update_time']= date('Y-m-d H:i:s');
            $data['b_order']=$_POST['b_order'];
            $data['b_status']=1;
            $data['b_admin'] = $adminId;
            $update=Db::table('xcx_banner')->where(['b_id'=> $ba_id])->update($data);
            if($update){
                $this->success('修改banner成功！','index');
            }else{
                $this->error('您未做任何修改！','index');
            }
        }else{
            $banInfo=Db::table('xcx_banner')
                ->where(['b_id'=> $ba_id])
                ->find();
            $this->assign('ban',$banInfo);
            return $this->fetch();
        }
    }

    //删除banner图；
    public function del(){
        $ba_id=intval(trim($_GET['b_id']));
        $delBan=Db::table('xcx_banner')->where(['b_id'=>$ba_id])->delete();
        if($delBan){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！','index');
        }
    }


    public function upload()
    {
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
        $limit=$this->request->param('limit',50,'intval');
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
}