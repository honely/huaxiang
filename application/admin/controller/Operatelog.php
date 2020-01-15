<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/11/29
 * Time: 11:23
 */
namespace app\admin\controller;
use app\marketm\controller\Common;
use think\Controller;
use think\Db;
use think\Request;

class Operatelog extends Controller{
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
        return $this->fetch();
    }


    public function logdata(){
        $where =' 1 = 1';
        $keywords = trim($this->request->param('keywords'));
        $case_decotime=trim($this->request->param('case_decotime'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( h_name like '%".$keywords."%' or h_b_id like '%".$keywords."%' )";
        }
        if(isset($case_decotime) && !empty($case_decotime)){
            $sdate=strtotime(substr($case_decotime,'0','10')." 00:00:00");
            $edate=strtotime(substr($case_decotime,'-10')." 23:59:59");
            $where.=" and ( h_addtime >= ".$sdate." and h_addtime <= ".$edate." ) ";
        }
        $count=Db::table('super_operation_log')
            ->where(['ol_is_delete' => 1])
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $design=Db::table('super_operation_log')
            ->where(['ol_is_delete' => 1])
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('ol_add_time desc')
            ->select();
        $commonModel = new Common();
        if($design){
            foreach($design as $key => $val){
                $design[$key]['ol_add_time'] = date('Y-m-d H:i:s',$val['ol_add_time']);
//                网络类型-手机型号-登录IP
                $design[$key]['ol_user_device'] = $val['ol_net_states'].'-'.$val['ol_user_device'].'-'.$val['ol_ip'];
                $design[$key]['ol_admin'] = $commonModel->getUserJob($val['ol_admin']).'-'.$commonModel->getUserName($val['ol_admin']);
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        return json($res);
    }



    public function del(){
        $ol_id = $_GET['ol_id'];
        $del = Db::table('super_operation_log')
            ->where(['ol_id' => $ol_id])
            ->update(['ol_is_delete' => 2]);
        if($del){
            $this->success('操作记录都想删除，胆子真大，只有你看不见了，后台管理员可以查到你的删除记录哦!');
        }else{
            $this->error('删除失败!');
        }
    }

}