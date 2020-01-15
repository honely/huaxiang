<?php
/**
 *Author:DangMengmeng
 *Dates:2019/10/31
 *Times:17:13
 */
namespace app\admin\controller;
use app\admin\model\Commons;
use think\Controller;
use PHPExcel_IOFactory;
use PHPExcel;
use think\Db;
class Export extends Controller{

    public function index()
    {
        return view();
    }

    public function out()
    {
        $path = dirname(__FILE__);
        vendor("PHPExcel.PHPExcel");
        vendor("PHPExcel.PHPExcel.Writer.Excel5");
        vendor("PHPExcel.PHPExcel.Writer.Excel2007");
        vendor("PHPExcel.PHPExcel.IOFactory");
        $objPHPExcel = new PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $keywords = trim($this->request->param('keywords'));
        $city = intval(trim($this->request->param('city')));
        $step = intval(trim($this->request->param('step')));
        $live_time = trim($this->request->param('live_time'));
        $where ='1 = 1';
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
        $sql = db('crm_order')
            ->where('order_status = 3 or order_status = 4')
            ->where($where)
            ->select();
        $common = new Commons();
        if($sql){
            foreach($sql as $k => $v){
                if(!empty($v['crm_user_admin']) && is_int($v['crm_user_admin'])){
                    $adInfo=Db::table('super_admin')
                        ->where(['ad_id' => $v['crm_user_admin']])
                        ->field('ad_id,ad_realname')->find();
                    $adName = $adInfo['ad_realname'];
                }else{
                    $adName="---";
                }
                $sql[$k]['crm_user_admin']= $adName;
                if(!empty($v['order_city'])){
                    $adInfo=Db::table('crm_city')
                        ->where(['crm_c_id' => $v['order_city']])
                        ->find();
                    $city = $adInfo['crm_city'];
                }else{
                    $city="---";
                }
                $sql[$k]['order_city']= $city;
                $sql[$k]['inspector'] = $common->getInspectorName($v['crm_id']);
                $sql[$k]['order_type']= $common->getOrderType($v['order_type']);
                $sql[$k]['order_pay_type']= $common->getPayType($v['order_pay_type']);
                $sql[$k]['order_status']= $common->getOrderStatus($v['order_status']);
                $sql[$k]['order_step']= $common->getOrderStepById($v['order_step']);
            }
        }

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '订单编号')
            ->setCellValue('B1', '任务类型')
            ->setCellValue('C1', '创单人')
            ->setCellValue('D1', '看房员')
            ->setCellValue('E1', '任务状态')
            ->setCellValue('F1', '看房时间')
            ->setCellValue('G1', '看房地区')
            ->setCellValue('H1', '房源地址')
            ->setCellValue('I1', '房源链接')
            ->setCellValue('J1', '结算金额')
            ->setCellValue('K1', '订单类型');
        $count = count($sql); //计算有多少条数据
        for ($i = 2; $i <= $count + 1; $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sql[$i - 2]['order_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $sql[$i - 2]['order_type']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $sql[$i - 2]['order_service_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $sql[$i - 2]['inspector']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $sql[$i - 2]['order_status']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $sql[$i - 2]['order_show_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $sql[$i - 2]['order_city']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $sql[$i - 2]['order_house_address']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $sql[$i - 2]['order_house_url']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $sql[$i - 2]['order_price']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $sql[$i - 2]['order_step']);
        }
        /*--------------下面是设置其他信息------------------*/

        $objPHPExcel->getActiveSheet()->settitle('工资结算单'); //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0); //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); //通过PHPExcel_IOFactory的写函数将上面数据写出来
        $PHPWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        header('Content-Disposition: attachment;filename="工资结算单.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
    }


    /***
     *Names:水电气网子订单结算方法
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/11/20 15:57
     */
    public function out1()
    {
        $path = dirname(__FILE__);
        vendor("PHPExcel.PHPExcel");
        vendor("PHPExcel.PHPExcel.Writer.Excel5");
        vendor("PHPExcel.PHPExcel.Writer.Excel2007");
        vendor("PHPExcel.PHPExcel.IOFactory");
        $objPHPExcel = new PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $keywords = trim($this->request->param('keywords'));
        $city = intval(trim($this->request->param('city')));
        $company = trim($this->request->param('company'));
        $so_sub_cp_id = intval(trim($this->request->param('so_sub_cp_id')));
        $live_time = trim($this->request->param('live_time'));
        $where ='1 = 1';
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( order_id = '".$keywords."' )";
        }
        if(isset($city) && !empty($city) && $city){
            $where.=" and order_city = ".$city;
        }
        if(isset($so_sub_cp_id) && !empty($so_sub_cp_id) && $so_sub_cp_id){
            $where.=" and so_sub_cp_id = ".$so_sub_cp_id;
        }
        if(isset($company) && !empty($company) && $company){
            $where.=" and eg_company = '".$company."'";
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=substr($live_time,'0','10')." 00:00:00";
            $edate=substr($live_time,'-10')." 23:59:59";
            $where.=" and ( order_show_time >= '".$sdate."' and order_show_time <= '".$edate."' ) ";
        }
        $sql = Db::table('crm_sub_order')
            ->join('crm_energy','crm_sub_order.so_sub_cp_id = crm_energy.eg_id')
            ->join('crm_order','crm_sub_order.so_order_id = crm_order.crm_id')
            ->where(['order_status' => 3,'so_status' => 1 ,'order_step' => 3])
            ->where($where)
            ->field('crm_sub_order.*,crm_order.*,crm_energy.eg_company')
            ->order(['order_show_time' => 'asc'])
            ->select();

        $common = new Commons();
        if($sql){
            foreach($sql as $k => $v){
                if(!empty($v['crm_user_admin']) && is_int($v['crm_user_admin'])){
                    $adInfo=Db::table('super_admin')
                        ->where(['ad_id' => $v['crm_user_admin']])
                        ->field('ad_id,ad_realname')->find();
                    $adName = $adInfo['ad_realname'];
                }else{
                    $adName="---";
                }
                $sql[$k]['crm_user_admin']= $adName;
                if(!empty($v['order_city'])){
                    $adInfo=Db::table('crm_city')
                        ->where(['crm_c_id' => $v['order_city']])
                        ->find();
                    $city = $adInfo['crm_city'];
                }else{
                    $city="---";
                }
                $sql[$k]['order_city']= $city;
                $sql[$k]['inspector'] = $common->getInspectorName($v['crm_id']);
                $sql[$k]['order_pay_type']= $common->getPayType($v['order_pay_type']);
                $sql[$k]['soStatus']= $common->getBalanceStatus($v['so_status']);
                $sql[$k]['orderStep']= $common->getOrderStepById($v['order_step']);
                $sql[$k]['energyName']= $common->getEnergyName($v['so_sub_type']);
                $sql[$k]['energyComp']= $common->getEnergyCom($v['so_sub_cp_id']);
            }
        }

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '订单编号')
            ->setCellValue('B1', '订单类型')
            ->setCellValue('C1', '创单人')
            ->setCellValue('D1', '开通能源')
            ->setCellValue('E1', '能源公司')
            ->setCellValue('F1', '开通专员')
            ->setCellValue('G1', '截止时间')
            ->setCellValue('H1', '看房地区')
            ->setCellValue('I1', '房源地址')
            ->setCellValue('J1', '佣金金额')
            ->setCellValue('K1', '是否结算');
        $count = count($sql); //计算有多少条数据
        for ($i = 2; $i <= $count + 1; $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sql[$i - 2]['order_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $sql[$i - 2]['orderStep']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $sql[$i - 2]['order_service_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $sql[$i - 2]['energyName']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $sql[$i - 2]['energyComp']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $sql[$i - 2]['inspector']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $sql[$i - 2]['order_show_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $sql[$i - 2]['order_city']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $sql[$i - 2]['order_house_address']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, 0);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $sql[$i - 2]['soStatus']);
        }
        /*--------------下面是设置其他信息------------------*/

        $objPHPExcel->getActiveSheet()->settitle('能源公司结算单'); //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0); //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); //通过PHPExcel_IOFactory的写函数将上面数据写出来
        $PHPWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        header('Content-Disposition: attachment;filename="能源公司结算单.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
    }


    /***
     * 清洁检查订单导出
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 2019年11月29日 10点03分 dangmengmeng
     */
    public function logout(){
        $path = dirname(__FILE__);
        vendor("PHPExcel.PHPExcel");
        vendor("PHPExcel.PHPExcel.Writer.Excel5");
        vendor("PHPExcel.PHPExcel.Writer.Excel2007");
        vendor("PHPExcel.PHPExcel.IOFactory");
        $objPHPExcel = new PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $keywords = trim($this->request->param('keywords'));
        $status = intval(trim($this->request->param('status')));
        $live_time = trim($this->request->param('live_time'));
        $where ='1 = 1';
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( cc_order_id = '".$keywords."' )";
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=substr($live_time,'0','10');
            $edate=substr($live_time,'-10');
            $where.=" and ( cc_pay_time >= '".$sdate."' and cc_pay_time <= '".$edate."' ) ";
        }
        $sql=Db::table('crm_clean')
            ->join('crm_clean_log','crm_clean_log.cl_cid = crm_clean.cc_id')
            ->where($where)
            ->where(['cl_status' => 1])
            ->order(['cc_addtime' => 'desc'])
            ->group('cc_id')
            ->select();
        $common = new Commons();
        if($sql){
            foreach($sql as $k => $v){
                $sql[$k]['cc_price'] = $v['cc_pay_type'] == 1 ? $v['cc_price'].'（人民币）' : $v['cc_price'].'（澳币）' ;
                $sql[$k]['cc_pay_type'] = $common->getPayType($v['cc_pay_type']);
                $cleanLog = Db::table('crm_clean_log')
                    //已退款的
                    ->where(['cl_cid' => $v['cc_id'],'cl_status' => 1])
                    ->order(['cl_date' => 'asc'])
                    ->select();
                foreach ($cleanLog as $key => $val){
                    $cleanLog[$key]['cl_status'] = $common->getCleanStatus($val['cl_status']);
                }
                for ($j = 0;$j<count($cleanLog);$j++){
                    $sql[$k]['refund'.($j+1)] = $cleanLog[$j]['cl_date'];
                    $sql[$k]['status'.($j+1)] = $cleanLog[$j]['cl_status'];
                }
            }
        }
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', '收款时间')
            ->setCellValue('C1', '客户姓名')
            ->setCellValue('D1', '订单编号')
            ->setCellValue('E1', '收取押金金额')
            ->setCellValue('F1', '付款方式')
            ->setCellValue('G1', '付款id')
            ->setCellValue('H1', '租期')
            ->setCellValue('I1', '房型户型')
            ->setCellValue('J1', '第一次退款日期')
            ->setCellValue('K1', '退款金额($)')
            ->setCellValue('L1', '是否通过')
            ->setCellValue('M1', '第二次退款日期')
            ->setCellValue('N1', '退款金额($)')
            ->setCellValue('O1', '是否通过')
            ->setCellValue('P1', '第三次退款日期')
            ->setCellValue('Q1', '退款金额($)')
            ->setCellValue('R1', '是否通过')
            ->setCellValue('S1', '售后')
            ->setCellValue('T1', '订单状态');
        $count = count($sql); //计算有多少条数据
        for ($i = 2; $i <= $count + 1; $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sql[$i - 2]['cc_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $sql[$i - 2]['cc_pay_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $sql[$i - 2]['cc_user_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $sql[$i - 2]['cc_order_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $sql[$i - 2]['cc_price']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $sql[$i - 2]['cc_pay_type']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $sql[$i - 2]['cc_pay_id']);

            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $sql[$i - 2]['cc_rent_term'].'个月');
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $sql[$i - 2]['cc_house_type'].''.$sql[$i - 2]['cc_room_type']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, isset($sql[$i - 2]['refund1']) ? $sql[$i - 2]['refund1'] : '');
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, isset($sql[$i - 2]['refund1']) ? $sql[$i - 2]['cc_refund'] : '');
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, isset($sql[$i - 2]['refund1']) ? $sql[$i - 2]['status1'] : '');
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, isset($sql[$i - 2]['refund2']) ? $sql[$i - 2]['refund2'] : '');
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, isset($sql[$i - 2]['refund2']) ? $sql[$i - 2]['cc_refund'] : '');
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, isset($sql[$i - 2]['refund2']) ? $sql[$i - 2]['status2'] : '');
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, isset($sql[$i - 2]['refund3']) ? $sql[$i - 2]['refund3'] : '');
            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, isset($sql[$i - 2]['refund3']) ? $sql[$i - 2]['cc_refund'] : '');
            $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, isset($sql[$i - 2]['refund3']) ? $sql[$i - 2]['status3'] : '');
            $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $sql[$i - 2]['cc_admin']);
            $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '');
        }
        /*--------------下面是设置其他信息------------------*/

        $objPHPExcel->getActiveSheet()->settitle('清洁检查单'); //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0); //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); //通过PHPExcel_IOFactory的写函数将上面数据写出来
        $PHPWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        header('Content-Disposition: attachment;filename="清洁检查单.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
    }





    public function user(){
        $path = dirname(__FILE__);
        vendor("PHPExcel.PHPExcel");
        vendor("PHPExcel.PHPExcel.Writer.Excel5");
        vendor("PHPExcel.PHPExcel.Writer.Excel2007");
        vendor("PHPExcel.PHPExcel.IOFactory");
        $objPHPExcel = new PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $keywords = trim($this->request->param('keywords'));
        $status = intval(trim($this->request->param('status')));
        $service = intval(trim($this->request->param('service')));
        $live_time=$this->request->param('live_time');
        $where ='1 = 1';
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( crm_wechat = '".$keywords."' or crm_user_bid = '".$keywords."' or crm_remarks like '%".$keywords."%')";
        }
        if(isset($status) && !empty($status) && $status){
            $where.=" and crm_user_status = ".$status;
        }
        if(isset($service) && !empty($service) && $service){
            $where.=" and crm_service_type = ".$service;
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=strtotime(substr($live_time,'0','10')." 00:00:00");
            $edate=strtotime(substr($live_time,'-10')." 23:59:59");
            $where.=" and ( crm_user_addtime >= ".$sdate." and crm_user_addtime <= ".$edate." ) ";
        }
//        dump($where);exit;
        $cusInfo=Db::table('crm_user')
            ->where($where)
            ->order('crm_user_id desc')
            ->select();
        $common = new Commons();
        if($cusInfo){
            foreach($cusInfo as $k => $v){
                if(!empty($v['crm_user_admin']) && is_int($v['crm_user_admin'])){
                    $adInfo=Db::table('super_admin')
                        ->where(['ad_id' => $v['crm_user_admin']])
                        ->field('ad_id,ad_realname,ad_role')->find();
                    $adName = $adInfo['ad_realname'];
                }else{
                    $adName="---";
                    $adRole = 0;
                }
                $cusInfo[$k]['crm_user_admin']= $adName;
                if(!empty($v['crm_city']) && is_int($v['crm_city'])){
                    $adInfo=Db::table('crm_city')
                        ->where(['crm_c_id' => $v['crm_city']])
                        ->find();
                    $city = $adInfo['crm_city'];
                }else{
                    $city="---";
                }
                $cusInfo[$k]['crm_city']= $city;

                if(!empty($v['crm_service_type']) && is_int($v['crm_service_type'])){
                    $adInfo=Db::table('crm_service')
                        ->where(['crm_s_id' => $v['crm_service_type']])
                        ->find();
                    $service = $adInfo['crm_type'];
                }else{
                    $service="---";
                }
                $cusInfo[$k]['crm_service_type']= $service;

                if(!empty($v['crm_user_status']) && is_int($v['crm_user_status'])){
                    $adInfo = Db::table('crm_user_status')
                        ->where(['id' => $v['crm_user_status'],'is_able' => 1])
                        ->find();
                    $status = $adInfo['status_name'];
                }else{
                    $status="---";
                }
                $cusInfo[$k]['crm_sex']= $this->userSex($v['crm_sex']);
                $cusInfo[$k]['crm_house_type']= $this->houseType($v['crm_house_type']);
                $cusInfo[$k]['crm_room_type']= $this->houseType($v['crm_room_type']);
                $cusInfo[$k]['crm_is_star']= $v['crm_is_star'] == 1 ? '是' : '否';
                $cusInfo[$k]['crm_car_site']= $v['crm_car_site'] == 1 ? '是' : '否';
                $cusInfo[$k]['crm_user_status']= $status;
                $cusInfo[$k]['crm_live_time']= date('Y-m-d H:i:s',$v['crm_live_time']);
                $cusInfo[$k]['crm_user_addtime']= date('Y-m-d H:i:s',$v['crm_user_addtime']);
                $day1 = date('Y-m-d',$v['crm_user_addtime']);
                $day2 = substr($v['crm_order_time'],'0','10');
                $cusInfo[$k]['crm_order_circle']= $v['crm_order_time'] == '0000-00-00 00:00:00' ? "---" : $common->diffBetweenTwoDays($day1,$day2).'天';
            }
        }
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', '客户编号')
            ->setCellValue('C1', '所在城市')
            ->setCellValue('D1', '客户微信')
            ->setCellValue('E1', '联系电话')
            ->setCellValue('F1', '入住时间')
            ->setCellValue('G1', '服务类别')
            ->setCellValue('H1', '客户类型')
            ->setCellValue('I1', '负责人')
            ->setCellValue('J1', '客户来源')
            ->setCellValue('K1', '租房区域')
            ->setCellValue('L1', '性别')
            ->setCellValue('M1', '生日')
            ->setCellValue('N1', '房源类型')
            ->setCellValue('O1', '基本需求')
            ->setCellValue('P1', '价格区间')
            ->setCellValue('Q1', '是否车位')
            ->setCellValue('R1', '是否星标')
            ->setCellValue('S1', '精细需求')
            ->setCellValue('T1', '创建时间')
            ->setCellValue('U1', '下单时间')
            ->setCellValue('V1', '成单周期');
        $sql = $cusInfo;
        $count = count($sql); //计算有多少条数据
        for ($i = 2; $i <= $count + 1; $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sql[$i - 2]['crm_user_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $sql[$i - 2]['crm_user_bid']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $sql[$i - 2]['crm_city']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $sql[$i - 2]['crm_wechat']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $sql[$i - 2]['crm_phone']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $sql[$i - 2]['crm_live_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $sql[$i - 2]['crm_service_type']);

            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $sql[$i - 2]['crm_user_status']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $sql[$i - 2]['crm_user_admin']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $sql[$i - 2]['crm_user_from']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $sql[$i - 2]['crm_school']);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $sql[$i - 2]['crm_sex']);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $sql[$i - 2]['crm_birthday']);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $sql[$i - 2]['crm_house_type']);
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $sql[$i - 2]['crm_room_type']);
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $sql[$i - 2]['crm_price_min'].'~'.$sql[$i - 2]['crm_price_max']);
            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $sql[$i - 2]['crm_car_site']);
            $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $sql[$i - 2]['crm_is_star']);
            $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $sql[$i - 2]['crm_need']);
            $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $sql[$i - 2]['crm_user_addtime']);
            $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $sql[$i - 2]['crm_order_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $sql[$i - 2]['crm_order_circle']);
        }
        /*--------------下面是设置其他信息------------------*/

        $objPHPExcel->getActiveSheet()->settitle('客户列表'); //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0); //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); //通过PHPExcel_IOFactory的写函数将上面数据写出来
        $PHPWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        header('Content-Disposition: attachment;filename="客户列表.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
    }

    public function userSex($sex){
        switch ($sex)
        {
            case 1:
                $type = '男';
                break;
            case 2:
                $type = '女';
                break;
            case 3:
                $type = '未知';
                break;
            default:
                $type = '---';
        }
        return $type;
    }

    public function houseType($type){
        $adminName = Db::table('crm_house_type')->where(['ht_id' => $type])->find();
        return $adminName['ht_name'];
    }




    public function light(){
        $path = dirname(__FILE__);
        vendor("PHPExcel.PHPExcel");
        vendor("PHPExcel.PHPExcel.Writer.Excel5");
        vendor("PHPExcel.PHPExcel.Writer.Excel2007");
        vendor("PHPExcel.PHPExcel.IOFactory");
        $objPHPExcel = new PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $keywords = trim($this->request->param('keywords'));
        $live_time=$this->request->param('live_time');
        $step = $this->request->param('step');
        $cl_order_type = intval(trim($this->request->param('cl_order_type')));
        $cl_cl_admin = intval(trim($this->request->param('cl_cl_admin')));
        $where ='1 = 1';
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and (cl_order_id like '%".$keywords."%')";
        }
        if(isset($step) && !empty($step) && $step){
            $where.=" and cl_order_type = ".$step;
        }
        if(isset($cl_order_type) && !empty($cl_order_type) && $cl_order_type){
            $where.=" and cl_order_status = ".$cl_order_type;
        }
        if(isset($cl_cl_admin) && !empty($cl_cl_admin) && $cl_cl_admin){
            $where.=" and cl_cl_admin = ".$cl_cl_admin;
        }
        if(isset($live_time) && !empty($live_time)){
            $sdate=substr($live_time,'0','10');
            $edate=substr($live_time,'-10');
            $where.=" and ( cl_add_time >= '".$sdate."' and cl_add_time <= '".$edate."' ) ";
        }
        $cusInfo=Db::table('crm_light')
            ->where($where)
            ->order('cl_start_time desc')
            ->select();
        $common = new Commons();
        if($cusInfo){
            foreach ($cusInfo as $k => $v){
                $cusInfo[$k]['cl_price'] = $v['cl_pay_type'] == 1 ? $v['cl_price'].'（人民币）' : $v['cl_price'].'（澳币）' ;
                $cusInfo[$k]['cl_pay_type'] = $common->getPayType($v['cl_pay_type']);
                $cusInfo[$k]['cl_order_type'] = $common->lightOrderStep($v['cl_order_type']);
                $cusInfo[$k]['cl_orderStatus'] = $common->getClOrderStatus($v['cl_order_status']);
                $cusInfo[$k]['cl_need_confirm'] = $v['cl_need_confirm'] == 1 ? '是' : '否';
                $cusInfo[$k]['cl_cl_agree_sign'] = $v['cl_cl_agree_sign'] == 1 ? '是' : '否';
                $cusInfo[$k]['cl_cl_delete'] = $v['cl_cl_delete'] == 1 ? '是' : '否';
                $cusInfo[$k]['cl_is_pay'] = $v['cl_is_pay'] == 1 ? '是' : '否';
                $cusInfo[$k]['cl_sl_is_check'] = $v['cl_sl_is_check'] == 1 ? '是' : '否';
                $cusInfo[$k]['cl_sl_good_com'] = $v['cl_sl_good_com'] == 1 ? '是' : '否';
                $cusInfo[$k]['cl_sl_is_review'] = $v['cl_sl_is_review'] == 1 ? '是' : '否';
                $cusInfo[$k]['cl_cl_admin'] = $common->getInspectorNames($v['cl_cl_admin']);
            }
        }
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', '订单编号')
            ->setCellValue('C1', '订单类型')
            ->setCellValue('D1', '客户id')
            ->setCellValue('E1', '付款方式')
            ->setCellValue('F1', '收款金额')
            ->setCellValue('G1', '付款时间')
            ->setCellValue('H1', '付款id')
            ->setCellValue('I1', '需求是否确认')
            ->setCellValue('J1', '订单状态')
            ->setCellValue('K1', '建单时间')
            ->setCellValue('L1', '售前')
            ->setCellValue('M1', '售前备注')
            ->setCellValue('N1', '推荐人微信')
            ->setCellValue('O1', '顾问')
            ->setCellValue('P1', '材料申请截止日期')
            ->setCellValue('Q1', '合同签约')
            ->setCellValue('R1', '删除资料')
            ->setCellValue('S1', '顾问接单时间')
            ->setCellValue('T1', '顾问转交时间')
            ->setCellValue('U1', '房源地址')
            ->setCellValue('V1', '中介名称')
            ->setCellValue('W1', '顾问备注')
            ->setCellValue('X1', '是否结算')
            ->setCellValue('Y1', '结算人员')
            ->setCellValue('Z1', '结算时间')
            ->setCellValue('AA1', '结算截止时间')
            ->setCellValue('AB1', '检查归档')
            ->setCellValue('AC1', '要好评')
            ->setCellValue('AD1', '是否回访')
            ->setCellValue('AE1', '售后备注')
            ->setCellValue('AF1', '售后');
        $sql = $cusInfo;
        $count = count($sql); //计算有多少条数据
        for ($i = 2; $i <= $count + 1; $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sql[$i - 2]['cl_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $sql[$i - 2]['cl_order_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $sql[$i - 2]['cl_order_type']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $sql[$i - 2]['cl_user_ids']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $sql[$i - 2]['cl_pay_type']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $sql[$i - 2]['cl_price']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $sql[$i - 2]['cl_pay_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $sql[$i - 2]['cl_pay_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $sql[$i - 2]['cl_need_confirm']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $sql[$i - 2]['cl_orderStatus']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $sql[$i - 2]['cl_start_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $sql[$i - 2]['cl_admin_sale']);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $sql[$i - 2]['cl_remarks']);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $sql[$i - 2]['cl_refer_ids']);
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $sql[$i - 2]['cl_cl_admin']);
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $sql[$i - 2]['cl_end_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $sql[$i - 2]['cl_cl_agree_sign']);
            $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $sql[$i - 2]['cl_cl_delete']);
            $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $sql[$i - 2]['cl_cl_acc_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $sql[$i - 2]['cl_to_sale_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $sql[$i - 2]['cl_cl_house_address']);
            $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $sql[$i - 2]['cl_cl_inter']);
            $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $sql[$i - 2]['cl_cl_remarks']);
            $objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $sql[$i - 2]['cl_is_pay']);
            $objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $sql[$i - 2]['cl_pay_admin']);
            $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $sql[$i - 2]['cl_fl_pay_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $sql[$i - 2]['cl_sl_deadline']);
            $objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $sql[$i - 2]['cl_sl_is_check']);
            $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, $sql[$i - 2]['cl_sl_good_com']);
            $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, $sql[$i - 2]['cl_sl_is_review']);
            $objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, $sql[$i - 2]['cl_sl_remarks']);
            $objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, $sql[$i - 2]['cl_sl_admin']);
        }
        /*--------------下面是设置其他信息------------------*/

        $objPHPExcel->getActiveSheet()->settitle('租房订单'); //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0); //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); //通过PHPExcel_IOFactory的写函数将上面数据写出来
        $PHPWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        header('Content-Disposition: attachment;filename="租房订单.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
    }

}
