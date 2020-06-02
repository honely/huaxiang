<?php


namespace app\xcx\controller;


use app\xcx\model\Loops;
use app\xcx\model\Matem;
use app\xcx\model\Rolem;
use think\Controller;
use think\Db;
use think\Request;

class Mate extends Controller
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
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $onlineable = in_array('245',$power_list,true);
        $delable = in_array('246',$power_list,true);
        $this->assign('onlineable',$onlineable);
        $this->assign('delable',$delable);
        $cityinfo = Db::table('tk_cate')->where(['pid' =>0])->select();
        $this->assign('cityinfo',$cityinfo);
        return $this->fetch();
    }

    public function indexData(){
        $where =' 1 = 1';
        $keywords = trim($this->request->param('keywords'));
        $status = trim($this->request->param('status'));
        $school = trim($this->request->param('school'));
        $city = trim($this->request->param('city'));
        $orderc = trim($this->request->param('orderc'));
        $orderv = trim($this->request->param('orderv'));
        $time = trim($this->request->param('time'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( title like '%".$keywords."%' or dsn like '%".$keywords."%' )";
        }
        if(isset($city) && !empty($city) && $city){
            $where.=" and city = '".$city."'";
        }if(isset($status) && !empty($status) && $status){
            $where.=" and status = ".$status;
        }if(isset($school) && !empty($school) && $school){
            $where.=" and school = ".$school;
        }
        if(isset($time) && !empty($time)){
            $sdate=substr($time,'0','10')." 00:00:00";
            $edate=substr($time,'-10')." 23:59:59";
            $where.=" and ( cdate >= '".$sdate."' and cdate <= '".$edate."' ) ";
        }
        $count=Db::table('tk_roommates')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $order = 'cdate desc';
        if(isset($orderv) && !empty($orderv) && $orderv){
            if($orderv == 1){
                $order ="view desc";
            }else{
                $order ="view asc";
            }
        }
        if(isset($orderc) && !empty($orderc) && $orderc){
            if($orderc == 1){
                $order ="collection desc";
            }else{
                $order ="collection asc";
            }
        }
        $design=Db::table('tk_roommates')
            ->limit(($page-1)*$limit,$limit)
            ->order($order)
            ->where($where)
            ->select();
        $loopd = new Loops();
        if($design){
            foreach($design as $k => $v){
                $design[$k]['statuss'] = $v['status'] == 1 ? '已发布' :'草稿箱';
                $design[$k]['cdate'] = date('m-d H:i',strtotime($v['cdate']));
                $design[$k]['user_id'] = $loopd->getUserNick($v['user_id']);
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        return json($res);
    }



    public function del(){
        $id = $this->request->param('id',22,'intval');
        $del = Db::table('tk_roommates')
            ->where(['id' => $id])
            ->delete();
        if($del){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！','index');
        }
    }


    //更改是否显示的状态
    public function status(){
        $ba_id = intval(trim($_GET['id']));
        $change = intval(trim($_GET['change']));
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '上线';
                $data['status'] = '1';
            }else{
                $msg = '下线';
                $data['status'] = '2';
            }
            $changeStatus = Db::table('tk_roommates')->where(['id' => $ba_id])->update($data);
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


    public function details(){
        $id = $this->request->param('id',22,'intval');
        $matem = new Matem();
        $details = $matem->getMate($id,0);
        $this->assign('house',$details);
        return $this->fetch();
    }


    public function getschool(){
        $city = $this->request->param('city');
        $pid = Db::table('tk_cate')
            ->where(['name' =>$city ])->find();
        $where = "pid = ".$pid['id']." and type = 2";
        $result = Db::table('tk_cate')
            ->where($where)
            ->field('id,name,pid')
            ->select();
        if($result){
            return  json(['code' => '1','data' => $result]);
        }else{
            return  json(['code' => '0','data' => ['']]);
        }
    }

}