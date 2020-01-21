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
    public function readData($where,$order,$limit,$page){
        $result = Db::table('xcx_banner')
            ->where($where)
            ->limit($limit,$page)
            ->order($order)
            ->select();
        return $result ? $result :  null;
    }
}