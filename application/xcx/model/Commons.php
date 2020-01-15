<?php
namespace app\xcx\model;
use think\Db;
use think\Model;

class Commons extends Model
{


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
}