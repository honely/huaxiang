<?php
namespace app\admin\controller;
use app\admin\model\Commons;
use think\Controller;
use think\Db;
use think\Request;


/***
 * Note : 闪电租房类
 * Class Light
 * @package app\admin\controller
 * Author: Created by Dang Mengmeng At 2019/12/10 10:11
 */
class Light extends Controller
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


    /***
     * 1.Name : 售前闪电租房订单列表渲染
     * 2.Date : 2019年12月10日10:02:06
     * 3.Author : dangmengmeng
     * @return mixed
     */
    public function index(){
        //订单状态
        $common = new Commons();
        $status = $common->liOrderStatus();
        //租房顾问：顾问角色加上售后主管角色
        $guwen = $common->getGuwen();
        $this->assign('guwen',$guwen);
        $this->assign('status',$status);
        return $this->fetch();
    }

    /***
     * 1.Name : 售前一站式订单列表渲染
     * 2.Date : 2019年12月10日10:02:06
     * 3.Author : dangmengmeng
     * @return mixed
     */
    public function onestep(){
        //订单状态
        $common = new Commons();
        $status = $common->liOrderStatus();
        //租房顾问：顾问角色加上售后主管角色
        $guwen = $common->getGuwen();
        $this->assign('guwen',$guwen);
        $this->assign('status',$status);
        return $this->fetch();
    }

    /***
     * 1.Name : 售前单次闪电订单列表渲染
     * 2.Date : 2019年12月10日10:02:06
     * 3.Author : dangmengmeng
     * @return mixed
     */
    public function onelight(){
        //订单状态
        $common = new Commons();
        $status = $common->liOrderStatus();
        //租房顾问：顾问角色加上售后主管角色
        $guwen = $common->getGuwen();
        $this->assign('guwen',$guwen);
        $this->assign('status',$status);
        return $this->fetch();
    }

    /***
     * 1.Name : 售前学生公寓订单列表渲染
     * 2.Date : 2019年12月10日10:02:06
     * 3.Author : dangmengmeng
     * @return mixed
     */
    public function student(){
        //订单状态
        $common = new Commons();
        $status = $common->liOrderStatus();
        //租房顾问：顾问角色加上售后主管角色
        $guwen = $common->getGuwen();
        $this->assign('guwen',$guwen);
        $this->assign('status',$status);
        return $this->fetch();
    }

    /***
     * 1.Name : 售前个人房源订单列表渲染
     * 2.Date : 2019年12月10日10:02:06
     * 3.Author : dangmengmeng
     * @return mixed
     */
    public function personal(){
        //订单状态
        $common = new Commons();
        $status = $common->liOrderStatus();
        //租房顾问：顾问角色加上售后主管角色
        $guwen = $common->getGuwen();
        $this->assign('guwen',$guwen);
        $this->assign('status',$status);
        return $this->fetch();
    }
    /***
     * 1.Name : 售前闪电租房订单列表数据
     * 2.Date : 2019年12月10日10:02:06
     * 3.Author : dangmengmeng
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function indexData(){
        $adminId = session('ad_bid');
        $roleId = intval(session('ad_role'));
        $keywords = trim($this->request->param('keywords'));
        $live_time=$this->request->param('live_time');
        $cl_order_type = intval(trim($this->request->param('cl_order_type')));
        $cl_cl_admin = intval(trim($this->request->param('cl_cl_admin')));
        $step = $this->request->param('step');
        if($roleId == 1 || $roleId == 35 || $roleId == 33){
            $where=" 1 = 1";
        }else{
            $where=" 1 = 1 and cl_admin_sale = '".$adminId."'";
        }
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( cl_order_id like '%".$keywords."%' )";
        }
        if(isset($cl_order_type) && !empty($cl_order_type) && $cl_order_type){
            $where.=" and cl_order_status = ".$cl_order_type;
        }
        if(isset($cl_cl_admin) && !empty($cl_cl_admin) && $cl_cl_admin){
            $where.=" and cl_cl_admin = ".$cl_cl_admin;
        }
        if(isset($step) && !empty($step)){
            $where.=" and cl_order_type = ".$step;
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=substr($live_time,'0','10');
            $edate=substr($live_time,'-10');
            $where.=" and ( cl_add_time >= '".$sdate."' and cl_add_time <= '".$edate."' ) ";
        }
        $count=Db::table('crm_light')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('crm_light')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order(['cl_add_time' => 'desc'])
            ->select();
        $common = new Commons();
        if($cusInfo){
            foreach ($cusInfo as $k => $v){
                $cusInfo[$k]['cl_price'] = $v['cl_pay_type'] == 1 ? $v['cl_price'].'（人民币）' : $v['cl_price'].'（澳币）' ;
                $cusInfo[$k]['cl_pay_type'] = $common->getPayType($v['cl_pay_type']);
                $cusInfo[$k]['cl_order_type'] = $common->lightOrderStep($v['cl_order_type']);
                $cusInfo[$k]['cl_orderStatus'] = $common->getClOrderStatus($v['cl_order_status']);
                $cusInfo[$k]['cl_cl_admin'] = $common->getInspectorNames($v['cl_cl_admin']);
                $cusInfo[$k]['cl_order_refund'] = $common->getOrderRefund($v['cl_order_refund']);
                $cusInfo[$k]['cl_user_ids'] = explode(',',$v['cl_user_ids']);
                //$cusInfo[$k]['cl_need_confirm'] = $v['cl_need_confirm'] == 1 ? '是' : '否';
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }


    /***
     * 1.Name : 闪电租房顾问取消订单
     * 2.Date : 2019年12月10日10:02:06
     * 3.Author : dangmengmeng
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function cancel(){
        $b_id = session('ad_bid');
        $cl_id = intval(trim($this->request->param('cl_id')));
        $orderStatus = Db::table('crm_light')
            ->where(['cl_id' => $cl_id])
            ->update(['cl_order_status' => 1,'cl_cl_admin' => '']);
        $orderLog = Db::table('crm_light_log')
            ->where(['cll_order_id' => $cl_id])
            ->update(
                [
                    'cll_status' => 2,
                    'cll_cancel_time' => date('Y-m-d H:i:s'),
                    'cll_cancel_admin' =>$b_id
                ]
            );
        if($orderStatus && $orderLog){
            $this->success('取消成功！','index');
        }else{
            $this->error('取消失败!','index');
        }
    }


    /***
     * 1.Name : 闪电租房订单详情页
     * 2.Date : 2019年12月10日10:02:06
     * 3.Author : dangmengmeng
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail(){
        $cl_id = intval(trim($this->request->param('cl_id')));
        $type = intval(trim($this->request->param('type','0','intval')));
        $light = Db::table('crm_light')
            ->where(['cl_id' => $cl_id])
            ->find();
        $common = new Commons();
        $light['cl_user_idss'] = explode(',',$light['cl_user_ids']);
        $light['cl_price'] = $light['cl_pay_type'] == 1 ? $light['cl_price'].'（人民币）' : $light['cl_price'].'（澳币）' ;
        $light['cl_pay_type'] = $common->getPayType($light['cl_pay_type']);
        $light['cl_orderStatus'] = $common->getClOrderStatus($light['cl_order_status']);
        $light['cl_user_idss'] = explode(',',$light['cl_user_ids']);
        $light['cl_pay_imgs'] = explode(',',$light['cl_pay_img']);
        $light['cl_sl_imgs'] = explode(',',$light['cl_sl_img']);
        $subOrder = Db::table('crm_order')
            ->where(['order_fu_id' => $cl_id])
            ->field('order_id,order_pay_type,order_status,order_step,crm_id')
            ->select();
        //清洁检查
        $clean = Db::table('crm_clean')
            ->where(['cc_order_fu_id' => $cl_id])
            ->field('cc_id,cc_order_id')
            ->select();
        if($subOrder){
            $comm = new Commons();
            foreach ($subOrder as $k => $v){
                $subOrder[$k]['order_pay_type']= $comm->getPayType($v['order_pay_type']);
                $subOrder[$k]['order_statuss']= $comm->getOrderStatus($v['order_status']);
                $subOrder[$k]['orderStep']= $comm->getOrderStepById($v['order_step']);
            }
        }
        $light['subOrder'] = $subOrder;
        if($light['cl_order_refund'] != 0){
            $refund = Db::table('crm_refund')->where(['cr_id' => $light['cl_order_refund']])->find();
            $this->assign('refund',$refund);
        }
        $light['cl_cl_admin'] = $common->getInspectors($light['cl_cl_admin']);
        $this->assign('clean',$clean);
        $this->assign('light',$light);
        $this->assign('type',$type);
        return $this->fetch();
    }


    /***
     * 1.Name : 闪电租房售前创建订单
     * 2.Date : 2019年12月10日10:02:06
     * 3.Author : dangmengmeng
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function add(){
        $step = intval(trim($this->request->param('step')));
        $b_id = session('ad_bid');
        if($_POST){
            $now = date('Y-m-d H:i:s');
            $data['cl_order_id'] = $_POST['cl_order_id'];
            $data['cl_start_time'] = $now;
            $data['cl_end_time'] = $_POST['cl_end_time'];
            $data['cl_agreement'] = $_POST['cl_agreement'];
            $data['cl_agree_name'] = $_POST['cl_agree_name'];
            $data['cl_price'] = $_POST['cl_price'];
            $data['cl_pay_time'] = $_POST['cl_pay_time'];
            $data['cl_pay_id'] = $_POST['cl_pay_id'];
            $data['cl_pay_type'] = $_POST['cl_pay_type'];
            $data['cl_refer_ids'] = $_POST['cl_refer_ids'];
            $data['cl_order_type'] = $step;
            //图片
            $img = isset($_POST['cl_pay_img'])?$_POST['cl_pay_img']:array();
            $h_img = '';
            for ($i=0;$i<sizeof($img);$i++){
                $h_img.=$img[$i].",";
            }
            $data['cl_pay_img']=trim($h_img,',');
            $userids = isset($_POST['cl_user_ids'])?$_POST['cl_user_ids']:array();
            $user_ids = '';
            for ($i=0;$i<sizeof($userids);$i++){
                //更新客户订单状态
                Db::table('crm_user')
                    ->where(['crm_user_bid' => $userids[$i]])
                    ->update([
                        'crm_order_time' => $now,
                        'crm_user_status' => 5
                    ]);
                $user_ids.=$userids[$i].",";
            }
            $data['cl_user_ids']=trim($user_ids,',');
            //$data['cl_need_confirm'] = $_POST['cl_need_confirm'];
            $data['cl_add_time'] = date('Y-m-d');
            $data['cl_remarks'] = $_POST['cl_remarks'];
            $data['cl_admin_sale'] = $b_id;
            $insert = Db::table('crm_light')->insertGetId($data);
            if($step == 4 || $step == 5 || $step == 6){
                $type = $step == 5 ? 1 :0;
                $insertSub = $this->autoCreateOrder($insert,$type);
            }
            $url = 'index';
            switch ($step)
            {
                case 4:
                    $url = 'index';
                    break;
                case 5:
                    $url = 'onestep';
                    break;
                case 6:
                    $url = 'onelight';
                    break;
                case 7:
                    $url = 'student';
                    break;
                case 8:
                    $url = 'personal';
                    break;
                default:
                    $url = '---';
            }
            if($insert){
                $this->success('添加成功！',$url);
            }else{
                $this->error('添加失败!',$url);
            }
        }else{
            $user = Db::table('crm_user')
                ->field('crm_user_id,crm_user_bid')
                ->select();
            $this->assign('user',$user);
            //自动生成订单号
            $common = new Commons();
            $adId = session('adminId');
            $orderBid = $common->createOrderBid($b_id,$step);
            $orderStep  = $common->lightOrderStep($step);
            $this->assign('orderStep',$orderStep);
            $this->assign('step',$step);
            $this->assign('orderBid',$orderBid);
            return $this->fetch();
        }

    }

    /***
     * Notes:
     *  自动创建子订单
     * 闪电租房  自动建立 水电气网单 清洁押金
     * 一站式   自动建立  水电气网单 清洁押金 领钥匙单。
     * @param $orderId$ string 订单id
     * @param $type int 1 一站式 ； 2  闪电租房
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Author: Created by Dang Mengmeng At 2019/12/18 18:58
     */
    public function autoCreateOrder($orderId,$type){
        $order = Db::table('crm_light')
            ->where(['cl_id' => $orderId])
            ->field('cl_order_id,cl_user_ids')
            ->find();
        $b_id = session('ad_bid');
        $now = date('Y-m-d H:i:s');
        $orderBid = $order['cl_order_id'];
        if($type == 1){
            //领钥匙
            $keys1['order_fu_id'] = $orderId;
            $keys1['order_service_id'] = $b_id;
            $keys1['order_id'] = $orderBid.'-D';
            $keys1['order_step'] = 2;
            $keys1['order_addtime'] = $now;
            Db::table('crm_order')->insert($keys1);
        }
        //水电气网
        $energy['order_fu_id'] = $orderId;
        $energy['order_service_id'] = $b_id;
        $energy['order_id'] = $orderBid.'-C';
        $energy['order_step'] = 3;
        $energy['order_addtime'] = $now;
        $addEnergy =  Db::table('crm_order')->insert($energy);
        //清洁检查
        $clean['cc_order_id'] = $orderBid.'-Q';
        $clean['cc_order_fu_id'] = $orderId;
        $clean['cc_admin'] = $b_id;
        $clean['cc_user_name'] = $order['cl_user_ids'];
        $clean['cc_addtime'] = $now;
        $addClean = Db::table('crm_clean')->insert($clean);
        if($addEnergy && $addClean){
            return true;
        }else{
            return false;
        }
    }


    public function liOrderType($type){
        return $type == 4 ? '闪电租房' : '一站式';
    }

    /***
     * 1.Name : 一站式售前创建订单
     * 2.Date : 2019年12月10日10:02:06
     * 3.Author : dangmengmeng
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function add1(){
        $b_id = session('ad_bid');
        if($_POST){
            $now = date('Y-m-d H:i:s');
            $data['cl_order_id'] = $_POST['cl_order_id'];
            $data['cl_start_time'] = $now;
            $data['cl_end_time'] = $_POST['cl_end_time'];
            $data['cl_agreement'] = $_POST['cl_agreement'];
            $data['cl_price'] = $_POST['cl_price'];
            $data['cl_pay_time'] = $_POST['cl_pay_time'];
            $data['cl_pay_id'] = $_POST['cl_pay_id'];
            $data['cl_order_type'] = 5;
            $data['cl_pay_type'] = $_POST['cl_pay_type'];
            $data['cl_refer_ids'] = $_POST['cl_refer_ids'];
            $data['cl_pay_img'] = $_POST['cl_pay_img'];
            $userids = isset($_POST['cl_user_ids'])?$_POST['cl_user_ids']:array();
            $user_ids = '';
            for ($i=0;$i<sizeof($userids);$i++){
                //更新客户订单状态
                Db::table('crm_user')
                    ->where(['crm_user_bid' => $userids[$i]])
                    ->update([
                        'crm_order_time' => $now,
                        'crm_user_status' => 5
                    ]);
                $user_ids.=$userids[$i].",";
            }
            $data['cl_user_ids']=trim($user_ids,',');
            //$data['cl_need_confirm'] = $_POST['cl_need_confirm'];
            $data['cl_add_time'] = date('Y-m-d');
            $data['cl_remarks'] = $_POST['cl_remarks'];
            $data['cl_admin_sale'] = $b_id;
            $insert = Db::table('crm_light')->insertGetId($data);
            $insertSub = $this->autoCreateOrder($insert,1);
            if($insert && $insertSub){
                $this->success('添加成功！','index');
            }else{
                $this->error('添加失败!','index');
            }
        }else{
            $user = Db::table('crm_user')
                ->field('crm_user_id,crm_user_bid')
                ->select();
            //自动生成订单号
            $common = new Commons();
            $adId = session('adminId');
            $orderBid = $common->createOrderBid($b_id,1);
            $this->assign('orderBid',$orderBid);
            $this->assign('user',$user);
            return $this->fetch();
        }

    }


    /***
     * Notes:
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Author: Created by Dang Mengmeng At 2019/12/18 17:50
     */
    public function userRefer(){
        $user_bid = trim($this->request->param('user_bid'));
        $userIsRefer = Db::table('crm_user')
            ->where(['crm_user_bid' => $user_bid])
            ->field('crm_refer')
            ->find();
        if(!empty($userIsRefer['crm_refer'])){
            $data['code'] = 1;
            $data['msg'] = 'ok';
            $data['data'] = $userIsRefer['crm_refer'];
        }else{
            $data['code'] = 0;
            $data['msg'] = 'sorry';
            $data['data'] = '';
        }
        return json($data);
    }


    /***
     * Notes:闪电租房【订单修改】
     * User: Dang Mengmeng
     * Date: 2019/12/10
     * Time: 10:09
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function edit(){
        $b_id = session('ad_bid');
        $cl_id = intval(trim($this->request->param('cl_id')));
        $light = Db::table('crm_light')->where(['cl_id' => $cl_id])->find();
        $step = $light['cl_order_type'];
        if($_POST){
            $data['cl_order_id'] = $_POST['cl_order_id'];
            $data['cl_end_time'] = $_POST['cl_end_time'];
            $data['cl_agreement'] = $_POST['cl_agreement'];
            $data['cl_agree_name'] = $_POST['cl_agree_name'];
            $data['cl_price'] = $_POST['cl_price'];
            $data['cl_pay_time'] = $_POST['cl_pay_time'];
            $data['cl_refer_ids'] = $_POST['cl_refer_ids'];
            $data['cl_pay_id'] = $_POST['cl_pay_id'];
            $data['cl_pay_type'] = $_POST['cl_pay_type'];
            $img = isset($_POST['cl_pay_img'])?$_POST['cl_pay_img']:array();
            $h_img = '';
            for ($i=0;$i<sizeof($img);$i++){
                $h_img.=$img[$i].",";
            }
            $data['cl_pay_img']=trim($h_img,',');
            $userids = isset($_POST['cl_user_ids'])?$_POST['cl_user_ids']:array();
            $user_ids = '';
            for ($i=0;$i<sizeof($userids);$i++){
                //更新客户订单状态
                Db::table('crm_user')
                    ->where(['crm_user_bid' => $userids[$i]])
                    ->update([
                        'crm_order_time' => date('Y-m-d H:i:s'),
                        'crm_user_status' => 5
                    ]);
                $user_ids.=$userids[$i].",";
            }
            $data['cl_user_ids']=trim($user_ids,',');
            $data['cl_remarks'] = $_POST['cl_remarks'];
            $data['cl_admin_sale'] = $b_id;
            $insert = Db::table('crm_light')->where(['cl_id' => $cl_id])->update($data);
            $url = $this->getReturnUrl($step);
            if($insert){
                $this->success('修改成功！',$url);
            }else{
                $this->error('修改失败!',$url);
            }
        }else{
            $light['cl_user_idss'] = explode(',',$light['cl_user_ids']);
            $light['cl_pay_imgs'] = explode(',',$light['cl_pay_img']);
            $user = Db::table('crm_user')
//                ->where(['crm_user_status' => 5])
                ->field('crm_user_id,crm_user_bid')
                ->select();
            $this->assign('user',$user);
            $this->assign('light',$light);
            return $this->fetch();
        }
    }


    public function getReturnUrl($step){
//        ;4闪电租房；5一站式；6单次闪电；7学生公寓；8个人房源
        switch ($step){
            case 4:
                $url = 'index';
                break;
            case 5:
                $url = 'onestep';
                break;
            case 6:
                $url = 'onelight';
                break;
            case 7:
                $url = 'student';
                break;
            case 8:
                $url = 'personal';
                break;
        }
        return $url;
    }

    /***
     *Names:上传多图方法
     * @return mixed
     *Created by Dang Mengmeng at 2019/10/31 14:46
     */
    public function uploadfile()
    {
        header("Content-type: text/html; charset=utf-8");
        $path_date=date("Ym",time());
        if($this->request->isPost()){
            $res['code']=1;
            $res['msg'] = '上传成功！';
            $file = $this->request->file('file');
            $names = $file->getInfo();
            $name = iconv("UTF-8","GBK",$names["name"]);
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/light/'.$path_date.'/');
            $fileName = $info->getInfo();
            if($info){
                $res['name'] = $fileName['name'];
                $res['filepath'] = 'uploads/light/'.$path_date.'/'.$info->getSaveName();
            }else{
                $res['code'] = 0;
                $res['msg'] = '上传失败！'.$file->getError();
            }
            return $res;
        }
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



    /***
     * Notes:闪电租房订单删除
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * Author: Created by Dang Mengmeng At 2019/12/10 10:11
     */
    public function del(){
        $cl_id = intval(trim($this->request->param('cl_id')));
        $del = Db::table('crm_light')
            ->where(['cl_id' => $cl_id])->delete();
        //删除他的子订单们
        $suborder = Db::table('crm_order')
            ->where(['order_fu_id' =>$cl_id])
            ->select();
        foreach ($suborder as $k => $v){
            Db::table('crm_order_logs')
                ->where(['ol_order_id' => $v['crm_id']])
                ->delete();
            if($v['order_step'] == 3){
                Db::table('crm_sub_order')
                    ->where(['so_order_id' => $v['crm_id']])
                    ->delete();
            }
        }
        $delSub = Db::table('crm_order')
            ->where(['order_fu_id' =>$cl_id])
            ->delete();

        //删除清洁检查
        $Clean = Db::table('crm_clean')
            ->where(['cc_order_fu_id' => $cl_id])
            ->find();
        //如果清洁检查有检查记录的，删除检查记录
        Db::table('crm_clean_log')
            ->where(['cl_cid' => $Clean['cc_id']])
            ->delete();
        $delClean = Db::table('crm_clean')
            ->where(['cc_order_fu_id' => $cl_id])
            ->delete();
        //删除租房单接单记录
        Db::table('crm_light_log')->where(['cll_order_id' => $cl_id])->delete();
        if($del && $delSub && $delClean){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败!','index');
        }
    }


    //如果子订单有已接单的删除接单记录
    public function delSub($crm_id){

    }


    /***
     * 顾问：我接的单  订单列表
     */
    public function guwen(){
        $adminId = session('adminId');
        return $this->fetch();
    }


    /***
     * Notes:闪电租房顾问接单数据
     * Author: Created by Dang Mengmeng At 2019/12/10 10:12
     */
    public function guwenData(){
        $adminId = session('adminId');
        $roleId = intval(session('ad_role'));
        $keywords = trim($this->request->param('keywords'));
        $step = trim($this->request->param('step'));
        $live_time=$this->request->param('live_time');
//        if($roleId == 1 || $roleId == 35 || $roleId == 33){
//            $where=" 1 = 1";
//        }else{
//            $where=" 1 = 1 and cl_cl_admin = '".$adminId."'";
//        }
        $where=" 1 = 1 and cl_cl_admin = '".$adminId."'";
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( cl_order_id like '%".$keywords."%' )";
        }
        if(isset($step) && !empty($step)){
            $where.=" and cl_order_type = ".$step;
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=substr($live_time,'0','10');
            $edate=substr($live_time,'-10');
            $where.=" and ( cl_end_time >= '".$sdate."' and cl_end_time <= '".$edate."' ) ";
        }
        $count=Db::table('crm_light')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('crm_light')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order(['cl_order_status' => 'asc','cl_end_time' => 'asc'])
            ->select();
        $common = new Commons();
        if($cusInfo){
            foreach ($cusInfo as $k => $v){
                $cusInfo[$k]['cl_order_type'] = $common->lightOrderStep($v['cl_order_type']);
                $cusInfo[$k]['cl_orderStatus'] = $common->getClOrderStatus($v['cl_order_status']);
                $cusInfo[$k]['cl_user_ids'] = explode(',',$v['cl_user_ids']);
                $cusInfo[$k]['cl_cl_agree_sign'] = $v['cl_cl_agree_sign'] == 1 ? '是' : '否';
                $cusInfo[$k]['cl_to_sale_time'] = $v['cl_to_sale_time'] == '0000-00-00 00:00:00' ? '---' : $v['cl_to_sale_time'];
                $cusInfo[$k]['cl_cl_delete'] = $v['cl_cl_delete'] == 1 ? '是' : '否';
                $cusInfo[$k]['orderColor']= $common->deadLineShowColor($v['cl_end_time']);
                $cusInfo[$k]['cl_cl_admin'] = $common->getInspectors($v['cl_cl_admin']);
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }


    /***
     * Notes:闪电租房顾问的编辑修改
     * Author: Created by Dang Mengmeng At 2019/12/10 10:57
     */
    public function edit1(){
        $cl_id = trim($this->request->param('cl_id','0','intval'));
        $type = trim($this->request->param('type','0','intval'));
        if($_POST){
            $data['cl_cl_agree_sign'] = $_POST['cl_cl_agree_sign'];
            $data['cl_cl_delete'] = $_POST['cl_cl_delete'];
            $data['cl_cl_house_address'] = $_POST['cl_cl_house_address'];
            $data['cl_cl_inter'] = $_POST['cl_cl_inter'];
            $data['cl_cl_remarks'] = $_POST['cl_cl_remarks'];
            //订单状态更改为待闭环
            $data['cl_order_status'] = $type == 1 ? 2 : 3;
            $data['cl_to_sale_time'] = $type == 1 ? '' : date('Y-m-d H:i:s');
            $insert = Db::table('crm_light')->where(['cl_id' => $cl_id])->update($data);
            if($insert){
                $this->success('修改成功！','guwen');
            }else{
                $this->error('修改失败!','guwen');
            }
        }else{
            $light = Db::table('crm_light')
                ->where(['cl_id' => $cl_id])
                ->find();
            $common = new Commons();
            $light['cl_price'] = $light['cl_pay_type'] == 1 ? $light['cl_price'].'（人民币）' : $light['cl_price'].'（澳币）' ;
            $light['cl_user_idss'] = explode(',',$light['cl_user_ids']);
            $light['cl_pay_type'] = $common->getPayType($light['cl_pay_type']);
            $light['cl_orderStatus'] = $common->getClOrderStatus($light['cl_order_status']);
            $light['cl_user_idss'] = explode(',',$light['cl_user_ids']);
            $light['cl_pay_imgs'] = explode(',',$light['cl_pay_img']);
            $subOrder = Db::table('crm_order')
                ->where(['order_fu_id' => $cl_id])
                ->field('order_id,order_pay_type,order_status,order_step')
                ->select();
            if($subOrder){
                $comm = new Commons();
                foreach ($subOrder as $k => $v){
                    $subOrder[$k]['order_pay_type']= $comm->getPayType($v['order_pay_type']);
                    $subOrder[$k]['order_statuss']= $comm->getOrderStatus($v['order_status']);
                    $subOrder[$k]['orderStep']= $comm->getOrderStepById($v['order_step']);
                }
            }
            $light['subOrder'] = $subOrder;
            $this->assign('light',$light);
            return $this->fetch();
        }
    }



    /***
     *Names:看房订单页面渲染
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/11/19 14:43
     */
    public function addsub1(){
        $b_id = session('ad_bid');
        $cl_id = trim($this->request->param('cl_id','0','intval'));
        if ($_POST){
            $data = $_POST;
            $data['order_service_id'] = $b_id;
            $addBan = Db::table('crm_order')->insert($data);
            if($addBan){
                $this->success('添加成功！','order');
            }else{
                $this->error('添加失败!','order');
            }
        }else{
            $common = new Commons();
            $orderStep =$common->orderStep();
            $orderBid = $common->orderBidCreateRole($cl_id,1);
            $houseAdd = $common->getHouseAdd($cl_id);
            $this->assign('houseAdd',$houseAdd);
            $this->assign('orderBid',$orderBid);
            $city = Db::table('crm_city')->select();
            $this->assign('city',$city);
            $this->assign('cl_id',$cl_id);
            $this->assign('step',$orderStep);
            return $this->fetch();
        }
    }




    /***
     *Names:领钥匙订单页面渲染
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/11/19 14:43
     */
    public function addsub2(){
        $b_id = session('ad_bid');
        $cl_id = trim($this->request->param('cl_id','0','intval'));
        if ($_POST){
            $data = $_POST;
            $data['order_service_id'] = $b_id;
            $addBan = Db::table('crm_order')->insert($data);
            if($addBan){
                $this->success('添加成功！','order');
            }else{
                $this->error('添加失败!','order');
            }
        }else{
            $common = new Commons();
            $orderStep =$common->orderStep();
            $city = Db::table('crm_city')->select();
            $orderBid = $common->orderBidCreateRole($cl_id,4);
            $houseAdd = $common->getHouseAdd($cl_id);
            $this->assign('houseAdd',$houseAdd);
            $this->assign('orderBid',$orderBid);
            $this->assign('city',$city);
            $this->assign('cl_id',$cl_id);
            $this->assign('step',$orderStep);
            return $this->fetch();
        }
    }

    /***
     *Names:水电气网订单页面渲染
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/11/19 14:43
     */
    public function addsub3(){
        $b_id = session('ad_bid');
        $cl_id = trim($this->request->param('cl_id','0','intval'));
        if($_POST){
            $data["order_step"]  = $_POST['order_step'];
            $data["order_city"]  = $_POST['order_city'];
            $data["order_id"]  = $_POST['order_id'];
            $data["order_fu_id"]  = $_POST['order_fu_id'];
            $data["order_house_address"]  = $_POST['order_house_address'];
            $data["order_pay_type"] = $_POST['order_pay_type'];
            $data["order_pay_price"] = $_POST['order_pay_price'];
            $data["order_remarks"] = $_POST['order_remarks'];
            $data["order_show_time"] = $_POST['order_show_time'];
            $data["order_price"] = $_POST['order_price'];
            $data['order_service_id'] = $b_id;
            $data["order_paytime"] = $_POST['order_paytime'];
            $addBan = Db::table('crm_order')->insertGetId($data);
            $subOrder = $_POST['sub'];
            foreach($subOrder as $key => $val){
                $sub['so_order_id'] = $addBan;
                $sub['so_sub_type'] = $key;
                Db::table('crm_sub_order')->insert($sub);
            }
            if($addBan){
                $this->success('添加成功！','order');
            }else{
                $this->error('添加失败!','order');
            }
        }else{
            $common = new Commons();
            $orderStep =$common->orderStep();
            $orderBid = $common->orderBidCreateRole($cl_id,3);
            $houseAdd = $common->getHouseAdd($cl_id);
            $this->assign('houseAdd',$houseAdd);
            $this->assign('orderBid',$orderBid);
            $city = Db::table('crm_city')->select();
            $this->assign('city',$city);
            $this->assign('cl_id',$cl_id);
            $this->assign('step',$orderStep);
            return $this->fetch();
        }
    }


    /***
     * Notes:闪电租房售订单列表后页面渲染
     * @return mixed
     * Author: Created by Dang Mengmeng At 2019/12/11 9:42
     */
    public function sale(){
        //售后统计
        //1.一站式
        //一站式 闪电租房 1 单次闪电 学生公寓 个人房源
        //订单类型;4闪电租房；5一站式；6单次闪电；7学生公寓；8个人房源
        $common = new Commons();
        $count1 = $common->getOrderCount(5);
        $count1 = $count1 >=100 ? '99+': $count1;
        //2.闪电租房
        $count2 = $common->getOrderCount(4);
        $count2 = $count2 >=100 ? '99+': $count2;
        //3.单次闪电
        $count3 = $common->getOrderCount(6);
        $count3 = $count3 >=100 ? '99+': $count3;
        //4.学生公寓
        $count4 = $common->getOrderCount(7);
        $count4 = $count4 >=100 ? '99+': $count4;
        //5.个人房源
        $count5 = $common->getOrderCount(8);
        $count5 = $count5 >=100 ? '99+': $count5;
        $this->assign('count1',$count1);
        $this->assign('count2',$count2);
        $this->assign('count3',$count3);
        $this->assign('count4',$count4);
        $this->assign('count5',$count5);
        return $this->fetch();
    }


    /***
     * Notes:闪电租房售订单列表数据
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Author: Created by Dang Mengmeng At 2019/12/11 9:42
     */
    public function saleData(){
        $adminId = session('adminId');
        $roleId = intval(session('ad_role'));
        $keywords = trim($this->request->param('keywords'));
        $step = trim($this->request->param('step'));
        $live_time=$this->request->param('live_time');
        $where=" 1 = 1";
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( cl_order_id like '%".$keywords."%' )";
        }
        if(isset($step) && !empty($step)){
            $where.=" and cl_order_status in (2,3) and cl_order_type = ".$step;
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=substr($live_time,'0','10');
            $edate=substr($live_time,'-10');
            $where.=" and ( cl_end_time >= '".$sdate."' and cl_end_time <= '".$edate."' ) ";
        }
        $count=Db::table('crm_light')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('crm_light')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order(['cl_add_time' => 'desc'])
            ->select();
        $common = new Commons();
        if($cusInfo){
            foreach ($cusInfo as $k => $v){
                $cusInfo[$k]['cl_order_type'] = $common->lightOrderStep($v['cl_order_type']);
                $cusInfo[$k]['cl_orderStatus'] = $common->getClOrderStatus($v['cl_order_status']);
                $cusInfo[$k]['cl_order_refund'] = $common->getOrderRefund($v['cl_order_refund']);
                $cusInfo[$k]['cl_user_ids'] = explode(',',$v['cl_user_ids']);
                $cusInfo[$k]['cl_sl_is_check'] = $v['cl_sl_is_check'] == 1 ? '是' : '否';
                //$cusInfo[$k]['cl_order_refund'] = $v['cl_order_refund'] == 0 ? '否' : '是';
                $cusInfo[$k]['cl_sl_good_com'] = $v['cl_sl_good_com'] == 1 ? '是' : '否';
                $cusInfo[$k]['cl_sl_is_review'] = $v['cl_sl_is_review'] == 1 ? '是' : '否';
                $cusInfo[$k]['cl_cl_admin'] = $common->getInspectors($v['cl_cl_admin']);
                $cusInfo[$k]['orderColor']= $common->deadLineShowColor($v['cl_sl_deadline']);
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }


    /***
     * Notes:售后更新订单
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     * Author: Created by Dang Mengmeng At 2019/12/11 15:12
     */
    public function edit2(){
        $cl_id = trim($this->request->param('cl_id','0','intval'));
        //type = 1 保存信息不更新状态
        $type = trim($this->request->param('type','0','intval'));
        $b_id = session('ad_bid');
        $status = $this->getOrderStatus($cl_id);
        if($_POST){
            //更新状态且订单状态是材料准备
            if($type == 0 && $status == 2){
                $this->error('此订单无法更新状态!','sale');
            }
            $cl_is_pay = $_POST['cl_is_pay'];
            $data['cl_sl_is_check'] = $_POST['cl_sl_is_check'];
            $data['cl_sl_good_com'] = $_POST['cl_sl_good_com'];
            $data['cl_sl_is_review'] = $_POST['cl_sl_is_review'];
            $data['cl_sl_remarks'] = $_POST['cl_sl_remarks'];
            $data['cl_sl_remarks'] = $_POST['cl_sl_remarks'];
//            $data['cl_sl_deadline'] = $_POST['cl_sl_deadline'];
            $img = isset($_POST['cl_sl_img'])?$_POST['cl_sl_img']:array();
            $h_img = '';
            for ($i=0;$i<sizeof($img);$i++){
                $h_img.=$img[$i].",";
            }
            $data['cl_sl_img']=trim($h_img,',');

            //snow是否结算  是   更新为已闭环   否 更新为待闭环
            //1售前：2材料申请（顾问服务阶段）3售后；4.已完成
            //售后更新  type = 0  售后保存type = 1
//            if($cl_is_pay == 1){
//                //已结算
//                $status = $type == 1 ? 3 : 4;
//            }else{
//                $status = 3;
//            }
            //type = 1 保存信息不更新状态
            $status = $type == 1 ? $status : $status+1;
            $data['cl_order_status'] = $status;
            $data['cl_sl_admin'] = $b_id;
            $data['cl_sl_addtime'] = $type == 1 ? '' : date('Y-m-d H:i:s');
            $insert = Db::table('crm_light')->where(['cl_id' => $cl_id])->update($data);
            if($insert){
                $this->success('修改成功！','sale');
            }else{
                $this->error('修改失败!','sale');
            }
        }else{

            $light = Db::table('crm_light')
                ->where(['cl_id' => $cl_id])
                ->find();
            $common = new Commons();
            $light['cl_price'] = $light['cl_pay_type'] == 1 ? $light['cl_price'].'（人民币）' : $light['cl_price'].'（澳币）' ;
            $light['cl_user_idss'] = explode(',',$light['cl_user_ids']);
            $light['cl_pay_type'] = $common->getPayType($light['cl_pay_type']);
            $light['cl_orderStatus'] = $common->getClOrderStatus($light['cl_order_status']);
            $light['cl_cl_admin'] = $common->getInspectors($light['cl_cl_admin']);
            $light['cl_user_idss'] = explode(',',$light['cl_user_ids']);
            $light['cl_pay_imgs'] = explode(',',$light['cl_pay_img']);
            $light['cl_sl_imgs'] = explode(',',$light['cl_sl_img']);
            $subOrder = Db::table('crm_order')
                ->where(['order_fu_id' => $cl_id])
                ->field('order_id,order_pay_type,order_status,order_step,crm_id')
                ->select();
            if($subOrder){
                $comm = new Commons();
                foreach ($subOrder as $k => $v){
                    $subOrder[$k]['order_pay_type']= $comm->getPayType($v['order_pay_type']);
                    $subOrder[$k]['order_statuss']= $comm->getOrderStatus($v['order_status']);
                    $subOrder[$k]['orderStep']= $comm->getOrderStepById($v['order_step']);
                }
            }
            //清洁检查
            $clean = Db::table('crm_clean')
                ->where(['cc_order_fu_id' => $cl_id])
                ->field('cc_id,cc_order_id')
                ->select();
            $light['subOrder'] = $subOrder;
            $this->assign('light',$light);
            $this->assign('clean',$clean);
            return $this->fetch();
        }
    }


    public function getOrderStatus($cl_id){
        $order = Db::table('crm_light')
            ->where(['cl_id' => $cl_id])
            ->find();
        return $order['cl_order_status'];

    }


    /***
     * Notes:闪电租房子订单领钥匙订单详情
     * @return mixed
     * Author: Created by Dang Mengmeng At 2019/12/12 14:37
     */
    public function subdet1(){
        $b_id = session('ad_bid');
        $crm_id = intval(trim($this->request->param('crm_id')));
        $order=Db::table('crm_order')
            ->where(['crm_id'=> $crm_id])
            ->find();
        $common = new Commons();
        if($order){
            $order['orderStep'] = $common->getOrderStepById($order['order_step']);
        }
        if($order['order_step'] == 3){
            $order['sub'] = $common->getSubOrder($order['crm_id']);
        }
        $this->assign('order',$order);
        $city = Db::table('crm_city')->select();
        $this->assign('city',$city);
        return $this->fetch();
    }


    /***
     * Notes:闪电租房子订单水电气网详情
     * @return mixed
     * Author: Created by Dang Mengmeng At 2019/12/12 14:37
     */
    public function subdet2(){
        $b_id = session('ad_bid');
        $crm_id = intval(trim($this->request->param('crm_id')));
        $order=Db::table('crm_order')
            ->where(['crm_id'=> $crm_id])
            ->find();
        $common = new Commons();
        if($order){
            $order['orderStep'] = $common->getOrderStepById($order['order_step']);
        }
        $this->assign('order',$order);
        $city = Db::table('crm_city')->select();
        $this->assign('city',$city);
        return $this->fetch();
    }

    /***
     * Notes:闪电租房子订单看房单详情
     * @return mixed
     * Author: Created by Dang Mengmeng At 2019/12/12 14:37
     */
    public function subdet3(){
        $b_id = session('ad_bid');
        $crm_id = intval(trim($this->request->param('crm_id')));
        $all_sub = [
            [
                'so_sub_type' => 2,
                'sub_name' => '电',
                'is_checked' => false
            ],
            [
                'so_sub_type' => 3,
                'sub_name' => '气/热水',
                'is_checked' => false
            ],
            [
                'so_sub_type' => 4,
                'sub_name' => '网',
                'is_checked' => false
            ]
        ];
        $order=Db::table('crm_order')
            ->where(['crm_id'=> $crm_id])
            ->find();
        $common = new Commons();
        if($order){
            $order['orderStep'] = $common->getOrderStepById($order['order_step']);
        }
        if($order['order_step'] == 3){
            $sub = $common->getSubOrder($order['crm_id']);
            $subs = $sub ? array_column($sub, 'so_sub_type') : [];
            foreach ($all_sub as $key => &$val) {
                if(in_array($val['so_sub_type'], $subs)) {
                    $val['is_checked'] = true;
                }
            }unset($val);
            $order['sub'] = $sub;
        }

        $this->assign('all_sub', $all_sub);
        $this->assign('order',$order);
        $city = Db::table('crm_city')->select();
        $this->assign('city',$city);
        return $this->fetch();
    }


    public function balance(){
        return $this->fetch();
    }

    public function baData(){
            $adminId = session('ad_bid');
            $roleId = intval(session('ad_role'));
            $keywords = trim($this->request->param('keywords'));
            $step = trim($this->request->param('step'));
            $live_time=$this->request->param('live_time');
            $where="cl_order_status > 2 and cl_is_pay = 2 ";
            //分页统计总数；
            if(isset($keywords) && !empty($keywords)){
                $where.=" and ( cl_order_id like '%".$keywords."%' )";
            }
            if(isset($step) && !empty($step)){
                $where.=" and cl_order_type = ".$step;
            }
            if(isset($live_time) && !empty($live_time)){
                $sdate=substr($live_time,'0','10');
                $edate=substr($live_time,'-10');
                $where.=" and ( cl_add_time >= '".$sdate."' and cl_add_time <= '".$edate."' ) ";
            }
            $count=Db::table('crm_light')
                ->where($where)->count();
            $page= $this->request->param('page',1,'intval');
            $limit=$this->request->param('limit',10,'intval');
            $cusInfo=Db::table('crm_light')
                ->where($where)
                ->limit(($page-1)*$limit,$limit)
                ->order('cl_sl_deadline is null,cl_sl_deadline asc')
                ->select();
            $common = new Commons();
            if($cusInfo){
                foreach ($cusInfo as $k => $v){
                    $cusInfo[$k]['cl_pay_type'] = $common->getPayType($v['cl_pay_type']);
                    $cusInfo[$k]['cl_order_type'] = $common->lightOrderStep($v['cl_order_type']);
                    $cusInfo[$k]['cl_orderStatus'] = $common->getClOrderStatus($v['cl_order_status']);
                    $cusInfo[$k]['cl_user_ids'] = explode(',',$v['cl_user_ids']);
                    $cusInfo[$k]['cl_is_pay'] = $v['cl_is_pay'] == 1 ? '是' : '否';
                    $cusInfo[$k]['orderColor']= $common->deadLineShowColor($v['cl_sl_deadline']);
                }
            }
            $res['code'] = 0;
            $res['msg'] = "";
            $res['data'] = $cusInfo;
            $res['count'] = $count;
            return json($res);
        }


    public function batchBalance(){
        $b_id = session('ad_bid');
        $ids = ltrim($this->request->param('ids'),',');
        $idArr = explode(',',$ids);
        foreach($idArr as $key => $value) {
            $light = Db::table('crm_light')
                ->where(['cl_id' => $value])
                ->field('cl_sl_is_review')
                ->find();
            $data['cl_is_pay'] = 1;
            $data['cl_pay_admin'] = $b_id;
            $data['cl_fl_pay_time'] = date('Y-m-d H:i:s');
//            //检测售后是否处理 1售前：2材料申请（顾问服务阶段）3待闭环；4.已闭环
//            if($light['cl_sl_is_review'] == 1 && $light['cl_sl_is_review']){
//                //售后已处理；更新订单状态为已闭环
//               $data['cl_order_status'] = 4;
//            }
            $res = Db::table('crm_light')
                ->where(['cl_id' => $value])
                ->update($data);
        }
        return  json(['code' => '1']);
    }


    public function refund(){
        $cl_id = trim($this->request->param('cl_id'));
        $refund = Db::table('crm_refund')
            ->where(['cr_order_id' => $cl_id,'cr_order_type' => 4])
            ->find();
        if($refund){
            $this->assign('refund',$refund);
        }else{
            $b_id = session('ad_bid');
            $add['cr_order_id'] = $cl_id;
            $add['cr_order_type'] = 4;
            $add['cr_add_time'] = date('Y-m-d H:i:s');
            $add['cr_admin'] = $b_id;
            $cr_id = Db::table('crm_refund')->insertGetId($add);
            $refund = Db::table('crm_refund')
                ->where(['cr_id' => $cr_id])
                ->find();
            $update = Db::table('crm_light')
                ->where(['cl_id' =>$cl_id])
                ->update(['cl_order_refund' => $cr_id]);
            $this->assign('refund',$refund);
        }
        return $this->fetch();

    }


    public function refunds(){
        $cr_id = trim($this->request->param('cr_id','0','intval'));
        $data["cr_refund_order"] = $_POST['cr_refund_order'];
        $data["cr_price"] = $_POST['cr_price'];
        $data["cr_img"] = $_POST['cr_img'];
        $data["cr_resaon"] = $_POST['cr_resaon'];
        $update = Db::table('crm_refund')
            ->where(['cr_id' => $cr_id])
            ->update($data);
        if($update){
            $res['code'] = 1;
            $res['msg'] = '更新成功！';
        }else{
            $res['code'] = 0;
            $res['msg'] = '更新失败！';
        }
        return  json($res);
    }



    public function adduser(){
        $adminId = session('adminId');
        if($_POST){
            $data['crm_wechat'] = $_POST['crm_wechat'];
            $isRepeat=Db::table('crm_user')
                ->where(['crm_wechat' => $data['crm_wechat']])
                ->find();
            if($isRepeat){
                $this->error('此微信号已注册！','add');
            }
            $data['crm_user_admin'] = $adminId;
            $data['crm_user_bid'] = $_POST['crm_user_bid'];
            $data['crm_sex'] = $_POST['crm_sex'];
            $data['crm_refer'] = $_POST['crm_refer'];
            $data['crm_phone'] = $_POST['crm_phone'];
            $data['crm_city'] = $_POST['crm_city'];
            $data['crm_school'] = $_POST['crm_school'];
            $data['crm_remarks'] = $_POST['crm_remarks'];
            $data['crm_service_type'] = $_POST['crm_service_type'];
            $data['crm_user_from'] = $_POST['crm_user_from'];
            $data['crm_user_status'] = $_POST['crm_user_status'];
            $data['crm_house_type'] = $_POST['crm_house_type'];
            $data['crm_user_name'] = $_POST['crm_user_name'];
            $data['crm_room_type'] = $_POST['crm_room_type'];
            $data['crm_price_min'] = $_POST['crm_price_min'];
            $data['crm_price_max'] = $_POST['crm_price_max'];
            $data['crm_car_site'] = isset($_POST['crm_car_site'])? 1:0;
            $data['crm_is_star'] = $_POST['crm_is_star'];
            $data['crm_need'] = $_POST['crm_need'];
            $data['crm_user_addtime'] = time();
            $data['crm_update_time'] = time();
            $data['crm_birthday'] = strtotime($_POST['crm_birthday']);
            $data['crm_live_time'] = strlen(strtotime($_POST['crm_live_time'])) ? strtotime($_POST['crm_live_time']) :'';
            $addBan=Db::table('crm_user')->insertGetId($data);
            if($addBan){
                $alert['alert_time'] = strtotime($_POST['alert_time']);
                $alert['user_id'] = $addBan;
                $alert['alert_remark'] =$_POST['alert_remark'];
                $alert['add_time'] = time();
                $alert['alert_admin'] = $adminId;
                $addInsert = Db::table('crm_user_alert')->insert($alert);
                $this->success('添加成功！','index',$data['crm_user_bid']);
            }else{
                $this->error('添加失败!','index');
            }
        }else{
            $city = Db::table('crm_city')->select();
            $this->assign('city',$city);
            $service = Db::table('crm_service')->select();
            $this->assign('service',$service);
            $userStatus = Db::table('crm_user_status')->where(['is_able' => 1])->select();
            $this->assign('userStatus',$userStatus);
            $houseType = Db::table('crm_house_type')->where(['ht_type' =>1])->select();
            $this->assign('houseType',$houseType);
            $roomType = Db::table('crm_house_type')->where(['ht_type' =>2])->select();
            $this->assign('roomType',$roomType);
            $price = Db::table('crm_house_type')->where(['ht_type' =>3])->select();
            $this->assign('priceRange',$price);
            //客户来源
            $userForm = Db::table('crm_user_form')->select();
            $this->assign('userForm',$userForm);
            //生成用户编号
            $custId = $this->getCustId($adminId);
            $this->assign('custId',$custId);
            return $this->fetch();
        }
    }

    //生成用户编号
    public function getCustId($adminId){
        //C开头；
        $custId = 'C';
        //工作人员员工编号工号后三位
        $cusBid = $this->getAdminBid($adminId);
        $custId .=sprintf("%03d", $cusBid);
        //年份的后三位+月份和日期
        $date = substr(date('Ymd'),'1');
        $custId .=$date;
        //获取当日预约的数量+月份和日期
        $stime=strtotime(date('Y-m-d 00:00:00'));
        $etime=strtotime(date('Y-m-d 23:59:59'));
        $buNum=Db::table('crm_user')
            ->where(['crm_user_admin' => $adminId])
            ->where('crm_user_addtime','between',[$stime,$etime])
            ->count();
        $custId .=sprintf("%03d", $buNum+1);
        return $custId;
    }

    public function getAdminBid($adminId){
        $adminInfo = Db::table('super_admin')->where(['ad_id' => $adminId])->field('ad_bid')->find();
        $adBid = substr($adminInfo['ad_bid'],-3);
        return $adBid;
    }


    public function addsub4(){
        $b_id = session('ad_bid');
        $cl_id = trim($this->request->param('cl_id','0','intval'));
        if ($_POST){
            $data = $_POST;
            $data['order_service_id'] = $b_id;
            $data['order_status'] = 3;
            $data['order_addtime'] = date('Y-m-d H:i:s');
            $addBan = Db::table('crm_order')->insert($data);
            if($addBan){
                $this->success('添加成功！','order');
            }else{
                $this->error('添加失败!','order');
            }
        }else{
            $common = new Commons();
            $orderStep =$common->orderStep();
            $orderBid = $common->orderBidCreateRole($cl_id,2);
            $houseAdd = $common->getHouseAdd($cl_id);
            $this->assign('houseAdd',$houseAdd);
            $this->assign('orderBid',$orderBid);
            $city = Db::table('crm_city')->select();
            $this->assign('city',$city);
            $this->assign('cl_id',$cl_id);
            $this->assign('step',$orderStep);
            return $this->fetch();
        }
    }

    public function subdet4(){
        $b_id = session('ad_bid');
        $crm_id = intval(trim($this->request->param('crm_id')));
        $order=Db::table('crm_order')
            ->where(['crm_id'=> $crm_id])
            ->find();
        $common = new Commons();
        if($order){
            $order['orderStep'] = $common->getOrderStepById($order['order_step']);
        }
        $this->assign('order',$order);
        $city = Db::table('crm_city')->select();
        $this->assign('city',$city);
        return $this->fetch();
    }
}