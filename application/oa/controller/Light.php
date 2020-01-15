<?php
namespace app\oa\controller;
use app\admin\model\Commons;
use think\Controller;
use think\Cookie;
use think\Db;
use think\Request;

class Light extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $adminName = Cookie::get('ad_id');
        if(empty($adminName)){
            $str = explode('=',$_SERVER['QUERY_STRING']);
            $crm_id =  array_pop($str);
            Cookie::set('cl_id',$crm_id,6000);
            $this->redirect('login/login');
        }
    }


    public function index(){
        $cl_idc = Cookie::get('cl_id');
        $adminName = Cookie::get('ad_id');
        $cl_id = intval(trim($this->request->param('cl_id')));
        $cl_id = $cl_id ? $cl_id : $cl_idc;
        if(!$cl_id){
            $this->redirect('lists');
        }
        $orderInfo = Db::table('crm_light')->where(['cl_id' =>$cl_id])->find();
        $comm = new Commons();
        $orderInfo['orderStatus'] = $comm->getClOrderStatus($orderInfo['cl_order_status']);
        $this->assign('order',$orderInfo);
        $this->assign('ad_name',$adminName);
        return $this->fetch();
    }


    public function accept(){
        $cl_id = intval(trim($this->request->param('cl_id')));
        $userId = Cookie::get('ad_id');
        $ada['cl_cl_admin'] = $userId;
        $ada['cl_cl_acc_time'] = date('Y-m-d H:i:s');
        $ada['cl_order_status'] = 2;
        //判断该订单是否已经被接到
        $isAccept = Db::table('crm_light')
            ->where(['cl_id' => $cl_id])
            ->field('cl_cl_admin')
            ->find();
        if($isAccept['cl_cl_admin']){
            $this->error('您来晚啦，订单已经被别人抢啦！');
        }
        $accept = Db::table('crm_light')->where(['cl_id' => $cl_id])->update($ada);
        $data['cll_order_id'] = $cl_id;
        $data['cll_cl_admin'] = $userId;
        $data['cll_status'] = 1;
        $data['cll_add_time'] = date('Y-m-d H:i:s');
        $insert = Db::table('crm_light_log')->insert($data);
        if($accept && $insert){
            $this->success('接单成功');
        }else{
            $this->error('接单失败');
        }
    }



    public function lists(){
        $userId = Cookie::get('ad_id');
        $orderLog = Db::table('crm_light')
            ->where(['cl_cl_admin' => $userId])
            ->select();
        if($orderLog){
            $comm = new Commons();
            foreach ($orderLog as $k => $v){
                $orderLog[$k]['orderStatus'] = $comm->getClOrderStatus($v['cl_order_status']);
            }
        }
        $this->assign('log',$orderLog);
        return $this->fetch();
    }


    public function detail(){
        $cl_id = intval(trim($this->request->param('cl_id')));
        $orderLog = Db::table('crm_light')
            ->where(['cl_id' => $cl_id])
            ->find();
        $comm = new Commons();
        $orderLog['orderStatus'] = $comm->getClOrderStatus($orderLog['cl_order_status']);
        $this->assign('log',$orderLog);
        return $this->fetch();
    }
}