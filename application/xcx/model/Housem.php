<?php
namespace app\xcx\model;
use think\Db;
use think\Image;
use think\Model;
use think\Log;
class Housem extends Model
{

    /***
     * @param $where
     * @param $order
     * @param $limit
     * @param $page
     * @return false|\PDOStatement|string|\think\Collection|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by Dangmengmeng At 2020/1/22 15:05
     */
    public function readData($where,$order,$limit,$page,$field){
       $field = $field.',thumnail';
        $result = Db::table('tk_houses')
            ->where($where)
            ->where(['is_del' => 1])
            ->limit(($page)*$limit,$limit)
            ->order($order)
            ->field($field)
            ->select();
        if($result){
            foreach ($result as $k => $v){
               $result[$k]['imgs'] = $v['thumnail'] ? $v['thumnail'].",".$v['images'] : $v['images'];
               $images = $v['thumnail'] ? $v['thumnail'] : $this->formatImg($v['images']);
               $result[$k]['images'] = $images;
               $result[$k]['cover'] = $this->compCover($v['id'],$images);
            }
        }
        return $result ? $result :  null;
    }
    public function houscount($where){
        $result = Db::table('tk_houses')
            ->where($where)
            ->where(['is_del' => 1])
            ->count('id');
        return $result;
    }
    public function readDatas($where,$order,$limit,$page,$field){
        $result = Db::table('tk_houses')
            ->where($where)
            ->where(['is_del' => 1])
            ->limit(($page)*$limit,$limit)
            ->orderRaw($order)
            ->group('x')
            ->field($field)
            ->select();
        foreach ($result as $k => $v){
            $images = $v['thumnail'] ? $v['thumnail'] : $this->formatImg($v['images']);
            $result[$k]['images'] = $images;
            $result[$k]['cover'] = $this->compCover($v['id'],$images);
        }
        return $result ? $result :  null;
    }

    public function houseCot($where){
        $result = Db::table('tk_houses')
            ->where($where)
            ->where(['is_del' => 1])
            ->count('id');
            return $result;
    }


    public function addHouse($data){
        $data['dsn'] = $this->genHouseDsn();
        $add = $data['address'];
        if(isset($add)){
            $data['area'] = trim(explode(',',$add)[1]);
        }
        $data['is_admin'] = 1;
          //是否绑定手机号
        if(isset($data['is_save']) && $data['is_save'] == 1){
            Db::table('tk_user')
                ->where(['id' => $data['user_id']])
                ->update(['tel' => $data['tel'],'wchat' => $data['wchat']]);
        }
        if(isset($data['city']) && $data['city']){
            switch ($data['city']){
                case 'Melbourne':
                    $city = '墨尔本';
                    break;
                case 'Sydney':
                    $city = '悉尼';
                    break;
                case 'Tasmania':
                    $city = '塔州';
                    break;
                case 'Brisbane':
                    $city = '布里斯班';
                    break;
                default:
                    $city  = $data['city'];
                    break;
            }
            $data['city'] = $city;
        }
        unset($data['is_save']);
        $addHouse = Db::table('tk_houses')->insertGetId($data);
        $mateInfo = Db::table('tk_houses')->where(['id' =>$addHouse])->field('user_id')->find();
        $msg = new Loops();
        $userNick = $msg->getUserNick($mateInfo['user_id']);
        $str = $userNick.'正在出租一套房源';
        $msg->insertMsg($str);
        return $addHouse ? $addHouse :  0;
    }

    public function editHouse($data){
        $id = $data['id'];
        if(isset($data['address']) && $data['address']){
            $add = $data['address'];
            $data['area'] = trim(explode(',',$add)[1]);
        }
          //是否绑定手机号
        if(isset($data['is_save']) && $data['is_save'] == 1){
            Db::table('tk_user')
                ->where(['id' => $data['user_id']])
               ->update(['tel' => $data['tel'],'wchat' => $data['wchat']]);
        }
        if(isset($data['city']) && $data['city']){
            switch ($data['city']){
                case 'Melbourne':
                    $city = '墨尔本';
                    break;
                case 'Sydney':
                    $city = '悉尼';
                    break;
                case 'Tasmania':
                    $city = '塔州';
                    break;
                case 'Brisbane':
                    $city = '布里斯班';
                    break;
                default:
                    $city  = $data['city'];
                    break;
            }
            $data['city'] = $city;
        }
        unset($data['is_save']);
        unset($data['id']);
        unset($data['user_id']);
        $update = Db::table('tk_houses')
            ->where(['id' => $id])
            ->update($data);
        return $update ? $id : 0;
    }

    public function formatImg($imgs){
        $imgsa = explode(',',$imgs);
        $img = $imgsa[0];
        return $img;
    }

    public function getHouse($id,$uid){
         $areaHouse =[];
        $loardHouse =[];
        $comment =[];
        $commc = 0;
        $house = Db::table('tk_houses')
            ->where(['id' => $id])
            ->find();
        if (empty($house)) {
            $res['code'] = 0;
            $res['msg'] = '该房源已经不存在了';
            $res['data'] = null;
            $res['other'] = $areaHouse;
            $res['counto'] = sizeof($areaHouse);
            $res['loard'] = $loardHouse;
            $res['countl'] = sizeof($loardHouse);
            $res['comment'] = $comment;
            $res['countc'] = $commc;
            return $res;
        }
        if($house['status'] !=1 || $house['is_del'] == 2){
            $res['code'] = 0;
            $res['msg'] = '该房源已被外星人劫持';
            $res['data'] = null;
            $res['other'] = $areaHouse;
            $res['counto'] = sizeof($areaHouse);
            $res['loard'] = $loardHouse;
            $res['countl'] = sizeof($loardHouse);
            $res['comment'] = $comment;
            $res['countc'] = $commc;
            return $res;
        }
        if (!$house['area_img']) {
            $this->get_area_id($house['id'], $house['x'], $house['y']);

        }
        $house = Db::table('tk_houses')
            ->where(['id' => $id])
            ->find();
        $loop = new Loops();
        if($house){
            if($house['live_date'] == '0100-01-01' || $house['live_date']== '0000-00-00'){
                $house['live_date'] = '随时入住';
            }
            if($house['images']){
                //压缩房源图片
                $house['images'] = $this->cpHouseImg($house['images']);
            }
            if($house['thumnail']){
                //压缩封面图
                $house['thumnail'] = $this->compImg($house['thumnail']);
                $house['images'] = $house['thumnail'].','.$house['images'];
            }
            $house['toilet'] = intval($house['toilet']);
            $house['mdate'] = date("Y-m-d",strtotime($house['mdate']));
            $house['car'] = intval($house['car']);
            //$house['house_room'] = $this->numRoom($house['house_room']);
            $house['logo'] = $this->getAdminLogo($house['corp']);
            $house['minilogo'] = $this->getMiniLogo($house['corp']);
            $house['is_colt'] = $this->getColt($house['id'],$uid);
            $house['is_like'] = $this->getLikes($house['id'],$uid);
            //$house['colour'] = $this->getColour($house['corp']);
            //看过本房的还在看
            $area = $house['area'];
            $where ="status = 1 and area = '".$area."' and id != ".$id;
            $field = "id,title,house_type,toilet,car,house_room,area,images,price,address,tags";
            $areaHouse['data'] = $this->readData($where,'id desc',7,0,$field);
            //房东的其他房源is_admin = 1 个人房源  =2 中介房源
            $fields = "id,address,house_type,toilet,car,house_room,area,price,images";
            if($house['is_admin'] == 2){
                $house['real_name'] = $loop->getAdminNick($house['pm']);
                $house['avatar'] = $loop->getAdminAvatar($house['pm']);
                $whereloard ="status = 1 and pm = ".$house['pm']." and id != ".$id;
            }else{
                $house['real_name'] = $loop->getUserNick($house['user_id']);
                $house['avatar'] = $loop->getUserAvatar($house['user_id']);
                $whereloard ="status = 1 and user_id = ".$house['user_id']." and id != ".$id;
            }
            $loardHouse = $this->readData($whereloard,'id desc',3,0,$fields);
            if($house['type'] == "合租"){
                $comment = Db::table('tk_comment')
                    ->where(['type' => 1,'repy' => 1,'status' =>1,'tid' => $id])
                    ->order('cid desc')
                    ->limit(2)
                    ->select();
                if($comment){
                    $loop = new Loops();
                    foreach ($comment as $k => $v){
                        $comment[$k]['nickname'] = $loop->getUserNick($v['userid']);
                        $comment[$k]['avatar'] = $loop->getUserAvatar($v['userid']);
                        $comment[$k]['replys'] = $this->getReplay($v['cid']);
                    }
                }
                $commc = Db::table('tk_comment')->where(['type' => 1,'repy' => 1,'status' =>1,'tid' => $id])->count('cid');
            }
        }
        //写入一条浏览记录
        $view = new Views();
        $view->addView($uid,$id,1);
        $res['code'] = 1;
        $res['msg'] = '读取成功';
        $res['data'] = $house;
        $res['other'] = $areaHouse;
        $res['counto'] = sizeof($areaHouse);
        $res['loard'] = $loardHouse;
        $res['countl'] = sizeof($loardHouse);
        $res['comment'] = $comment;
        $res['countc'] = $commc;
        return $res;
    }
    
    
    public function getColt($id,$uid){
        $collects = Db::table('xcx_collect')
            ->where(['cl_user_id' => $uid,'cl_type' => 1])
            ->field('cl_house_id')
            ->select();
        $collect =  array_column($collects,'cl_house_id');
        $colt = in_array($id,$collect,true);
        return $colt ? 1 : 0;
    }
    public function getLikes($id,$uid){
        $collects = Db::table('xcx_likes')
            ->where(['uid' => $uid,'type' => 1])
            ->field('tid')
            ->select();
        $collect =  array_column($collects,'tid');
        $colt = in_array($id,$collect,true);
        return $colt ? 1 : 0;
    }
     
    public function compCover($id,$cover){
       if(file_exists($cover))
        {
            $image = Image::open($cover);
            $pathName = 'uploads/compress/cp'.$id.'.png';
            $path = config('compImg').'uploads/compress/cp'.$id.'.png';
            $corpImg = $image->thumb(650,430,Image::THUMB_CENTER)->save($pathName);
            //吧压缩的图片更新到cover
            Db::table('tk_houses')->where(['id'=> $id])->update(['cover' => $pathName]);
            return $path;
        }else{
            return '';
        }
    }
    
    public function getReplay($cid){
        $comment = Db::table('tk_comment')
            ->where(['repy' => 2,'status' =>1,'repyid' => $cid])
            ->limit(20)
            ->order('cid desc')
            ->select();
        if($comment){
            $loop = new Loops();
            foreach ($comment as $k => $v){
                $comment[$k]['nickname'] = $loop->getUserNick($v['userid']);
                $comment[$k]['avatar'] = $loop->getUserAvatar($v['userid']);
                //$comment[$k]['replys'] = $this->getReplay($v['cid']);
            }
        }
        return $comment;
    }

    public function getColour($corpid){
        $logo = Db::table('xcx_corp')
            ->where(['cp_id' =>$corpid])
            ->field('colour')
            ->find();
        return $logo ? $logo['colour'] : '';
    }

    public function getMiniLogo($corpid){
        $logo = Db::table('xcx_corp')
            ->where(['cp_id' =>$corpid])
            ->field('minilogo')
            ->find();
        return $logo ? $logo['minilogo'] : '';
    }
    public function getAdminLogo($corpid){
        $logo = Db::table('xcx_corp')
            ->where(['cp_id' =>$corpid])
            ->field('cp_logo')
            ->find();
        return $logo ? $logo['cp_logo'] : '';
    }
    public function cpHouseImg($images){
        $imgurl ='';
        if($images){
            $images = explode(',',$images);
            foreach ($images as $k => $item){
                $img = $this->compImg($item);
                $imgurl .= $img.",";
            }
        }
        $imgurl = rtrim($imgurl,',');
        return $imgurl;
    }


    //压缩大于1.5m的房源图片
    public function compImg($files){
        $file = "./".$files;
        if(file_exists($file))
        {
            $size = filesize($file);
            $imgSize = ceil($size/1024);
            $Size1 = 1.5*1024;
            $Size2 = 2.5*1024;
            $Size3 = 3*1024;
            if($Size2 > $imgSize && $imgSize > $Size1){
                $this->compressImg($file,80);
            }elseif($Size3 > $imgSize && $imgSize > $Size2){
                $this->compressImg($file,70);
            }elseif($imgSize > $Size2){
                $this->compressImg($file,60);
            }
            return $files;
        }else{
            return '';
        }
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



    public function get_area_id($id, $x, $y) {
       $url =  "https://image.maps.ls.hereapi.com/mia/1.6/mapview?c={$x}%2C{$y}&z=17&w=750&h=475&f=1&apiKey=WgZd-Ykul-3XNV5agUgW2vMohtzAlYEA64GIQvcrfaw";
        $res = file_get_contents($url);
        file_put_contents('uploads/area/'.$id.'.png', $res);
        $data['id'] = $id;
        $img = 'https://wx.huaxiangxiaobao.com/uploads/area/'.$id.'.png';
        Db::table('tk_houses')->where(['id' => $id])->update(['area_img' => $img]);
    }


    public function numRoom($room){
   if($room == 'Studio'){
            $room = 0;
        }
        return $room;
    }
    //生成房源编码
    public function genHouseDsn()
    {
        $dsn = 'H';
        $max =$this->getMax();
        $s = '';
        for ($i = 1; $i < 10 - strlen($max); $i++) {
            $s .= '0';
        }
        $max++;
        $dsn .= $s.$max;
        return $dsn;
    }

    public function getMax(){
        $max = Db::table('tk_houses')->order('id desc')->find();
        return $max['id'] ? $max['id'] : 0;
    }

    public function houseCount($where){
        $count = Db::table('tk_houses')
            ->where($where)
            ->count();
        return $count ? $count : 0 ;
    }

    public function userCount($where){
        $count = Db::table('tk_user')
            ->where($where)
            ->count();
        return $count ? $count : 0 ;
    }
}