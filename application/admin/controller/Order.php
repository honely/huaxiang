<?php


namespace app\admin\controller;


use app\admin\model\Commons;
use think\Controller;
use think\Db;
use think\Request;

class Order extends Controller
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
     *Names:订单管理方法
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/10/29 11:48
     */
    public function order(){
        $adminId = session('adminId');
        $common = new Commons();
        $keywords = trim($this->request->param('keywords'));
        $step= trim($this->request->param('step','0','intval'));
        $orderStep =$common->orderStep();
        $this->assign('keywords',$keywords);
        $this->assign('step',$orderStep);
        $this->assign('steps',$step);
        $city = Db::table('crm_city')->select();
        $this->assign('city',$city);
        return $this->fetch();
    }


    /***
     *Names:订单数据
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/10/29 9:56
     */
    public function orderData(){
        date_default_timezone_set("Asia/Shanghai");
        $adminId = session('ad_bid');
        $roleId = intval(session('ad_role'));
        $keywords = trim($this->request->param('keywords'));
        $status = intval(trim($this->request->param('status')));
        $city = intval(trim($this->request->param('city')));
        $step = intval(trim($this->request->param('step')));
        $live_time=$this->request->param('live_time');
        if($roleId == 1 || $roleId == 35 || $roleId == 33){
            $where=" 1 = 1";
        }else{
            $where=" 1 = 1 and order_service_id = '".$adminId."'";
        }
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( order_id like '%".$keywords."%' )";
        }
        if(isset($status) && !empty($status) && $status){
            $where.=" and order_status = ".$status;
        }
        if(isset($step) && !empty($step) && $step){
            $where.=" and order_step = ".$step;
        }
        if(isset($city) && !empty($city) && $city){
            $where.=" and order_city = ".$city;
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=substr($live_time,'0','10')." 00:00:00";
            $edate=substr($live_time,'-10')." 23:59:59";
            $where.=" and ( order_show_time >= '".$sdate."' and order_show_time <= '".$edate."' ) ";
        }
        $count=Db::table('crm_order')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('crm_order')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order(['order_status' => 'asc','order_show_time' => 'asc'])
            ->select();
        $comm = new Commons();
        foreach($cusInfo as $k => $v){
            if(!empty($v['crm_user_admin']) && is_int($v['crm_user_admin'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['crm_user_admin']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $cusInfo[$k]['crm_user_admin']= $adName;
            if(!empty($v['order_city'])){
                $adInfo=Db::table('crm_city')
                    ->where(['crm_c_id' => $v['order_city']])
                    ->find();
                $city = $adInfo['crm_city'];
            }else{
                $city="---";
            }
            $cusInfo[$k]['order_city']= $city;
            $cusInfo[$k]['orderColor']= $comm->deadLineShowColor($v['order_show_time']);
            $cusInfo[$k]['order_pay_price'] = $v['order_pay_type'] == 1 ? $v['order_pay_price'].'（人民币）' : $v['order_pay_price'].'（澳币）' ;
            $cusInfo[$k]['order_type']= $v['order_type'] ? $comm->getOrderType($v['order_type']) :'---';
            $cusInfo[$k]['order_pay_type']= $comm->getPayType($v['order_pay_type']);
            $cusInfo[$k]['order_statuss']= $comm->getOrderStatus($v['order_status']);
            $cusInfo[$k]['orderStep']= $comm->getOrderStepById($v['order_step']);
            $cusInfo[$k]['order_show_time']= $v['order_show_time'] == null ? '---' : $v['order_show_time'];
        }
        $res['code'] = 0;
        $res['msg'] = $keywords;
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }



    public function orderdet(){
        $crm_id = trim($this->request->param('crm_id'));
        $order=Db::table('crm_order')
            ->join('crm_order_logs','crm_order.crm_id = crm_order_logs.ol_order_id','left')
            ->where(['crm_id' => $crm_id])
            ->where('ol_status = 1 or ol_status = 3')
            ->find();
        $comm = new Commons();
        $order['order_statuss'] = $comm->getOrderStatus($order['order_status']);
        $order['order_type'] = $order['order_type'] ? $comm->getOrderType($order['order_type']) :'---';
        $order['ol_inspector'] = $comm->getInspectors($order['ol_inspector']);
        $order['orderStep']= $comm->getOrderStepById($order['order_step']);
        $order['order_pay_type']= $comm->getPayType($order['order_pay_type']);
        $order['orderColor']= $comm->deadLineShowColor($order['order_show_time']);
        $order['ol_image'] = explode(',',$order['ol_images']);
        $order['ol_videos'] = explode(',',$order['ol_video']);
        if($order['order_step'] == 3){
            $order['sub'] = $comm->getSubOrder($order['crm_id']);
            if($order['sub'] && $order['order_status'] == 3){
                foreach ($order['sub'] as $k => $v){
                    $order['sub'][$k]['sub_comp'] = $comm->getEnergyCom($v['so_sub_cp_id']);
                    $order['sub'][$k]['subStatus'] = $comm->getBalanceStatus($v['so_status']);
                }
            }
        }
        $this->assign('order',$order);
        return $this->fetch();
    }

    public function todos(){
        $adminId = session('adminId');
        $common = new Commons();
        $orderStep =$common->orderStep();
        $this->assign('step',$orderStep);
        $city = Db::table('crm_city')->select();
        $this->assign('city',$city);
        return $this->fetch();
    }


    public function upDoc(){
        $ol_id = intval(trim($this->request->param('ol_id')));
        $type = intval(trim($this->request->param('type','0','intval')));
        $order=Db::table('crm_order_logs')
            ->join('crm_order','crm_order.crm_id = crm_order_logs.ol_order_id','left')
            ->where(['ol_id' => $ol_id])
            ->find();
        if($_POST){
            if($order['order_step'] == 3){
                if (isset($_POST['elect']) && !empty($_POST['elect'])){
                    $upSubElect = Db::table('crm_sub_order')
                        ->where(['so_id' => $_POST['elect']])
                        ->update(['so_sub_cp_id' => $_POST['elect_value']]);
                }
                if (isset($_POST['gas']) && !empty($_POST['gas'])){
                    $upSubGas = Db::table('crm_sub_order')
                        ->where(['so_id' => $_POST['gas']])
                        ->update(['so_sub_cp_id' => $_POST['gas_value']]);
                }
                if (isset($_POST['nets']) && !empty($_POST['nets'])){
                    $upSubNet = Db::table('crm_sub_order')
                        ->where(['so_id' => $_POST['nets']])
                        ->update(['so_sub_cp_id' => $_POST['nets_value']]);
                }
            }
            if($order == 1){
                if($_POST['is_finish'] == 1){
                    if(empty($_POST['ol_images'])){
                        $this->error('图片资料上传不完整！');
                    }
                    if(empty($_POST['ol_doc'])){
                        $this->error('报告资料上传不完整！');
                    }
                    $status = $type == 1 ? 2 : 3;
                }else{
                    $status = $type == 1 ? 2 :4;
                }
            }else{
                $status = $type == 1 ? 2 : 3;
            }
            //图片
            $img = isset($_POST['ol_images'])?$_POST['ol_images']:array();
            $h_img = '';
            for ($i=0;$i<sizeof($img);$i++){
                $h_img.=$img[$i].",";
            }
            $data['ol_images']=trim($h_img,',');
            //视频
            $vid = isset($_POST['ol_video'])?$_POST['ol_video']:array();
            $vids = '';
            for ($i=0;$i<sizeof($vid);$i++){
                $vids.=$vid[$i].",";
            }
            $data['ol_video']=trim($vids,',');
            $data['ol_remarks']=trim($_POST['ol_remarks']);
            $data['ol_doc']=isset($_POST['ol_doc'])? trim($_POST['ol_doc']):'';
            //已完成
            $data['ol_status'] = $type == 1 ? 1 : 3;
            $data['ol_up_time'] = time();
            $updates = Db::table('crm_order_logs')
                ->where(['ol_id'=> $ol_id])
                ->update($data);

            $update = Db::table('crm_order')
                ->where(['crm_id'=> $order['crm_id']])
                ->update(['order_status' => $status]);
            if($update || $updates){
                $this->success('上传成功！','todos');
            }else{
                $this->error('上传失败！','todos');
            }
        }else{
            $common = new Commons();
            $order['ol_image'] = explode(',',$order['ol_images']);
            $order['ol_videos'] = explode(',',$order['ol_video']);
            $order['order_type'] = $order['order_type'] ? $common->getOrderType($order['order_type']) :'--';
            $order['orderStep'] = $common->getOrderStepById($order['order_step']);
            if($order['order_step'] == 3){
                $order['sub'] = $common->getSubOrder($order['crm_id']);
                $elect = $common->energyCmp(2);
                $gas = $common->energyCmp(2);
                $nets = $common->energyCmp(4);
                $this->assign('elect',$elect);
                $this->assign('gas',$gas);
                $this->assign('nets',$nets);
            }
            $this->assign('order',$order);
            return $this->fetch();
        }
    }



    public function balance(){
        $common = new Commons();
        $orderStep =$common->orderStep();
        $city = Db::table('crm_city')->select();
        $this->assign('city',$city);
        $this->assign('step',$orderStep);
        return $this->fetch();
    }

    public function balance1(){
        $common = new Commons();
        $orderStep =$common->orderStep();
        $city = Db::table('crm_city')->select();
        $this->assign('city',$city);
        $this->assign('step',$orderStep);
        $cusInfo=Db::table('crm_sub_order')
            ->join('crm_order','crm_sub_order.so_order_id = crm_order.crm_id')
            ->where(['order_status' => 3,'so_status' => 1 ,'order_step' => 3])
            ->order(['order_show_time' => 'asc'])
            ->select();
        return $this->fetch();
    }
    public function banData1(){
        $adminId = session('ad_bid');
        $roleId = intval(session('ad_role'));
        $city = trim($this->request->param('city'));
        $keywords = trim($this->request->param('keywords'));
        $company = trim($this->request->param('company'));
        $live_time=$this->request->param('live_time');
        $where=" 1 = 1";
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( order_id = '".$keywords."' )";
        }
        if(isset($company) && !empty($company) && $company){
            $where.=" and eg_company = '".$company."'";
        }
        if(isset($city) && !empty($city) && $city){
            $where.=" and order_city = ".$city;
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=substr($live_time,'0','10')." 00:00:00";
            $edate=substr($live_time,'-10')." 23:59:59";
            $where.=" and ( order_show_time >= '".$sdate."' and order_show_time <= '".$edate."' ) ";
        }
        $count=Db::table('crm_sub_order')
            ->join('crm_energy','crm_sub_order.so_sub_cp_id = crm_energy.eg_id')
            ->join('crm_order','crm_sub_order.so_order_id = crm_order.crm_id')
            ->where(['order_status' => 3,'so_status' => 1 ,'order_step' => 3])
            ->where($where)
            ->field('crm_sub_order.*,crm_order.*,crm_energy.eg_company')
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('crm_sub_order')
            ->join('crm_energy','crm_sub_order.so_sub_cp_id = crm_energy.eg_id')
            ->join('crm_order','crm_sub_order.so_order_id = crm_order.crm_id')
            ->where(['order_status' => 3,'so_status' => 1 ,'order_step' => 3])
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->field('crm_sub_order.*,crm_order.*,crm_energy.eg_company')
            ->order(['order_show_time' => 'asc'])
            ->select();
        $common = new Commons();
        foreach($cusInfo as $k => $v){
            if(!empty($v['crm_user_admin']) && is_int($v['crm_user_admin'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['crm_user_admin']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $cusInfo[$k]['crm_user_admin']= $adName;
            if(!empty($v['order_city'])){
                $adInfo=Db::table('crm_city')
                    ->where(['crm_c_id' => $v['order_city']])
                    ->find();
                $city = $adInfo['crm_city'];
            }else{
                $city="---";
            }
            $cusInfo[$k]['order_city']= $city;
            $cusInfo[$k]['inspector'] = $common->getInspectorName($v['crm_id']);
            $cusInfo[$k]['orderColor']= $common->deadLineShowColor($v['order_show_time']);
            $cusInfo[$k]['order_pay_type']= $common->getPayType($v['order_pay_type']);
            $cusInfo[$k]['soStatus']= $common->getBalanceStatus($v['so_status']);
            $cusInfo[$k]['orderStep']= $common->getOrderStepById($v['order_step']);
            $cusInfo[$k]['energyName']= $common->getEnergyName($v['so_sub_type']);
            $cusInfo[$k]['energyComp']= $common->getEnergyCom($v['so_sub_cp_id']);
            $cusInfo[$k]['order_show_time']= $v['order_show_time'] == null ? '---' : $v['order_show_time'];
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }
    public function banData(){
        $adminId = session('ad_bid');
        $roleId = intval(session('ad_role'));
        $keywords = trim($this->request->param('keywords'));
        $city = intval(trim($this->request->param('city')));
        $step = intval(trim($this->request->param('step')));
        $live_time=$this->request->param('live_time');
        $where=" 1 = 1";
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( order_id = '".$keywords."' )";
        }
        if(isset($step) && !empty($step) && $step){
            $where.=" and order_step = ".$step;
        }
        if(isset($city) && !empty($city) && $city){
            $where.=" and order_city = ".$city;
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=substr($live_time,'0','10')." 00:00:00";
            $edate=substr($live_time,'-10')." 23:59:59";
            $where.=" and ( order_show_time >= '".$sdate."' and order_show_time <= '".$edate."' ) ";
        }
        $count=Db::table('crm_order')
            ->where('order_status = 3 or order_status = 4')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('crm_order')
            ->where($where)
            ->where('order_status = 3 or order_status = 4')
            ->limit(($page-1)*$limit,$limit)
            ->order(['order_status' => 'asc','order_show_time' => 'asc'])
            ->select();
        $common = new Commons();
        foreach($cusInfo as $k => $v){
            if(!empty($v['crm_user_admin']) && is_int($v['crm_user_admin'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['crm_user_admin']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $cusInfo[$k]['crm_user_admin']= $adName;
            if(!empty($v['order_city'])){
                $adInfo=Db::table('crm_city')
                    ->where(['crm_c_id' => $v['order_city']])
                    ->find();
                $city = $adInfo['crm_city'];
            }else{
                $city="---";
            }
            $cusInfo[$k]['order_city']= $city;
            $cusInfo[$k]['inspector'] = $common->getInspectorName($v['crm_id']);
            $cusInfo[$k]['orderColor']= $common->deadLineShowColor($v['order_show_time']);
            $cusInfo[$k]['order_type']= $v['order_type'] ? $common->getOrderType($v['order_type']) :'---';
            $cusInfo[$k]['order_pay_price'] = $v['order_pay_type'] == 1 ? $v['order_pay_price'].'（人民币）' : $v['order_pay_price'].'（澳币）' ;
            $cusInfo[$k]['order_pay_type']= $common->getPayType($v['order_pay_type']);
            $cusInfo[$k]['order_status']= $common->getOrderStatus($v['order_status']);
            $cusInfo[$k]['orderStep']= $common->getOrderStepById($v['order_step']);
            $cusInfo[$k]['order_show_time']= $v['order_show_time'] == null ? '---' : $v['order_show_time'];
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
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
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/kanfang/'.$path_date.'/');
            if($info){
                $res['name'] = $info->getFilename();
                $res['filepath'] = 'uploads/kanfang/'.$path_date.'/'.$info->getSaveName();
            }else{
                $res['code'] = 0;
                $res['msg'] = '上传失败！'.$file->getError();
            }
            return $res;
        }
    }


    /***
     *Names:订单删除方法
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     *Created by Dang Mengmeng at 2019/10/31 10:17
     */
    public function del(){
        $crm_id = intval(trim($this->request->param('crm_id')));
        $del = Db::table('crm_order')->where(['crm_id' => $crm_id])->delete();
        Db::table('crm_order_logs')->where(['ol_order_id' => $crm_id])->delete();
        if($del){
            $this->success('删除成功！','order');
        }else{
            $this->error('删除失败！','order');
        }
    }


    /***
     *Names:订单编辑方法
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     *Created by Dang Mengmeng at 2019/10/31 10:18
     */
    public function edit(){
        $b_id = session('ad_bid');
        $crm_id = intval(trim($this->request->param('crm_id')));
        if($_POST){
            $order_step  = $_POST['order_step'];
            $data["order_step"]  = $_POST['order_step'];
            $data["order_city"]  = $_POST['order_city'];
            $data["order_id"]  = $_POST['order_id'];
            $data["order_house_address"]  = $_POST['order_house_address'];
            $data["order_pay_type"] = $_POST['order_pay_type'];
            $data["order_pay_price"] = $_POST['order_pay_price'];
            $data["order_remarks"] = $_POST['order_remarks'];
            $data["order_show_time"] = $_POST['order_show_time'];
            $data["order_price"] = isset($_POST['order_price']) ?$_POST['order_price'] : '';
            $data['order_service_id'] = $b_id;
            switch ($order_step){
                case 1:
                    $data["order_type"]  = $_POST['order_type'];
                    $data["order_house_url"] = $_POST['order_house_url'];
                    $editBan = Db::table('crm_order')->where(['crm_id' =>$crm_id])->update($data);
                    break;
                case 2:
                    $data["other_docs"] = $_POST['other_docs'];
                    $editBan = Db::table('crm_order')->where(['crm_id' =>$crm_id])->update($data);
                    break;
                case 3:
                    $data["order_paytime"] = $_POST['order_paytime'];
                    $editBan = Db::table('crm_order')->where(['crm_id' =>$crm_id])->update($data);
                    $subOrder = $_POST['sub'];
                    foreach($subOrder as $key => $val){
                        $sub['so_order_id'] = $crm_id;
                        $sub['so_sub_type'] = $key;
                        Db::table('crm_sub_order')->where(['so_order_id' => $crm_id])->delete();
                        Db::table('crm_sub_order')->insert($sub);
                    }
            }
            if($editBan){
                $this->success('修改成功！','order');
            }else{
                $this->error('您未做任何修改！','order');
            }
        }else{
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
    }



    public function cancelOrder(){
        $b_id = session('ad_bid');
        $crm_id = intval(trim($this->request->param('crm_id')));
        $orderStatus = Db::table('crm_order')
            ->where(['crm_id' => $crm_id])
            ->update(['order_status' => 1]);
        $orderLog = Db::table('crm_order_logs')
            ->where(['ol_order_id' => $crm_id])
            ->update(['ol_status' => 2, 'ol_cancel_time' => time(),'ol_cancel_admin' =>$b_id]);
        if($orderStatus && $orderLog){
            $this->success('取消成功！','order');
        }else{
            $this->error('取消失败!','order');
        }

    }



    public function todoData(){
        $adminId = session('adminId');
        $b_id = session('ad_bid');
        $roleId = intval(session('ad_role'));
        $keywords = trim($this->request->param('keywords'));
        $status = intval(trim($this->request->param('status')));
        $step = intval(trim($this->request->param('step')));
        $city = intval(trim($this->request->param('city')));
        $live_time=$this->request->param('live_time');
        $where=" order_status = 1 and order_service_id = '".$b_id."'";
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( order_id = '".$keywords."' )";
        }
        if(isset($step) && !empty($step) && $step){
            $where.=" and order_step = ".$step;
        }
        if(isset($status) && !empty($status) && $status){
            $where.=" and order_status = ".$status;
        }
        if(isset($city) && !empty($city) && $city){
            $where.=" and order_city = ".$city;
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=substr($live_time,'0','10')." 00:00:00";
            $edate=substr($live_time,'-10')." 23:59:59";
            $where.=" and ( order_show_time >= '".$sdate."' and order_show_time <= '".$edate."' ) ";
        }
        $count=Db::table('crm_order')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('crm_order')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order(['order_status' => 'asc','order_show_time' => 'asc'])
            ->select();
        $common = new Commons();
        foreach($cusInfo as $k => $v){
            if(!empty($v['crm_user_admin']) && is_int($v['crm_user_admin'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['crm_user_admin']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $cusInfo[$k]['crm_user_admin']= $adName;
            if(!empty($v['order_city'])){
                $adInfo=Db::table('crm_city')
                    ->where(['crm_c_id' => $v['order_city']])
                    ->find();
                $city = $adInfo['crm_city'];
            }else{
                $city="---";
            }
            $cusInfo[$k]['order_city']= $city;
            $cusInfo[$k]['orderColor']= $common->deadLineShowColor($v['order_show_time']);
            $cusInfo[$k]['order_type']= $v['order_type'] ? $common->getOrderType($v['order_type']) :'---';
            $cusInfo[$k]['order_pay_price'] = $v['order_pay_type'] == 1 ? $v['order_pay_price'].'（人民币）' : $v['order_pay_price'].'（澳币）' ;
            $cusInfo[$k]['order_pay_type']= $common->getPayType($v['order_pay_type']);
            $cusInfo[$k]['order_statuss']= $common->getOrderStatus($v['order_status']);
            $cusInfo[$k]['orderStep']= $common->getOrderStepById($v['order_step']);
            $cusInfo[$k]['order_show_time']= $v['order_show_time'] == null ? '---' : $v['order_show_time'];
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }



    public function details(){
        $common = new Commons();
        $ol_id = intval(trim($this->request->param('ol_id')));
        $order=Db::table('crm_order_logs')
            ->join('crm_order','crm_order.crm_id = crm_order_logs.ol_order_id','left')
            ->where(['ol_id' => $ol_id])
            ->find();
        $order['order_type'] = $order['order_type'] ? $common->getOrderType($order['order_type']) :'---';
        $order['ol_images'] = explode(',',$order['ol_images']);
        $order['ol_video'] = explode(',',$order['ol_video']);
        $this->assign('order',$order);
        return $this->fetch();
    }









    /***
     *Names:方法，操作
     *Created by DangMengmeng at 2019/10/25 11:56
     */
    public function create(){
        $b_id = session('ad_bid');
        if($_POST){

            $order_step  = $_POST['order_step'];
            $data["order_step"]  = $_POST['order_step'];
            $data["order_city"]  = $_POST['order_city'];
            $data["order_id"]  = $_POST['order_id'];
            $data["order_house_address"]  = $_POST['order_house_address'];
            $data["order_pay_type"] = $_POST['order_pay_type'];
            $data["order_pay_price"] = $_POST['order_pay_price'];
            $data["order_remarks"] = $_POST['order_remarks'];
            $data["order_show_time"] = $_POST['order_show_time'];
            $data["order_price"] = $_POST['order_price'];
            $data['order_service_id'] = $b_id;
            switch ($order_step){
                case 1:
                    $data["order_type"]  = $_POST['order_type'];
                    $data["order_house_url"] = $_POST['order_house_url'];
                    $addBan = Db::table('crm_order')->insert($data);
                    break;
                case 2:
                    $data["other_docs"] = $_POST['other_docs'];
                    $addBan = Db::table('crm_order')->insert($data);
                    break;
                case 3:
                    $data["order_paytime"] = $_POST['order_paytime'];
                    $addBan = Db::table('crm_order')->insertGetId($data);
                    $subOrder = $_POST['sub'];
                    foreach($subOrder as $key => $val){
                        $sub['so_order_id'] = $addBan;
                        $sub['so_sub_type'] = $key;
                        Db::table('crm_sub_order')->insert($sub);
                    }
            }
            if($addBan){
                $this->success('添加成功！','order');
            }else{
                $this->error('添加失败!','order');
            }
        }else{
            $common = new Commons();
            $orderStep =$common->orderStep();
            $city = Db::table('crm_city')->select();
            $this->assign('city',$city);
            $this->assign('step',$orderStep);
            return $this->fetch();
        }

    }


    /***
     *Names:售前创建完订单，在售前的todolist里面
     * 当前数据为：订单状态未安排，订单创建者为当前登录售前。
     *Created by Dang Mengmeng at 2019/11/4 19:10
     */
    public function todo1(){
        $adminId = session('adminId');
        $city = Db::table('crm_city')->select();
        $this->assign('city',$city);
        return $this->fetch();
    }

    /***
     *Names:售前创建完订单，在售前的todolist里面
     * 当前数据为：订单状态未安排，订单创建者为当前登录售前。
     *Created by Dang Mengmeng at 2019/11/4 19:10
     */
    public function todoData1(){
        $adminId = session('ad_bid');
        $roleId = intval(session('ad_role'));
        $keywords = trim($this->request->param('keywords'));
        $step = intval(trim($this->request->param('step')));
        $city = intval(trim($this->request->param('city')));
        $live_time=$this->request->param('live_time');
        $common = new Commons();
        if($roleId == 1){
            $where=" 1 = 1";
        }else{
            $where=" 1 = 1 and order_service_id = '".$adminId."' and order_status = 1";
        }
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( order_id = '".$keywords."' )";
        }
        if(isset($step) && !empty($step) && $step){
            $where.=" and order_step = ".$step;
        }
        if(isset($city) && !empty($city) && $city){
            $where.=" and order_city = ".$city;
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=substr($live_time,'0','10')." 00:00:00";
            $edate=substr($live_time,'-10')." 23:59:59";
            $where.=" and ( order_show_time >= '".$sdate."' and order_show_time <= '".$edate."' ) ";
        }
        $count=Db::table('crm_order')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('crm_order')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order(['order_status' => 'asc','order_show_time' => 'asc'])
            ->select();
        foreach($cusInfo as $k => $v){
            if(!empty($v['crm_user_admin']) && is_int($v['crm_user_admin'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['crm_user_admin']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $cusInfo[$k]['crm_user_admin']= $adName;
            if(!empty($v['order_city'])){
                $adInfo=Db::table('crm_city')
                    ->where(['crm_c_id' => $v['order_city']])
                    ->find();
                $city = $adInfo['crm_city'];
            }else{
                $city="---";
            }
            $cusInfo[$k]['order_city']= $city;
            $cusInfo[$k]['orderColor']= $common->deadLineShowColor($v['order_show_time']);
            $cusInfo[$k]['order_type']= $v['order_type'] ? $common->getOrderType($v['order_type']) :'---';
            $cusInfo[$k]['order_pay_price'] = $v['order_pay_type'] == 1 ? $v['order_pay_price'].'（人民币）' : $v['order_pay_price'].'（澳币）' ;
            $cusInfo[$k]['order_pay_type']= $common->getPayType($v['order_pay_type']);
            $cusInfo[$k]['order_statuss']= $common->getOrderStatus($v['order_status']);
            $cusInfo[$k]['orderStep']= $common->getOrderStepById($v['order_step']);
            $cusInfo[$k]['order_show_time']= $v['order_show_time'] == null ? '---' : $v['order_show_time'];
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }


    /***
     *Names:看房员todolist
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/11/4 19:38
     */
    public function todo2(){
        $adminId = session('adminId');
        $common = new Commons();
        $orderStep =$common->orderStep();
        $city = Db::table('crm_city')->select();
        $this->assign('city',$city);
        $this->assign('step',$orderStep);
        return $this->fetch();
    }


    /***
     *Names:看房员todolist数据
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/11/4 19:39
     */
    public function todoData2(){
        $adminId = session('adminId');
        $roleId = intval(session('ad_role'));
        $keywords = trim($this->request->param('keywords'));
        $step = intval(trim($this->request->param('step')));
        $live_time=$this->request->param('live_time');
        $where=" 1 = 1 and ol_status =1";
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( order_id = '".$keywords."' )";
        }
        if(isset($step) && !empty($step) && $step){
            $where.=" and order_step = ".$step;
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=substr($live_time,'0','10')." 00:00:00";
            $edate=substr($live_time,'-10')." 23:59:59";
            $where.=" and ( order_show_time >= '".$sdate."' and order_show_time <= '".$edate."' ) ";
        }
        $count=Db::table('crm_order_logs')
            ->join('crm_order','crm_order.crm_id = crm_order_logs.ol_order_id','left')
            ->where(['ol_inspector' => $adminId])
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('crm_order_logs')
            ->join('crm_order','crm_order.crm_id = crm_order_logs.ol_order_id','left')
            ->where(['ol_inspector' => $adminId])
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order(['order_status' => 'asc','order_show_time' => 'asc'])
            ->select();
        $common = new Commons();
        foreach($cusInfo as $k => $v){
            if(!empty($v['crm_user_admin']) && is_int($v['crm_user_admin'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['crm_user_admin']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $cusInfo[$k]['crm_user_admin']= $adName;
            if(!empty($v['order_city'])){
                $adInfo=Db::table('crm_city')
                    ->where(['crm_c_id' => $v['order_city']])
                    ->find();
                $city = $adInfo['crm_city'];
            }else{
                $city="---";
            }
            $cusInfo[$k]['order_city']= $city;
            $cusInfo[$k]['orderColor']= $common->deadLineShowColor($v['order_show_time']);
            $cusInfo[$k]['order_type']= $v['order_type'] ? $common->getOrderType($v['order_type']) :'---';
            $cusInfo[$k]['order_pay_price'] = $v['order_pay_type'] == 1 ? $v['order_pay_price'].'（人民币）' : $v['order_pay_price'].'（澳币）' ;
            $cusInfo[$k]['order_pay_type']= $common->getPayType($v['order_pay_type']);
            $cusInfo[$k]['order_statuss']= $common->getOrderStatus($v['order_status']);
            $cusInfo[$k]['orderStep']= $common->getOrderStepById($v['order_step']);
            $cusInfo[$k]['order_show_time']= $v['order_show_time'] == null ? '---' : $v['order_show_time'];
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }


    public function orderlog(){
        $adminId = session('adminId');
        $common = new Commons();
        $orderStep =$common->orderStep();
        $city = Db::table('crm_city')->select();
        $this->assign('city',$city);
        $this->assign('step',$orderStep);
        return $this->fetch();
    }


    public function orderLogData(){
        $adminId = session('adminId');
        $roleId = intval(session('ad_role'));
        $keywords = trim($this->request->param('keywords'));
        $step = intval(trim($this->request->param('step')));
        $status = intval(trim($this->request->param('status')));
        $live_time=$this->request->param('live_time');
        $where=" 1 = 1 and ol_status = 3";
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( order_id = '".$keywords."' )";
        }
        if(isset($step) && !empty($step) && $step){
            $where.=" and order_step = ".$step;
        }
        if(isset($status) && !empty($status) && $status){
            $where.=" and order_status = ".$status;
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=substr($live_time,'0','10')." 00:00:00";
            $edate=substr($live_time,'-10')." 23:59:59";
            $where.=" and ( order_show_time >= '".$sdate."' and order_show_time <= '".$edate."' ) ";
        }
        $count=Db::table('crm_order_logs')
            ->join('crm_order','crm_order.crm_id = crm_order_logs.ol_order_id','left')
            ->where(['ol_inspector' => $adminId])
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $cusInfo=Db::table('crm_order_logs')
            ->join('crm_order','crm_order.crm_id = crm_order_logs.ol_order_id','left')
            ->where(['ol_inspector' => $adminId])
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order(['order_status' => 'asc','order_show_time' => 'asc'])
            ->select();
        $common = new Commons();
        foreach($cusInfo as $k => $v){
            if(!empty($v['crm_user_admin']) && is_int($v['crm_user_admin'])){
                $adInfo=Db::table('super_admin')
                    ->where(['ad_id' => $v['crm_user_admin']])
                    ->field('ad_id,ad_realname')->find();
                $adName = $adInfo['ad_realname'];
            }else{
                $adName="---";
            }
            $cusInfo[$k]['crm_user_admin']= $adName;
            if(!empty($v['order_city'])){
                $adInfo=Db::table('crm_city')
                    ->where(['crm_c_id' => $v['order_city']])
                    ->find();
                $city = $adInfo['crm_city'];
            }else{
                $city="---";
            }
            $cusInfo[$k]['order_city']= $city;
            $cusInfo[$k]['orderColor']= $common->deadLineShowColor($v['order_show_time']);
            $cusInfo[$k]['order_type']= $v['order_type'] ? $common->getOrderType($v['order_type']) :'---';
            $cusInfo[$k]['order_pay_price'] = $v['order_pay_type'] == 1 ? $v['order_pay_price'].'（人民币）' : $v['order_pay_price'].'（澳币）' ;
            $cusInfo[$k]['order_pay_type']= $common->getPayType($v['order_pay_type']);
            $cusInfo[$k]['order_statuss']= $common->getOrderStatus($v['order_status']);
            $cusInfo[$k]['orderStep']= $common->getOrderStepById($v['order_step']);
            $cusInfo[$k]['order_show_time']= $v['order_show_time'] == null ? '---' : $v['order_show_time'];
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $cusInfo;
        $res['count'] = $count;
        return json($res);
    }


    public function batchBalance(){
        $ids=rtrim($this->request->param('ids'),',');
        $res=Db::table('crm_order')
            ->where('crm_id','in',$ids)
            ->where('(order_status = 3 or order_status = 4)')
            ->update(['order_status' => 5]);
        if($res){
            return  json(['code' => '1']);
        }else{
            return  json(['code' => '0']);
        }
    }

    public function energyBalance(){
        $ids=rtrim($this->request->param('ids'),',');
        $res=Db::table('crm_sub_order')
            ->where('so_id','in',$ids)
            ->where(['so_status' => 1])
            ->update(['so_status' => 2]);
        if($res){
            return  json(['code' => '1']);
        }else{
            return  json(['code' => '0']);
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
    public function create1(){
        $b_id = session('ad_bid');
        if ($_POST){
            $data = $_POST;
            $data['order_service_id'] = $b_id;
            $data['order_addtime'] = date('Y-m-d');
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
            $this->assign('city',$city);
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
    public function create2(){
        $b_id = session('ad_bid');
        if ($_POST){
            $data = $_POST;
            $data['order_service_id'] = $b_id;
            $data['order_addtime'] = date('Y-m-d');
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
            $this->assign('city',$city);
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
    public function create3(){
        $b_id = session('ad_bid');
        if($_POST){
            $data["order_step"]  = $_POST['order_step'];
            $data["order_city"]  = $_POST['order_city'];
            $data["order_id"]  = $_POST['order_id'];
            $data["order_house_address"]  = $_POST['order_house_address'];
            $data["order_pay_type"] = $_POST['order_pay_type'];
            $data["order_pay_price"] = $_POST['order_pay_price'];
            $data["order_remarks"] = $_POST['order_remarks'];
            $data["order_show_time"] = $_POST['order_show_time'];
            $data["order_price"] = $_POST['order_price'];
            $data['order_service_id'] = $b_id;
            $data["order_paytime"] = $_POST['order_paytime'];
            $data['order_addtime'] = date('Y-m-d');
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
            $city = Db::table('crm_city')->select();
            $this->assign('city',$city);
            $this->assign('step',$orderStep);
            return $this->fetch();
        }
    }


    /***
     *  : 清洁检查创建订单
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by Dang Mengmeng at 2019/11/25 14:43
     */
    public function create4(){
        $b_id = session('ad_bid');
        if($_POST){
            $data["order_step"]  = $_POST['order_step'];
            $data["order_city"]  = $_POST['order_city'];
            $data["order_id"]  = $_POST['order_id'];
            $data["order_house_address"]  = $_POST['order_house_address'];
            $data["order_pay_type"] = $_POST['order_pay_type'];
            $data["order_pay_price"] = $_POST['order_pay_price'];
            $data["order_remarks"] = $_POST['order_remarks'];
            $data["order_show_time"] = $_POST['order_show_time'];
            $data["order_price"] = $_POST['order_price'];
            $data['order_service_id'] = $b_id;
            $data["order_paytime"] = $_POST['order_paytime'];
            $data['order_addtime'] = date('Y-m-d');
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
            $city = Db::table('crm_city')->select();
            $this->assign('city',$city);
            $this->assign('step',$orderStep);
            return $this->fetch();
        }
    }


    /***
     *Names:看房订单修改
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     *Created by Dang Mengmeng at 2019/11/19 15:38
     */
    public function edit1(){
        $b_id = session('ad_bid');
        $crm_id = intval(trim($this->request->param('crm_id')));
        if($_POST){
            $order_step  = $_POST['order_step'];
            $data["order_step"]  = $_POST['order_step'];
            $data["order_city"]  = $_POST['order_city'];
            $data["order_id"]  = $_POST['order_id'];
            $data["order_house_address"]  = $_POST['order_house_address'];
            $data["order_pay_type"] = $_POST['order_pay_type'];
            $data["order_pay_price"] = $_POST['order_pay_price'];
            $data["order_remarks"] = $_POST['order_remarks'];
            $data["order_show_time"] = $_POST['order_show_time'];
            $data["order_price"] = isset($_POST['order_price']) ?$_POST['order_price'] : '';
            $data['order_service_id'] = $b_id;
            $data["order_type"]  = $_POST['order_type'];
            $data["order_house_url"] = $_POST['order_house_url'];
            $editBan = Db::table('crm_order')->where(['crm_id' =>$crm_id])->update($data);
            if($editBan){
                $this->success('修改成功！','order');
            }else{
                $this->error('您未做任何修改！','order');
            }
        }else{
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
    }


    /***
     *Names:领钥匙订单修改方法
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     *Created by Dang Mengmeng at 2019/11/19 15:39
     */
    public function edit2(){
        $b_id = session('ad_bid');
        $crm_id = intval(trim($this->request->param('crm_id')));
        if($_POST){
            $order_step  = $_POST['order_step'];
            $data["order_step"]  = $_POST['order_step'];
            $data["order_city"]  = $_POST['order_city'];
            $data["order_id"]  = $_POST['order_id'];
            $data["order_house_address"]  = $_POST['order_house_address'];
            $data["order_pay_type"] = $_POST['order_pay_type'];
            $data["order_pay_price"] = $_POST['order_pay_price'];
            $data["order_remarks"] = $_POST['order_remarks'];
            $data["order_show_time"] = $_POST['order_show_time'];
            $data["order_price"] = isset($_POST['order_price']) ?$_POST['order_price'] : '';
            $data['order_service_id'] = $b_id;
            $data["other_docs"] = $_POST['other_docs'];
            $editBan = Db::table('crm_order')->where(['crm_id' =>$crm_id])->update($data);
            if($editBan){
                $this->success('修改成功！','order');
            }else{
                $this->error('您未做任何修改！','order');
            }
        }else{
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


    /***
     *Names:水电气网订单修改方法
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     *Created by Dang Mengmeng at 2019/11/19 15:39
     */
    public function edit3(){
        $b_id = session('ad_bid');
        $crm_id = intval(trim($this->request->param('crm_id')));
        if($_POST){
            $order_step  = $_POST['order_step'];
            $data["order_step"]  = $_POST['order_step'];
            $data["order_city"]  = $_POST['order_city'];
            $data["order_id"]  = $_POST['order_id'];
            $data["order_house_address"]  = $_POST['order_house_address'];
            $data["order_pay_type"] = $_POST['order_pay_type'];
            $data["order_pay_price"] = $_POST['order_pay_price'];
            $data["order_remarks"] = $_POST['order_remarks'];
            $data["order_show_time"] = $_POST['order_show_time'];
            $data["order_price"] = isset($_POST['order_price']) ?$_POST['order_price'] : '';
            $data['order_service_id'] = $b_id;
            $data["order_paytime"] = $_POST['order_paytime'];
            $editBan = Db::table('crm_order')->where(['crm_id' =>$crm_id])->update($data);
            $subOrder = $_POST['sub'];
            Db::table('crm_sub_order')->where(['so_order_id' => $crm_id])->delete();
            foreach($subOrder as $key => $val){
                $sub['so_order_id'] = $crm_id;
                $sub['so_sub_type'] = $key;
                Db::table('crm_sub_order')->insert($sub);
            }
            $this->success('修改成功！','order');
        }else{
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
    }

    public function edit4(){
        $b_id = session('ad_bid');
        $crm_id = intval(trim($this->request->param('crm_id')));
        if($_POST){
            $data["other_docs"]  = $_POST['other_docs'];
            $data["order_house_url"] = $_POST['order_house_url'];
            $data["order_pay_price"] = $_POST['order_pay_price'];
            $data["order_pay_type"] = $_POST['order_pay_type'];
            $data["order_remarks"] = $_POST['order_remarks'];
            $data["order_paytime"] = $_POST['order_paytime'];
            $data["order_price"] = $_POST['order_price'];
            $data["order_city"] = $_POST['order_city'];
            $data['order_service_id'] = $b_id;
            $editBan = Db::table('crm_order')->where(['crm_id' =>$crm_id])->update($data);
            if($editBan){
                $this->success('修改成功！','order');
            }else{
                $this->error('您未做任何修改！','order');
            }
        }else{
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
    public function updoc1(){
        $crm_id = intval(trim($this->request->param('crm_id')));
        $type = intval(trim($this->request->param('type','0','intval')));
        $order=Db::table('crm_order_logs')
            ->join('crm_order','crm_order.crm_id = crm_order_logs.ol_order_id','left')
            ->where(['crm_id' => $crm_id])
            ->find();
        if($_POST){
            if($order['order_step'] == 3){
                if (isset($_POST['elect']) && !empty($_POST['elect'])){
                    $upSubElect = Db::table('crm_sub_order')
                        ->where(['so_id' => $_POST['elect']])
                        ->update(['so_sub_cp_id' => $_POST['elect_value']]);
                }
                if (isset($_POST['gas']) && !empty($_POST['gas'])){
                    $upSubGas = Db::table('crm_sub_order')
                        ->where(['so_id' => $_POST['gas']])
                        ->update(['so_sub_cp_id' => $_POST['gas_value']]);
                }
                if (isset($_POST['nets']) && !empty($_POST['nets'])){
                    $upSubNet = Db::table('crm_sub_order')
                        ->where(['so_id' => $_POST['nets']])
                        ->update(['so_sub_cp_id' => $_POST['nets_value']]);
                }
            }
            $updates = Db::table('crm_order')->where(['crm_id' => $crm_id])->update(['order_remarks' => $_POST['order_remarks']]);
            if($updates || $upSubElect ||$upSubGas || $upSubNet){
                $this->success('上传成功！','orderlog');
            }else{
                $this->error('修改失败！','orderlog');
            }

        }else{
            $common = new Commons();
            $order['order_type'] = $order['order_type'] ? $common->getOrderType($order['order_type']) :'--';
            $order['orderStep'] = $common->getOrderStepById($order['order_step']);
            if($order['order_step'] == 3){
                $order['sub'] = $common->getSubOrder($order['crm_id']);
                $elect = $common->energyCmp(2);
                $gas = $common->energyCmp(2);
                $nets = $common->energyCmp(4);
                $this->assign('elect',$elect);
                $this->assign('gas',$gas);
                $this->assign('nets',$nets);
            }
            $this->assign('order',$order);
            return $this->fetch();
        }

    }
}