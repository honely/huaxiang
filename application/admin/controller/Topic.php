<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/5/2
 * Time: 16:02
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;

class Topic extends Controller{
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
    public function topicData(){

        $ad_role=intval(session('ad_role'));
        //分站id
        $ad_branch = intval(session('ad_branch'));
        if($ad_role == 1 ){// 超级管理员
            $where =' 1 = 1';
        }else{
            $where=' tp_b_id = '.$ad_branch;
        }
        $keywords=$this->request->param('keywords');
        $case_p_id=$this->request->param('case_p_id');
        $bu_c_id=$this->request->param('bu_c_id');
        $branch=$this->request->param('branch');
        $case_isable=$this->request->param('case_isable');
        $case_admin=$this->request->param('case_admin');
        $case_decotime=$this->request->param('case_decotime');
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( tp_title like '%".$keywords."%' or tp_bid like '%".$keywords."%' )";
        }
        if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
            $where.=" and tp_p_id = ".$case_p_id;
        }
        if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
            $where.=" and tp_c_id = ".$bu_c_id;
        }
        if(isset($branch) && !empty($branch) && $branch){
            $where.=" and tp_b_id = ".$branch;
        }
        if(isset($case_isable) && !empty($case_isable)){
            $where.=" and tp_isable = ".$case_isable;
        }
        if(isset($case_admin) && !empty($case_admin)){
            $where.=" and tp_admin = ".$case_admin;
        }
        if(isset($case_decotime) && !empty($case_decotime)){
            $sdate=strtotime(substr($case_decotime,'0','10')." 00:00:00");
            $edate=strtotime(substr($case_decotime,'-10')." 23:59:59");
            $where.=" and ( tp_createtime >= ".$sdate." and tp_createtime <= ".$edate." ) ";
        }

        $count=Db::table('super_topic')
            ->join('super_province','super_province.p_id = super_topic.tp_p_id')
            ->join('super_city','super_city.c_id = super_topic.tp_c_id')
            ->join('super_branch','super_branch.b_id = super_topic.tp_b_id')
            ->join('super_admin','super_admin.ad_id = super_topic.tp_admin')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $topic=Db::table('super_topic')
            ->join('super_province','super_province.p_id = super_topic.tp_p_id')
            ->join('super_city','super_city.c_id = super_topic.tp_c_id')
            ->join('super_branch','super_branch.b_id = super_topic.tp_b_id')
            ->join('super_admin','super_admin.ad_id = super_topic.tp_admin')
            ->limit(($page-1)*$limit,$limit)
            ->order('tp_id desc')
            ->where($where)
            ->select();
        foreach ($topic as $k =>$v){
            $topic[$k]['tp_createtime'] = date('Y-m-d H:i:s',$v['tp_createtime']);
            $topic[$k]['c_name'] = $v['p_name']."-".$v['c_name']."-".$v['b_name'];
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $topic;
        $res['count'] = $count;
        return json($res);
    }



    public function index(){
        $branchId=session('cus_branchid');
        $branchInfo=Db::table('super_branch')->where(['b_id' => $branchId])->find();
        $this->assign('branch',$branchInfo);
        return $this->fetch();
    }




    public function topic(){
        if($_POST){
            $where = " 1 = 1";
            $keywords=trim($_POST['keywords']);
            $case_p_id=trim($_POST['case_p_id']);
            $bu_c_id=trim($_POST['bu_c_id']);
            $branch=trim($_POST['branch']);
            $case_decotime=trim($_POST['case_decotime']);
            $case_admin=intval(trim($_POST['case_admin']));

            if(isset($keywords) && !empty($keywords)){
                $where.=" and ( tp_title like '%".$keywords."%' or tp_bid like '%".$keywords."%' )";
            }
            if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
                $where.=" and tp_p_id = ".$case_p_id;
            }
            if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
                $where.=" and tp_c_id = ".$bu_c_id;
            }
            if(isset($branch) && !empty($branch) && $branch){
                $where.=" and tp_b_id = ".$branch;
            }
            if(isset($case_isable) && !empty($case_isable)){
                $where.=" and tp_isable = ".$case_isable;
            }
            if(isset($case_admin) && !empty($case_admin)){
                $where.=" and tp_admin = ".$case_admin;
            }
            if(isset($case_decotime) && !empty($case_decotime)){
                $sdate=strtotime(substr($case_decotime,'0','10')." 00:00:00");
                $edate=strtotime(substr($case_decotime,'-10')." 23:59:59");
                $where.=" and ( tp_createtime >= ".$sdate." and tp_createtime <= ".$edate." ) ";
            }
            //已展示
            $data['display']=Db::table('super_topic')
                ->join('super_province','super_province.p_id = super_topic.tp_p_id')
                ->join('super_city','super_city.c_id = super_topic.tp_c_id')
                ->join('super_branch','super_branch.b_id = super_topic.tp_b_id')
                ->join('super_admin','super_admin.ad_id = super_topic.tp_admin')
                ->where($where)
                ->where(['tp_isable' => 1])
                ->count();
            //未展示
            $data['none']=Db::table('super_topic')
                ->join('super_province','super_province.p_id = super_topic.tp_p_id')
                ->join('super_city','super_city.c_id = super_topic.tp_c_id')
                ->join('super_branch','super_branch.b_id = super_topic.tp_b_id')
                ->join('super_admin','super_admin.ad_id = super_topic.tp_admin')
                ->where($where)
                ->where(['tp_isable' => 2])
                ->count();
            $data['all']=intval($data['display'])+intval($data['none']);
            return $data;
        }
        $provInfo=Db::table('super_province')->select();
        $this->assign('prov',$provInfo);
        //操作人管理员
        $admin = Db::table('super_admin')->select();
        $this->assign('admin',$admin);
        //已展示
        $display=Db::table('super_topic')->where(['tp_isable'=>1])->count();
        $this->assign('display',$display);
        //未展示
        $none=Db::table('super_topic')->where(['tp_isable'=>2])->count();
        $this->assign('none',$none);
        $this->assign('all',intval($display)+intval($none));
        return $this->fetch();
    }





    //更改是否显示的状态
    public function status(){
        $ba_id = $_GET['tp_id'];
        $change = $_GET['change'];
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '显示';
                $data['tp_isable'] = '1';
            }else{
                $msg = '隐藏';
                $data['tp_isable'] = '2';
            }
            $changeStatus = Db::table('super_topic')->where(['tp_id' => $ba_id])->update($data);
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

    public function add(){
        if($_POST){
            $stime=strtotime(date('Y-m-d 00:00:00'));
            $etime=strtotime(date('Y-m-d 23:59:59'));
            //获取当日预约的数量
            $buNum=Db::table('super_topic')->where('tp_createtime','between',[$stime,$etime])->count();
            //生成用户编号；
            $data['tp_bid'] = date('Ymd').sprintf("%04d", $buNum+1);
            $data['tp_title']=$_POST['tp_title'];
            $data['tp_p_id']=$_POST['tp_p_id'];
            $data['tp_c_id']=$_POST['tp_c_id'];
            $data['tp_b_id']=$_POST['tp_b_id'];
            $data['tp_content']=$_POST['tp_content'];
            $data['tp_createtime']=time();
            $data['tp_seo_title']=$_POST['tp_seo_title'];
            $data['tp_seo_keywords']=$_POST['tp_seo_keywords'];
            $data['tp_seo_desc']=$_POST['tp_seo_desc'];
            $data['tp_isable']=$_POST['tp_isable'];
            $data['tp_admin']=session('adminId');
            $add=Db::table('super_topic')->insert($data);
            if($add){
                $this->success('发布专题成功！','topic');
            }else{
                $this->error('发布专题失败！','topic');
            }
        }else{
            $provInfo=Db::table('super_province')->select();
            $this->assign('prov',$provInfo);
            return $this->fetch();
        }
    }

    public function edit(){
        $tp_id=intval($_GET['tp_id']);
        if($_POST){
            $data['tp_title']=$_POST['tp_title'];
            $data['tp_p_id']=$_POST['tp_p_id'];
            $data['tp_c_id']=$_POST['tp_c_id'];
            $data['tp_b_id']=$_POST['tp_b_id'];
            $data['tp_content']=$_POST['tp_content'];
            $data['tp_createtime']=time();
            $data['tp_seo_title']=$_POST['tp_seo_title'];
            $data['tp_seo_keywords']=$_POST['tp_seo_keywords'];
            $data['tp_seo_desc']=$_POST['tp_seo_desc'];
            $data['tp_isable']=$_POST['tp_isable'];
            $data['tp_admin']=session('adminId');
            $edit=Db::table('super_topic')->where(['tp_id'=>$tp_id])->update($data);
            if($edit){
                $this->success('修改专题成功','topic');
            }else{
                $this->error('修改专题失败','topic');
            }
        }else{
            $topicInfo=Db::table('super_topic')->where(['tp_id'=>$tp_id])->find();
            $provInfo=Db::table('super_province')->select();
            $provid=$topicInfo['tp_p_id'];
            $cusCity=Db::table('super_city')->where(['p_id' => $provid])->select();
            $c_id=$topicInfo['tp_c_id'];
            $branch=Db::table('super_branch')->where(['b_city' =>$c_id ])->field('b_id,b_name')->select();
            $this->assign('branchs',$branch);
            $this->assign('city',$cusCity);
            $this->assign('prov',$provInfo);
            $this->assign('topic',$topicInfo);
            return $this->fetch();
        }
    }

    public function del(){
        $tp_id=intval($_GET['tp_id']);
        $delArt=Db::table('super_topic')->where(['tp_id'=>$tp_id])->delete();
        if($delArt){
            $this->success('删除专题成功','topic');
        }else{
            $this->error('删除专题失败','topic');
        }
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
}