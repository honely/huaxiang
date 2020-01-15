<?php
namespace app\admin\model;
use think\Db;
use think\Model;

class Commons extends Model
{

    /***
     *Names：获取订单类型
     * @return array
     *Created by Dang Mengmeng at 2019/11/11 15:25
     */
    public function orderStep(){
//        订单类型：1.看房，2领钥匙；3开通水电气；4闪电租房；5一站式
        $orderStep = [
            '1' => '看房',
            '2' => '领钥匙',
            '3' => '水电气网',
//            '4' => '闪电租房',
//            '5' => '一站式服务',
//            '6' => 'VIP定制',
        ];
        return $orderStep;
    }


    public function liOrderStatus(){
//        售前：2材料申请（顾问服务阶段）3待闭环；4.已闭环'
        $orderStatus = [
            '1' => '售前',
            '2' => '材料申请',
            '3' => '待闭环',
            '4' => '已闭环',
        ];
        return $orderStatus;
    }


    /***
     * 获取租房顾问
     * @return false|\PDOStatement|string|\think\Collection|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by Dangmengmeng At 2020/1/7 17:22
     */
    public function getGuwen(){
        //租房顾问：顾问角色加上售后主管角色
        $guwen = Db::table('super_admin')
            ->where('ad_role','in','35,39')
            ->where(['ad_isable' => 1])
            ->field('ad_id,ad_bid,ad_realname')
            ->select();
        return $guwen ? $guwen : null;
    }


    /***
     *Names:根据订单类型id获取订单类型名称方法
     * @param $typeId
     * @return string
     *Created by Dang Mengmeng at 2019/11/15 10:41
     */
    public function getOrderStepById($typeId){
        switch ($typeId)
        {
            case 1:
                $type = '看房';
                break;
            case 2:
                $type = '领钥匙';
                break;
            case 3:
                $type = '水电气网';
                break;
//            case 4:
//                $type = '闪电租房';
//                break;
//            case 5:
//                $type = '一站式服务';
//                break;
            case 6:
                $type = '代缴订金';
                break;
            default:
                $type = '---';
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
                $type = '---';
        }
        return $type;
    }


    /***
     * 获取闪电租房的订单状态
     * 订单状态：1售前：2材料申请（顾问服务阶段）3待闭环；4.已闭环
     * @param $status
     * @return string
     */
    public function getClOrderStatus($status){
        switch ($status)
        {
            case 1:
                $type = '售前';
                break;
            case 2:
                $type = '材料申请';
                break;
            case 3:
                $type = '售后';
                break;
            case 4:
                $type = '已完成';
                break;
            default:
                $type = '---';
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
            case 4:
                $type = '汇款';
                break;
            case 5:
                $type = '支票';
                break;
            default:
                $type = '---';
        }
        return $type;
    }


    /***
     * 检查结果：0. 还未检查  1通过；2未通过
     * @param $status
     * @return string
     */
    public function getCleanStatus($status){
        switch ($status)
        {
            case 1:
                $type = '已通过';
                break;
            case 2:
                $type = '未通过';
                break;
            case 3:
                $type = '未检查';
                break;
            default:
                $type = '---';
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
                $type = '---';
        }
        return $type;
    }

    /***
     *Names:根据管理员id获取管理员员工编号方法
     * @param $crmId
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/11/12 10:46
     */
    public function getInspectors($crmId){
        $adminName = Db::table('super_admin')->where(['ad_id' => $crmId])->find();
        return $adminName['ad_bid'];

    }

    public function getInspectorNames($crmId){
        $adminName = Db::table('super_admin')->where(['ad_id' => $crmId])->find();
        return $adminName['ad_realname'];

    }


    public function getOrderRefund($refund){
        if($refund == 0){
           return '无';
        }else{
            $refunds = Db::table('crm_refund')
                ->where(['cr_id' => $refund])
                ->find();
            return $refunds['cr_price'] ? $refunds['cr_price'] : '无';
        }
    }


    /***
     *Names:获取看房员工编号方法
     * @param $crmId
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/11/12 10:48
     */
    public function getInspectorName($crmId){
        $inst = Db::table('crm_order_logs')
            ->where(['ol_order_id' => $crmId,'ol_status' => 3])
            ->find();
        $insId = $inst['ol_inspector'];
        $adminName = Db::table('super_admin')->where(['ad_id' => $insId])->find();
        return $adminName['ad_bid'];

    }


    /***
     *Names:方法
     * @param $showTime
     * @return string
     * 已过的是红色，近24小时橙色，近48小时绿色，其他不变吧
     *Created by Dang Mengmeng at 2019/11/13 15:09
     */
    public function deadLineShowColor($showTime){
        $days = $this->getAusDays();
        switch ($showTime)
        {
            case $showTime < $days['nows']:
                $color = 'red';
                break;
            case $days['nows'] < $showTime &&  $showTime < $days['aDay']:
                $color = 'orange';
                break;
            case $days['aDay'] < $showTime &&  $showTime < $days['twoDays']:
                $color = 'green';
                break;
            default:
                $color = '---';
        }
        return $color;
    }

    public function getAusDays(){
        date_default_timezone_set("Australia/Melbourne");
        $days['aDay'] = date('Y-m-d H:i:s',strtotime('1 days'));
        $days['twoDays'] =date('Y-m-d H:i:s',strtotime('2 days'));
        $days['nows'] = date('Y-m-d H:i:s');
        return $days;
    }


    /***
     *Names:获取能源公司方法
     * @param $type
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/11/18 15:04
     */
    public function energyCmp($type){
        $energy = Db::table('crm_energy')
            ->where(['eg_type' => $type])
            ->select();
        return $energy;
    }


    public function getEnergyCom($comp_id){
        $energy = Db::table('crm_energy')
            ->where(['eg_id' => $comp_id])
            ->find();
        return $energy ? $energy['eg_company'] : '---';
    }


    /***
     *Names:获取水电气网子订单方法
     * @param $orderId
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/11/18 15:37
     */
    public function getSubOrder($orderId){
        $subOrder = Db::table('crm_sub_order')
            ->where(['so_order_id' => $orderId])
            ->select();
        return $subOrder;
    }


    /***
     *Names:获取能源名称方法
     * @param $typeId
     * @return string
     *Created by Dang Mengmeng at 2019/11/20 15:07
     */
    public function getEnergyName($typeId){
        switch ($typeId)
        {
            case 2:
                $type = '电';
                break;
            case 3:
                $type = '气/热水';
                break;
            case 4:
                $type = '网';
                break;
            default:
                $type = '---';
        }
        return $type;
    }


    /***
     *Names:水电气网子订单结算状态
     * @param $typeId
     * @return string
     *Created by Dang Mengmeng at 2019/11/20 15:44
     */
    public function getBalanceStatus($typeId){
        switch ($typeId)
        {
            case 1:
                $type = '未结算';
                break;
            case 2:
                $type = '已结算';
                break;
            default:
                $type = '---';
        }
        return $type;
    }


    /***
     * Notes:服务编码：看房A；代缴定金B；
     * 水电气网C；领钥匙D；材料准备E；
     * 家具家电F；接机J；
     * 清洁Q；行李寄存L；
     * @param $orderId
     * @param $type
     * Author: Created by Dang Mengmeng At 2019/12/11 12:09
     */


    /***
     * Notes:服务编码：1看房A；2代缴定金B；
     * 3水电气网C；4领钥匙D；5材料准备E；
     * 6家具家电F；7接机J；
     * 8清洁Q；9行李寄存L；
     * @param $orderId
     * @param $type
     * @return mixed|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Author: Created by Dang Mengmeng At 2019/12/11 12:14
     */
    public function orderBidCreateRole($orderId,$type){
        $light = Db::table('crm_light')
            ->where(['cl_id' => $orderId])
            ->field('cl_order_id')
            ->find();
        $orderBid = $light['cl_order_id'];
        switch ($type){
            case 1:
                $bid = 'A';
                break;
            case 2:
                $bid = 'B';
                break;
            case 3:
                $bid = 'C';
                break;
            case 4:
                $bid = 'D';
                break;
            case 5:
                $bid = 'E';
                break;
            case 6:
                $bid = 'F';
                break;
            case 7:
                $bid = 'J';
                break;
            case 8:
                $bid = 'Q';
                break;
            case 9:
                $bid = 'L';
                break;
        }
        $orderBid .= '-'.$bid;
        return $orderBid;
    }

    public function getHouseAdd($cl_id){
        $light = Db::table('crm_light')
            ->where(['cl_id' => $cl_id])
            ->field('cl_cl_house_address')
            ->find();
        return $light ? $light['cl_cl_house_address'] : '';
    }


    /***
     * Notes:
     * @param $adminId string 管理建单人id
     * @param $type int 订单类型  一站式1；闪电2；个人房源3；招租4；学生公寓9；
     * @return string
     * Author: Created by Dang Mengmeng At 2019/12/11 14:37
     */
    public function createOrderBid($adminId,$type){
        $orderBid = '';
        $stime = date('Y-m-d');
        $buNum=Db::table('crm_light')
            ->where(['cl_admin_sale' => $adminId,'cl_add_time' => $stime])
            ->count();
        switch ($type)
        {
//        服务编码：看房A；代缴定金B；水电气网C；领钥匙D；材料准备E；家具家电F；接机J；一站式1；闪电2；个人房源3；招租4；学生公寓9；清洁Q；行李寄存L；
            case 4:
                //4闪电租房
                $orderBid .= '2';
                break;
            case 5:
                //一站式
                $orderBid .= '1';
                break;
            case 6:
                //6单次闪电
                $orderBid .= '2';
                break;
            case 7:
                //学生公寓
                $orderBid .= '9';
                break;
            case 8:
                //个人房源
                $orderBid .= '3';
                break;
            default:
                $orderBid .= '---';
                $buNum = 0;
        }
        //029是工号后三位，
        $cusBid = substr($adminId,-3);
        $orderBid .= sprintf("%03d", $cusBid);
        //191127是19年11月27日，
        $date = substr(date('Ymd'),'2');
        $orderBid .=$date;
        //01是这个顾问的当天第一单
        $orderBid .=sprintf("%02d", $buNum+1);
        return $orderBid;

    }


    /***
     * @param $typeId
     * @return 4闪电租房；5一站式；6单次闪电；7学生公寓；8个人房源
     * Created by Dangmengmeng At 2019/12/25 15:20
     */
    public function lightOrderStep($typeId){
        switch ($typeId)
        {
            case 4:
                $type = '闪电租房';
                break;
            case 5:
                $type = '一站式';
                break;
            case 6:
                $type = '单次闪电';
                break;
            case 7:
                $type = '学生公寓';
                break;
            case 8:
                $type = '个人房源';
                break;
            default:
                $type = '---';
        }
        return $type;
    }

    public function getAdminBid($adminId){
        $adminInfo = Db::table('super_admin')->where(['ad_id' => $adminId])->field('ad_bid')->find();
        $adBid = substr($adminInfo['ad_bid'],-3);
        return $adBid;
    }


    /***
     * Notes:小程序生成带参数的二维码【小程序的圆形码】保存成jpg图片上传到服务器
     * @param $id
     * Author: Created by Dang Mengmeng At 2019/12/16 17:58
     */
    public function xcxCode($id) {
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $access_token;
        $data['scene'] = 'h' . $id;
        $data['path'] = 'pages/detail/detail';
        $data['width'] = '430';
        $res = $this->http($url, json_encode($data),1);
        $path = 'uploads/qrcode/h' . $id . '.jpg';
        file_put_contents($path, $res);
        $return['status_code'] = 2000;
        $return['msg'] = 'ok';
        $return['img'] = 'https://oa.huaxiangxiaobao.com/' . $path;
        return $return;
    }

    //post curl 请求参数
    function http($url, $data = NULL, $json = false)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if (!empty($data)) {
            if($json && is_array($data)){
                $data = json_encode( $data );
            }
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            if($json){ //发送JSON数据
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json; charset=utf-8',
                        'Content-Length:' . strlen($data))
                );
            }
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($curl);
        // var_dump($res);exit;
        $errorno = curl_errno($curl);

        if ($errorno) {
            return array('errorno' => false, 'errmsg' => $errorno);
        }
        curl_close($curl);
        return $res;
    }

    /***
     * 小程序生成带参数的二维码【方形码】保存成jpg图片上传到服务器
     * @return string
     */
    public function getXcxCode(){
        //获取accesstoken
        $ACCESS_TOKEN = $this->getAccessToken();
        $qcode ="https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$ACCESS_TOKEN;
        //小程序的页面路径
        $param = json_encode(array("path"=>"pages/detail/detail?id=5084","width"=> 150));
        $result = $this->httpRequest( $qcode, $param,"POST");
        //图片保存的绝对路径
        $path = 'uploads/qrcode/h.jpg';
        file_put_contents($path, $result);
        $return['status_code'] = 2000;
        $return['msg'] = 'ok';
        //图片读取的路径
        $return['img'] = 'https://oa.huaxiangxiaobao.com/' . $path;
        echo '<img src="'.$return['img'].'" />';exit;
        echo json_encode($return);exit;
    }


    function httpRequest($url, $data='', $method='GET'){

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);

        if($method=='POST')

        {

            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data != '')
            {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        curl_setopt($curl, CURLOPT_HEADER, 0);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;

    }
    public function getAccessToken(){
        $appid = 'wxbaff89f847b0f15f';
        $secret = '14b8b22ba3154f015a3e890613b2029b';
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
        $res = json_decode($this->httpGet($url));
        $access_token = @$res->access_token;
        return $access_token;
    }
    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }


    /***
     * Notes:计算两个日期之间的天数
     * @param $day1  string 较小的天数
     * @param $day2 string 较大的天数
     * @return float|int
     * Author: Created by Dang Mengmeng At 2019/12/19 15:05
     */
    public function diffBetweenTwoDays($day1,$day2)
    {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);

        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        return ($second1 - $second2) / 86400;
    }


    public function getOrderCount($step){
        $count = Db::table('crm_light')
                ->where(['cl_order_type' => $step])
                ->where('cl_order_status','between','2,3')
                ->field('cl_id')
                ->count();
        return $count ? $count :0;
    }

}