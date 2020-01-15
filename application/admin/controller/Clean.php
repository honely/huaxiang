<?php
namespace app\admin\controller;
use app\admin\model\Commons;
use think\Controller;
use think\Db;
use think\Request;

class Clean extends Controller
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


    public function index(){
        $keywords = trim($this->request->param('keywords'));
        $this->assign('keywords',$keywords);
        return $this->fetch();
    }


    public function indexData(){
        $adminId = session('ad_bid');
        $roleId = intval(session('ad_role'));
        $keywords = trim($this->request->param('keywords'));
        $live_time=$this->request->param('live_time');
        if($roleId == 1 || $roleId == 35 || $roleId == 33){
            $where=" 1 = 1";
        }else{
            $where=" 1 = 1 and cc_admin = '".$adminId."'";
        }
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( cc_order_id like '%".$keywords."%' )";
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=substr($live_time,'0','10');
            $edate=substr($live_time,'-10');
            $where.=" and ( cc_pay_time >= '".$sdate."' and cc_pay_time <= '".$edate."' ) ";
        }
        $count=Db::table('crm_clean')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('crm_clean')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order(['cc_addtime' => 'desc'])
            ->select();
        $common = new Commons();
        if($cusInfo){
            foreach ($cusInfo as $k => $v){
                $cusInfo[$k]['cc_price'] = $v['cc_pay_type'] == 1 ? $v['cc_price'].'（人民币）' : $v['cc_price'].'（澳币）' ;
                $cusInfo[$k]['cc_pay_type'] = $common->getPayType($v['cc_pay_type']);
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }



    public function add(){
        $b_id = session('ad_bid');
        if($_POST){
            $data['cc_order_id'] = $_POST['cc_order_id'];
            $data['cc_user_name'] = $_POST['cc_user_name'];
            $data['cc_pay_id'] = $_POST['cc_pay_id'];
            $data['cc_refund'] = $_POST['cc_refund'];
            $data['cc_check'] = $_POST['cc_check'];
            $data['cc_price'] = $_POST['cc_price'];
            $data['cc_pay_time'] = $_POST['cc_pay_time'];
            $data['cc_pay_type'] = $_POST['cc_pay_type'];
            $data['cc_rent_term'] = $_POST['cc_rent_term'];
            $data['cc_room_type'] = $_POST['cc_room_type'];
            $data['cc_house_type'] = $_POST['cc_house_type'];
            $data['cc_receipt'] = $_POST['cc_receipt'];
            $data['cc_remarks'] = $_POST['cc_remarks'];
            $data['cc_addtime'] = date('Y-m-d H:i:s');
            $data['cc_admin'] = $b_id;
            $insert = Db::table('crm_clean')->insertGetId($data);
            if(isset($_POST['cl_date'])){
                $date = $_POST['cl_date'];
                foreach($date as $key => $val){
                    $sub['cl_cid'] = $insert;
                    $sub['cl_date'] = $val;
                    $sub['cl_admin'] = $b_id;
                    Db::table('crm_clean_log')->insert($sub);
                }
            }
            if($insert){
                $this->success('添加成功！','index');
            }else{
                $this->error('添加失败!','index');
            }
        }else{
            return $this->fetch();
        }

    }


    public function edit(){
        $b_id = session('ad_bid');
        $cc_id = intval(trim($this->request->param('cc_id')));
        if($_POST){
            $data['cc_order_id'] = $_POST['cc_order_id'];
            $data['cc_user_name'] = $_POST['cc_user_name'];
            $data['cc_pay_id'] = $_POST['cc_pay_id'];
            $data['cc_refund'] = $_POST['cc_refund'];
            $data['cc_price'] = $_POST['cc_price'];
            $data['cc_check'] = $_POST['cc_check'];
            $data['cc_pay_time'] = $_POST['cc_pay_time'];
            $data['cc_pay_type'] = $_POST['cc_pay_type'];
            $data['cc_rent_term'] = $_POST['cc_rent_term'];
            $data['cc_room_type'] = $_POST['cc_room_type'];
            $data['cc_house_type'] = $_POST['cc_house_type'];
            $data['cc_receipt'] = $_POST['cc_receipt'];
            $data['cc_remarks'] = $_POST['cc_remarks'];
            $data['cc_addtime'] = date('Y-m-d H:i:s');
            $data['cc_admin'] = $b_id;
            $insert = Db::table('crm_clean')->where(['cc_id' => $cc_id])->update($data);
            if($insert){
                $this->success('修改成功！','index');
            }else{
                $this->error('修改失败!','index');
            }
        }else{
            $clean = Db::table('crm_clean')->where(['cc_id' => $cc_id])->find();
            $clean['logs'] = Db::table('crm_clean_log')->where(['cl_cid' => $cc_id])->select();

            $this->assign('clean',$clean);
            return $this->fetch();
        }
    }


    public function details(){
        $cc_id = intval(trim($this->request->param('cc_id')));
        $clean = Db::table('crm_clean')->where(['cc_id' => $cc_id])->find();
        $clean['logs'] = Db::table('crm_clean_log')->where(['cl_cid' => $cc_id])->select();

        $this->assign('clean',$clean);
        return $this->fetch();
    }


    /***
     *Names:上传多图方法
     * @return mixed
     *Created by Dang Mengmeng at 2019/10/31 14:46
     */
    public function upload()
    {
        $path_date=date("Ym",time());
        if($this->request->isPost()){
            $res['code']=1;
            $res['msg'] = '上传成功！';
            $file = $this->request->file('file');
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/light/'.$path_date.'/');
            if($info){
                $res['name'] = $info->getFilename();
                $res['filepath'] = 'uploads/light/'.$path_date.'/'.$info->getSaveName();
            }else{
                $res['code'] = 0;
                $res['msg'] = '上传失败！'.$file->getError();
            }
            return $res;
        }
    }


    public function cleanStatus(){
        $cl_id = $_POST['cl_id'];
        $change = $_POST['change'];
        if($cl_id && isset($change)){
            if($change){
                $msg = '检查';
                $data['cl_status'] = '1';
            }else{
                $msg = '检查';
                $data['cl_status'] = '2';
            }
            $changeStatus = Db::table('crm_clean_log')
                ->where(['cl_id' => $cl_id])
                ->update($data);
            if($changeStatus){
                $res['code'] = 1;
                $res['msg'] = $msg.'通过！';
            }else{
                $res['code'] = 0;
                $res['msg'] = $msg.'不通过！';
            }
        }else{
            $res['code'] = 0;
            $res['msg'] = '这是个意外！';
        }
        return $res;
    }
    public function check(){
        $cc_id = intval(trim($this->request->param('cc_id')));
        $b_id = session('ad_bid');
        $change = intval(trim($this->request->param('change')));
        if($cc_id && isset($change)){
            if($change == 1){
                $msg = '修改';
                $data['cc_check'] = '1';
                $data['cc_admin'] = $b_id;
            }else{
                $msg = '修改';
                $data['cc_admin'] = $b_id;
                $data['cc_check'] = '2';
            }
            $changeStatus = Db::table('crm_clean')
                ->where(['cc_id' => $cc_id])
                ->update($data);
            if($changeStatus){
                $res['code'] = 1;
                $res['msg'] = $msg.'成功！';
            }else{
                $res['code'] = 0;
                $res['msg'] = $msg.'不通过！';
            }
        }else{
            $res['code'] = 0;
            $res['msg'] = '这是个意外！';
        }
        return $res;
    }


    public function upimgs(){
        $cl_id = intval(trim($this->request->param('cl_id')));
        $cc_id = intval(trim($this->request->param('cc_id','0')));
        $cleanLogs = Db::table('crm_clean_log')
            ->where(['cl_id' => $cl_id])
            ->find();
        $this->assign('cl_id',$cl_id);
        $this->assign('cc_id',$cc_id);
        $this->assign('log',$cleanLogs);
        return $this->fetch();
    }
    public function detl(){
        $cl_id = intval(trim($this->request->param('cl_id')));
        $cc_id = intval(trim($this->request->param('cc_id','0')));
        $cleanLogs = Db::table('crm_clean_log')
            ->where(['cl_id' => $cl_id])
            ->find();
        $this->assign('cl_id',$cl_id);
        $this->assign('cc_id',$cc_id);
        $this->assign('log',$cleanLogs);
        return $this->fetch();
    }

    public function editlogs(){
        $cl_id = intval(trim($this->request->param('cl_id','0','intval')));
        $b_id = session('ad_bid');

        $data['cl_date'] = $_POST['cl_date'];
        $data['cl_cid'] = $_POST['cl_cid'];
        $data['cl_status'] = $_POST['cl_status'];
        $data['cl_imgs'] = $_POST['cl_imgs'];
        $data['cl_admin'] = $b_id;
        $data['cl_add_time'] = time();
        if($cl_id > 0){
            $upload = Db::table('crm_clean_log')
                ->where(['cl_id' => $cl_id])->update($data);
            if($upload){
                $this->success('修改成功！','index');
            }else{
                $this->error('修改失败!','index');
            }
        }else{
            $insert = Db::table('crm_clean_log')->insert($data);
            if($insert){
                $this->success('添加成功！','index');
            }else{
                $this->error('添加失败!','index');
            }
        }


    }



    public function del(){
        $cc_id = intval(trim($this->request->param('cc_id')));
        $del = Db::table('crm_clean')
            ->where(['cc_id' => $cc_id])->delete();
        if($del){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败!','index');
        }
    }



    public function delog(){
        $cl_id = intval(trim($this->request->param('cl_id')));
        $del = Db::table('crm_clean_log')
            ->where(['cl_id' => $cl_id])->delete();
        if($del){
            $this->success('删除成功！');
        }else{
            $this->error('删除失败!');
        }
    }



    public function export(){
        return $this->fetch();
    }

    public function expData(){
        $adminId = session('ad_bid');
        $roleId = intval(session('ad_role'));
        $keywords = trim($this->request->param('keywords'));
        $live_time=$this->request->param('live_time');
        $status=$this->request->param('status');
        if($roleId == 1 || $roleId == 35 || $roleId == 33){
            $where=" 1 = 1";
        }else{
            $where=" 1 = 1 and cl_admin = '".$adminId."'";
        }
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( cc_order_id like '%".$keywords."%' )";
        }
        if(isset($status) && !empty($status)){
            $where.=" and cl_status = '".$status."'";
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=substr($live_time,'0','10');
            $edate=substr($live_time,'-10');
            $where.=" and ( cl_date >= '".$sdate."' and cl_date <= '".$edate."' ) ";
        }
        $count=Db::table('crm_clean_log')
            ->join('crm_clean','crm_clean_log.cl_cid  = crm_clean.cc_id')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('crm_clean_log')
            ->join('crm_clean','crm_clean_log.cl_cid  = crm_clean.cc_id')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order(['cl_date' => 'asc'])
            ->select();
        $common = new Commons();
        if($cusInfo){
            foreach ($cusInfo as $k => $v){
                $cusInfo[$k]['orderColor']= $common->deadLineShowColor($v['cl_date']);
                $cusInfo[$k]['cc_price'] = $v['cc_pay_type'] == 1 ? $v['cc_price'].'（人民币）' : $v['cc_price'].'（澳币）' ;
                $cusInfo[$k]['cc_pay_type'] = $common->getPayType($v['cc_pay_type']);
                $cusInfo[$k]['cl_status'] = $common->getCleanStatus($v['cl_status']);
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }
}