<?php


namespace app\api\controller;
use app\xcx\model\Loops;
use app\xcx\model\Views;
use think\Controller;
use think\Db;

class View extends Controller
{
    /***
     * 浏览房源
     * 2020年3月13日14:10:18
     * Dmm
     * uid 用户id
     * hid 房源id
     * @return \think\response\Json
     */
    public function viewHouse(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid',0)));
        $hid = intval(trim($this->request->param('hid')));
        $col = new Views();
        $add = $col->addView($uId,$hid,1);
        if($add){
            $res['code'] = 1;
            $res['msg'] = '浏览成功！';
            $res['id'] = $add;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '浏览失败！';
        $res['id'] = $add;
        return json($res);
    }


    /***
     * 浏览找室友
     * 2020年3月13日14:11:09
     * Dmm
     * uid 用户id
     * mid 找室友id
     * @return \think\response\Json
     */
    public function viewMate(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid',0)));
        $mid = intval(trim($this->request->param('mid')));
        $col = new Views();
        $add = $col->addView($uId,$mid,2);
        if($add){
            $res['code'] = 1;
            $res['msg'] = '收藏成功！';
            $res['id'] = $add;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '收藏失败！';
        $res['id'] = $add;
        return json($res);
    }

    public function getView(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid',0)));
        if($uId == 0){
            $res['code'] = 1;
            $res['msg'] = '数据为空！';
            return json($res);
        }
        $where = 'vh_userid = '.$uId;
        $collection = Db::table('xcx_view_history')
            ->where($where)
            ->limit(30)
            ->order('vh_add_time desc')
            ->select();
        if($collection){
            foreach ($collection as $k => $v){
                if($v['vh_type'] == 1){
                    $houseInfo = $this->gethouse($v['vh_house_id']);
                    $collection[$k]['cover'] =$houseInfo['cover'];
                    $collection[$k]['house_type'] =$houseInfo['house_type'];
                    $collection[$k]['house_room'] =$houseInfo['house_room'];
                    $collection[$k]['toilet'] =$houseInfo['toilet'];
                    $collection[$k]['car'] =$houseInfo['car'];
                    $collection[$k]['price'] =$houseInfo['price'];
                    $collection[$k]['type'] =$houseInfo['type'];
                    $collection[$k]['title'] =$houseInfo['title'];
                }else{
                    $coltInfo = $this->getcolt($v['vh_house_id']);
                    $collection[$k]['title'] =$coltInfo['title'];
                    $collection[$k]['type'] =$coltInfo['type'];
                }
                $collection[$k]['vh_add_time'] = date('Y-m-d',strtotime($v['vh_add_time']));
            }
            $keys = array_unique(array_column($collection, 'vh_add_time'));
            $newDatas = [];
            foreach ($keys as $key) {
                $temp = [];
                foreach ($collection as $data) {
                    if($key == $data['vh_add_time']) {
                        $temp[] = $data;
                    }
                }
                $newDatas[] = ['date' => $key, 'house' => $temp];
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $newDatas;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $collection;
        return json($res);
    }


    public function gethouse($hid){
        $houseInfo = Db::table('tk_houses')
            ->where(['id' => $hid])
            ->field('title,type,cover,house_type,house_room,car,toilet,price,title')
            ->find();
        return $houseInfo ? $houseInfo : null;
    }



    public function getcolt($id){
        $houseInfo = Db::table('tk_forent')
            ->where(['id' => $id])
            ->field('title,type')
            ->find();
        return $houseInfo ? $houseInfo : null;
    }


}