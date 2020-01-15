<?php
/**
 *Author:DangMengmeng
 *Dates:2019/10/29
 *Times:17:57
 */
namespace app\oa\controller;
use app\admin\model\Commons;
use think\Controller;
use think\Cookie;
use think\Db;
use think\Request;


class Index extends Controller{

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $adminName = Cookie::get('ad_id');
        if(empty($adminName)){
            $str = explode('=',$_SERVER['QUERY_STRING']);
            $crm_id =  array_pop($str);
            Cookie::set('crm_id',$crm_id,6000);
            $this->redirect('login/logins');
        }
    }


    public function order(){
        $crm_id_cook =Cookie::get('crm_id');
        $adminName = Cookie::get('ad_id');
//        dump($adminName);
        $crm_id_req = intval(trim($this->request->param('crm_id')));
        $crm_id = $crm_id_req ? $crm_id_req : $crm_id_cook;
        if(!$crm_id){
            $this->redirect('lists');
        }
        $orderInfo = Db::table('crm_order')->where(['crm_id' =>$crm_id])->find();
        if($orderInfo){
            $adInfo=Db::table('crm_city')
                ->where(['crm_c_id' => $orderInfo['order_city']])
                ->find();
            if($adInfo){
                $city = $adInfo['crm_city'];
            }else{
                $city= '---';
            }
            $orderInfo['order_city'] = $city;
            $orderInfo['orderStatus'] = $this->getOrderStatus($orderInfo['order_status']);
            $comm = new Commons();
            $orderInfo['orderStep'] = $comm->getOrderStepById($orderInfo['order_step']);
            $isself = 1;
            if($orderInfo['order_status'] == 2){
                $ol = Db::table('crm_order_logs')
                    ->where(['ol_order_id' => $crm_id])
                    ->where('ol_status','neq','2')
                    ->find();
                $isself = $ol['ol_inspector'] == $adminName ? 1 :0;
            }else{
                $isself = 0;
            }
            $orderInfo['isSelf'] = $isself;
            //水电气网
            if($orderInfo['order_step'] == 3){
                $orderInfo['sub_info'] = Db::table('crm_sub_order')
                    ->where(['so_order_id' => $crm_id,'so_status' => 1])
                    ->field('so_id,so_order_id,so_sub_type')
                    ->select();
            }
        }
//        dump($orderInfo);
        $this->assign('order',$orderInfo);
        return $this->fetch();
    }

    public function accept(){
        $crm_id = intval(trim($this->request->param('crm_id')));
        $userId = Cookie::get('ad_id');
        $ada['ol_order_id'] = $crm_id;
        $ada['ol_inspector'] = $userId;
        $ada['ol_accept_time'] = time();
        $ada['ol_status'] = 1;
        //判断该订单是否已经被接到
        $isAccept = Db::table('crm_order')
            ->where(['crm_id' => $crm_id])
            ->field('order_status')
            ->find();
        $isLog = Db::table('crm_order_logs')
            ->where(['ol_order_id' => $crm_id])
            ->where('ol_status = 1 or ol_status = 3')
            ->find();
        if($isAccept['order_status'] >1 && $isLog){
            $this->error('您来晚啦，订单已经被别人抢啦！');
        }
        $add = Db::table('crm_order_logs')->insert($ada);
        $accept = Db::table('crm_order')->where(['crm_id' => $crm_id])->update(['order_status' => 2]);
        if($add && $accept){
            $this->success('接单成功');
        }else{
            $this->error('接单失败');
        }
    }

    public function lists(){
        $userId = Cookie::get('ad_id');
        $orderLog = Db::table('crm_order_logs')
            ->join('crm_order','crm_order.crm_id = crm_order_logs.ol_order_id','left')
            ->where(['ol_inspector' => $userId])
            ->order(['ol_status'=>'asc','order_show_time'=>'asc'])
            ->select();
        if($orderLog){
            foreach($orderLog as $k => $v){
                if(!empty($v['order_city'])){
                    $adInfo=Db::table('crm_city')
                        ->where(['crm_c_id' => $v['order_city']])
                        ->find();
                    $city = $adInfo['crm_city'];
                }else{
                    $city="---";
                }
                $orderLog[$k]['order_city']= $city;
                $orderLog[$k]['order_type']= $this->getOrderType($v['order_type']);
                $orderLog[$k]['order_pay_type']= $this->getPayType($v['order_pay_type']);
                $orderLog[$k]['ol_status']= $this->getOrderLogStatus($v['ol_status']);
                $comm = new Commons();
                $orderLog[$k]['orderStep'] = $comm->getOrderStepById($v['order_step']);
            }
        }
        $this->assign('log',$orderLog);
        return $this->fetch();
    }


    /***
     *Names:订单接单记录的状态方法
     * 1已接单；2已取消；3已完成',
     * @param $typeId
     * @return string
     *Created by Dang Mengmeng at 2019/11/12 10:25
     */
    public function getOrderLogStatus($typeId){
        switch ($typeId)
        {
            case 1:
                $type = '已接单';
                break;
            case 2:
                $type = '已取消';
                break;
            case 3:
                $type = '已完成';
                break;
        }
        return $type;
    }
    /***
     *Names:获取订单类型方法
     * @param $typeId
     * @return string
     *Created by Dang Mengmeng at 2019/10/29 10:14
     */
    public function getOrderType($typeId){
        switch ($typeId)
        {
            case 1:
                $type = '普通';
                break;
            case 2:
                $type = '串行';
                break;
            case 3:
                $type = '并行';
                break;
            default:
                $type = '未知';
        }
        return $type;
    }


    /***
     *Names:获取支付方法
     * 客户支付方式：1淘宝；2转账；3汇款
     * @param $typeId
     * @return string
     *Created by Dang Mengmeng at 2019/10/29 10:16
     */
    public function getPayType($typeId){
        switch ($typeId)
        {
            case 1:
                $type = '淘宝';
                break;
            case 2:
                $type = '转账';
                break;
            case 3:
                $type = '汇款';
                break;
            default:
                $type = '未选择';
        }
        return $type;
    }


    /***
     *Names:获取任务状态方法
     * 任务状态：1.未安排；2.已安排；3.已完成待结算4.未完成待结算；5已结算。
     * @param $status
     * @return string
     *Created by Dang Mengmeng at 2019/10/29 10:19
     */
    public function getOrderStatus($status){
        switch ($status)
        {
            case 1:
                $type = '未安排';
                break;
            case 2:
                $type = '已安排';
                break;
            case 3:
                $type = '已完成';
                break;
            case 4:
                $type = '未完成';
                break;
            case 5:
                $type = '已结算';
                break;
            default:
                $type = '意外';
        }
        return $type;
    }

    public function detail(){
        $ol_id = intval(trim($this->request->param('ol_id')));
        $orderLog = Db::table('crm_order_logs')
            ->join('crm_order','crm_order.crm_id = crm_order_logs.ol_order_id','left')
            ->where(['ol_id' => $ol_id])
            ->find();
        if($orderLog){
            if(!empty($orderLog['order_city'])){
                $adInfo=Db::table('crm_city')
                    ->where(['crm_c_id' => $orderLog['order_city']])
                    ->find();
                $city = $adInfo['crm_city'];
            }else{
                $city="---";
            }
            $orderLog['order_city']= $city;
//            $orderLog['order_show_time']= date('Y-m-d H:i',$orderLog['order_show_time']);
            $orderLog['order_type']= $this->getOrderType($orderLog['order_type']);
            $orderLog['order_pay_type']= $this->getPayType($orderLog['order_pay_type']);
            $orderLog['order_statuss']= $this->getOrderStatus($orderLog['order_status']);
            $orderLog['olStatus']= $this->getShowStatus($orderLog['ol_status']);
            $orderLog['ol_inspector']= $this->getAdminBid($orderLog['ol_inspector']);
            $orderLog['ol_image']= explode(',',$orderLog['ol_images']);
            $comm = new Commons();
            $orderLog['orderStep'] = $comm->getOrderStepById($orderLog['order_step']);
            if($orderLog['order_step'] == 3){
                $orderLog['sub_info'] = $comm->getSubOrder($orderLog['crm_id']);
                if($orderLog['sub_info'] && $orderLog['order_status'] == 3){
                    foreach ($orderLog['sub_info'] as $k => $v){
                        $orderLog['sub_info'][$k]['sub_comp'] = $comm->getEnergyCom($v['so_sub_cp_id']);
                    }
                }
            }
        }
        $this->assign('log',$orderLog);
        return $this->fetch();
    }



    public function getAdminBid($olInspector){
        $admin = Db::table('super_admin')
            ->where(['ad_id' => $olInspector])
            ->field('ad_bid')
            ->find();
        return $admin ? $admin['ad_bid'] : '';
    }


    public function getShowStatus($olStatus){
        switch ($olStatus)
        {
            case 1:
                $type = '已接单';
                break;
            case 2:
                $type = '已取消';
                break;
            case 3:
                $type = '已完成';
                break;
            default:
                $type = '意外';
        }
        return $type;
    }





}