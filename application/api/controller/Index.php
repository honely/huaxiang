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
        $uid = trim($this->request->param('uid',59));
        $where = "status = 1 and is_del = 1 and tj = '是' and city = '".$city."'";
        $field = 'id,type,title,house_room,area,images,price,toilet,furniture,home,school,address,tj,top,mdate,cdate,tags,area,live_date,car,lease_term,video,is_admin,corp,pm,house_type,likes,loard_sex,loard_job,user_id,publish_date';
        $house = $housem->readData($where,'mdate desc','12','0',$field);
        if($house){
           //是否收藏
            $collects = $this->getCollects($uid);
            $likes = $this->getLikes($uid);
            foreach ($house as $k => $v){
                $colt = in_array($v['id'],$collects,true);
                $house[$k]['is_colt'] = $colt ? 1 : 0;
                $like = in_array($v['id'],$likes,true);
                $house[$k]['is_like'] = $like ? 1 : 0;
                $house[$k]['livedate'] = $this->liveDates($v['live_date']);
                $house[$k]['is_new'] = $this->newTags($v['cdate']);
                $house[$k]['tj'] = $v['tj'] == '是' ? '推荐房源'  : '';
                $house[$k]['tingwei'] = $this->formatRoom($v['house_room']).''.$this->formatToilet($v['toilet']);
                //如果是后端发布的房源，查询中介个人图像，公司名称中介logo
                $pmInfo = $this->getPmname($v['is_admin'],$v['pm'],$v['user_id']);
                $house[$k]['pm_name'] = $pmInfo['ad_realname'];
                $house[$k]['mdate'] = date('Y-m-d',strtotime($v['cdate']));
                $house[$k]['pm_avatar'] = $pmInfo['ad_img'];
                if($v['is_admin'] == 2){
                    $house[$k]['corplogo'] = $this->getCorpLogo($v['corp']);
                    $house[$k]['colour'] = $housem->getColour($v['corp']);
                }
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $house;
            $res['where'] = $where;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $house;
        return json($res);
    }

    public function newTags($cdate){
        //三天之内的房源都是新房源
        $cdate = strtotime($cdate.' +2 days');
        $now = time();
        return $cdate < $now? 0 :1;
    }
    
     public function liveDates($cdate){
        if($cdate == "0000-00-00" || $cdate == "0100-01-01"){
            return '随时入住';
        }else{
            $date = date('m月d日',strtotime($cdate));
             return $date."入住";
        }
    }
    
     public function formatRoom($room){
//        一室，两室，三室，三室以上
        switch ($room){
            case '三室以上':
                $room = '多室';
                break;
        }
        return $room;
    }
    public function formatToilet($toilet){
        switch ($toilet){
//        1个；2个；3个；3个以上
            case '1个':
                $room = '一卫';
                break;
            case '2个':
                $room = '两卫';
                break;
            case '3个':
                $room = '三卫';
                break;
            case '3个以上':
                $room = '多卫';
                break;
            default:
                $room ='';
        }
        return $room;
    }



    
    public function getLikes($uid){
        $collects = Db::table('xcx_likes')
            ->where(['uid' => $uid,'type' => 1])
            ->field('tid')
            ->select();
        $collect =  array_column($collects,'tid');
        return $collect;
    }

    //压缩大于1.5m的房源图片
    public function compImages($files){
        $file = "./".$files;
        $size = filesize($file);
        $imgSize = ceil($size/1024);
        $Size1 = 1.5*1024;
        $Size2 = 2.5*1024;
        $Size3 = 3*1024;
        $Size4 = 6*1024;
        if($Size1 < $imgSize){
            return $file;
        }elseif($Size2 > $imgSize && $imgSize > $Size1){
            $this->compressImg($file,80);
        }elseif($Size3 > $imgSize && $imgSize > $Size2){
            $this->compressImg($file,70);
        }elseif($Size4 > $imgSize && $imgSize > $Size3){
            $this->compressImg($file,60);
        }else{
            $this->compressImg($file,40);
        }
        return $files;
    }

    /***
     * @param $filePath string 文件路径
     * @param $quality int 压缩比率
     * @return mixed
     */
    public function compressImg($filePath,$quality){
        $image = Image::open($filePath);
        $image->save($filePath,null,$quality);
        return $filePath;
    }

    public function getCollects($uid){
        $collects = Db::table('xcx_collect')
            ->where(['cl_user_id' => $uid,'cl_type' => 1])
            ->field('cl_house_id')
            ->select();
        $collect =  array_column($collects,'cl_house_id');
        return $collect;
    }

    public function getCorpLogo($corp){
        $logo = Db::table('xcx_corp')->where(['cp_id' => $corp])->field('cp_logo')->find();
        return $logo ? $logo['cp_logo'] : '';
    }

    public function getPmname($admin,$pm,$uid){
        $userName['ad_realname'] ='';
        $userName['pm_avatar'] = '';
        if($admin == 1){
            $user = Db::table('tk_user')->where(['id' => $uid])->field('nickname,avaurl')->find();
            $userName['ad_realname'] = $user['nickname'] ? $user['nickname'] : '外星人呀';
            $userName['ad_img'] = $user['avaurl'] ? $user['avaurl'] : '';
        }else if($admin == 2){
            $user = Db::table('super_admin')->where(['ad_id' => $pm])->field('ad_realname,ad_img')->find();
            $userName['ad_realname'] = $user['ad_realname'] ? $user['ad_realname'] : '外星人呀';
            $userName['ad_img'] = $user['ad_img'] ? 'https://wx.huaxiangxiaobao.com/'.$user['ad_img'] : 'https://wx.huaxiangxiaobao.com/static/logo.png';
        }
        return $userName;
    }

    public function getLiveDate($date){
        $now = date('Y-m-d');
        if($date){
            $time['min'] = date( 'Y-m-d', strtotime($now.' -'.$date.' days'));
            $time['max'] = date( 'Y-m-d', strtotime($now.' +'.$date.' days'));
        }else{
            $time['min'] = '';
            $time['max'] = '';
        }
        return $time;
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