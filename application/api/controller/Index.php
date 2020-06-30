<?php
namespace app\api\controller;
use app\xcx\model\Housem;
use think\Controller;
use think\Db;

class Index extends Controller
{

    public function house(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $housem = new Housem();
        $city = trim($this->request->param('city','墨尔本'));
        $where = ['tj' => '是','status' =>1,'city' => $city];
        $filed = 'id,title,type,house_room,area,images,price,furniture,home,school,address,tags';
        $house = $housem->readData($where,'mdate desc','12','0',$filed);
        if($house){
            foreach ($house as $k => $v){
//                $house[$k]['title'] = $v['type'].''.$v['house_room'].''.$v['area'];
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $house;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $house;
        return json($res);
    }


    /***
     * 根据经纬度查找城市信息
     * @return \think\response\Json
     */
    public function getCity(){
        $x = trim($this->request->param('x'));
        $y = trim($this->request->param('y'));
        file_put_contents('get_city.txt', date('Y-m-d H:i:s').'经度：' . $y . '纬度：' . $x .PHP_EOL, FILE_APPEND);
        if ($x == '') {
            $res['code'] = 0;
            $res['msg'] = '纬度不能为空！';
            return json($res);
        }
        if ($y == '') {
            $res['code'] = 0;
            $res['msg'] = '经度不能为空！';
            return json($res);
        }
        $url = "https://apis.map.qq.com/ws/geocoder/v1/?location={$x},{$y}&get_poi=1&key=OB5BZ-DEO6S-TQOOY-6JYID-Y2FL6-CVFPN";
        $res = file_get_contents($url);
        $res = json_decode($res, true);
        if ($res['status'] == 0) {
            if (@$res['result']['address_component']['nation'] =='澳大利亚') {
                if(@$res['result']['address_component']['ad_level_1'] == '塔斯马尼亚'){
                    $row = @$res['result']['address_component']['ad_level_1'];
                }else{
                    $row = @$res['result']['address_component']['ad_level_2'];
                }
            } else {
                $row = @$res['result']['address_component']['city'];
            }
            if (!@$row) {
                $city = Db::table('tk_cate')->where('pid', 0)->order('id DESC')->value('name');
            } else {
                $condition['name'] = ['like', "%{$row}%"];
                $condition['pid'] = 0;
                $city  = Db::table('tk_cate')->where($condition)->value('name');
                if (!@$city) {
                    $city = Db::table('tk_cate')->where('pid', 0)->order('id ASC')->value('name');
                }
            }

            $ress['code'] = 1;
            $ress['msg'] = 'ok！';
            $ress['data'] = @$city;
            return json($ress);
        }
        $ress['code'] = 0;
        $ress['msg'] = '获取失败！';
        $ress['data'] = $res;
        return json($ress);
    }

    public function getAdd(){
        $x = trim($this->request->param('x','-37.909093'));
        $y = trim($this->request->param('y','145.120366'));
        if($x == ''){
            $res['code'] = 0;
            $res['msg'] = '纬度不能为空！';
            return json($res);
        }
        if ($y == '') {
            $res['code'] = 0;
            $res['msg'] = '经度不能为空！';
            return json($res);
        }
        $Url ="https://reverse.geocoder.ls.hereapi.com/6.2/reversegeocode.json?prox={$x}%2C{$y}%2C100&mode=retrieveAddresses&maxresults=1&gen=9&apiKey=WgZd-Ykul-3XNV5agUgW2vMohtzAlYEA64GIQvcrfaw";
        $res = file_get_contents($Url);
        $ress = json_decode($res, true);
        $address = $ress['Response']['View'][0]['Result'][0]['Location']['Address']['Label'];
        if ($address) {
            $data['code'] = 1;
            $data['msg'] = 'ok！';
            $data['data'] = $address;
            return json($data);
        }else{
            $ress['code'] = 0;
            $ress['msg'] = '获取失败！';
            $ress['data'] = null;
            return json($ress);
        }
    }
    public function active(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $email = $this->request->get('email');
        $isExit = Db::table('super_admin')->where(['ad_email' => $email])->field('ad_isable')->find();
        if(!$isExit){
            $this->error('无此账户！','https://huaxiangxiaobao.com/');
        }
        if($isExit['ad_isable'] == 1){
            $this->success('恭喜您已成功激活，请点击“Agent Login”登录系统','https://huaxiangxiaobao.com/');
        }
        $active = Db::table('super_admin')->where(['ad_email' => $email])->update(['ad_isable'=>1]);
        if($active){
            $this->success('恭喜您已成功激活，请点击“Agent Login”登录系统','https://huaxiangxiaobao.com/');
        }else{
            $this->error('激活失败！','https://huaxiangxiaobao.com/');
        }
    }

}