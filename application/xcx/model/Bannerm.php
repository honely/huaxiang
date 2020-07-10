<?php


namespace app\xcx\model;


use think\Db;
use think\Model;

class Bannerm extends Model
{


    /***
     * @param $data
     * @return int|string
     * Created by Dangmengmeng At 2020/1/17 9:48
     */
    public function add($data){
        $add = Db::table('xcx_banner')
            ->insertGetId($data);
        return $add ? $add : 0 ;
    }


    /***
     * @param $data
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * Created by Dangmengmeng At 2020/1/17 9:48
     */
    public function edit($data){
        $id = $data['id'];
        $edit = Db::table('xcx_banner')
            ->where(['b_id' => $id])
            ->update($data);
        return $edit ? true :false;
    }


    /***
     * @param $id
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * Created by Dangmengmeng At 2020/1/17 9:48
     */
    public function del($id){
        $del = Db::table('xcx_banner')
            ->where(['b_id' => $id])
            ->delete();
        return $del ? true :false;
    }


    /***
     * @param $where
     * @param $order
     * @param $limit
     * @param $page
     * @return false|\PDOStatement|string|\think\Collection|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by Dangmengmeng At 2020/1/17 9:59
     */
    public function readData($where,$order,$limit,$page,$field){
        $result = Db::table('xcx_banner')
            ->where($where)
            ->limit(($page)*$limit,$limit)
            ->order($order)
            ->field($field)
            ->select();
        return $result ? $result :  null;
    }



    public function getBan($id){
        $house = Db::table('xcx_banner')
            ->where(['b_id' => $id])
            ->find();
        if (empty($house)) {
            $res['code'] = 0;
            $res['msg'] = '广告已经不存在了';
            $res['data'] = null;
            return $res;
        }
        if ($house['b_status'] != 1) {
            $res['code'] = 0;
            $res['msg'] = '此广告已下架。';
            $res['data'] = null;
            return $res;
        }
        $res['code'] = 1;
        $res['msg'] = '读取成功';
        $res['data'] = $house;
        return $res;
    }
}