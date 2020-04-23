<?php
namespace app\xcx\model;
use think\Db;
use think\Model;

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
        $result = Db::table('tk_houses')
            ->where($where)
            ->limit($limit,$page)
            ->order($order)
            ->field($field)
            ->select();
        if($result){
            foreach ($result as $k => $v){
//                $add = $v['address'];
//                if(isset($add)){
//                    $result[$k]['area'] = explode(',',$add)[1];
//                }
                $result[$k]['images'] = $this->formatImg($v['images']);
            }
        }
        return $result ? $result :  null;
    }


    public function addHouse($data){
        $data['dsn'] = $this->genHouseDsn();
        $add = $data['address'];
        if(isset($add)){
            $data['area'] = trim(explode(',',$add)[1]);
        }
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
        unset($data['id']);
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
        $house = Db::table('tk_houses')
            ->where(['id' => $id])
            ->find();
        if (empty($house)) {
            $res['code'] = 0;
            $res['msg'] = '该房源已经不存在了';
            $res['data'] = null;
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
            $house['toilet'] = intval($house['toilet']);
            $house['car'] = intval($house['car']);
            $house['house_room'] = $this->numRoom($house['house_room']);
            $house['real_name'] = $loop->getUserNick($house['user_id']);
            $house['avatar'] = $loop->getUserAvatar($house['user_id']);
        }

        //写入一条浏览记录
        $view = new Views();
        $view->addView($uid,$id,1);
        $res['code'] = 1;
        $res['msg'] = '读取成功';
        $res['data'] = $house;
        return $res;
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
        switch ($room){
//        一室，两室，三室，三室以上
            case '一室':
                $room = '1';
                break;
            case '两室':
                $room = '2';
                break;
            case '三室':
                $room = '3';
                break;
            case '三室以上':
                $room = '多';
                break;
            default:
                $room ='';
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
}