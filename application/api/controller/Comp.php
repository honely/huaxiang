<?php


namespace app\api\controller;


use think\Controller;
use think\Db;

class Comp extends Controller{
    /**
     * 添加房源对比
     * 1.用户 uid
     * 2.房源 hid
     * 3.房源类型 1 整租 ；2 合租
     */
    public function addToComp(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = trim($this->request->param('uid'));
        $hid = trim($this->request->param('hid'));
        $type = trim($this->request->param('type',1));
        if(!$uid || !$hid || !$type){
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $dat['cp_uid'] = $uid;
        $dat['cp_type'] = $type;
        $dat['cp_status'] = 1;
        $dat['cp_hid'] = $hid;
        $isExi = Db::table('tk_compare')->where($dat)->count();
        if($isExi >= 1){
            $res['code'] = 0;
            $res['msg'] = '请勿添加重复房源！';
            return json($res);
        }
        unset($dat['cp_hid']);
        $isExi = Db::table('tk_compare')->where($dat)->count();
        if($isExi >= 4){
            $res['code'] = 0;
            $res['msg'] = '对比房源数不超过4个！';
            return json($res);
        }
        $data['cp_uid'] = $uid;
        $data['cp_hid'] = $hid;
        $data['cp_type'] = $type;
        $data['cp_addtime'] = $uid;
        $insert = Db::table('tk_compare')->insertGetId($data);
        if($insert){
            $res['code'] = 1;
            $res['msg'] = '添加成功！';
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '添加失败！';
        return json($res);
    }

    /***
     * 删除房源对比
     * cp_id  对比id
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delComp(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $cpid = trim($this->request->param('cp_id'));
        if(!$cpid){
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $isExi = Db::table('tk_compare')
            ->where(['cp_id' => $cpid])
            ->update(['cp_status' =>2]);
        if($isExi){
            $res['code'] = 1;
            $res['msg'] = '删除成功！';
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '删除失败！';
        return json($res);
    }


    /***
     *
     */
    public function myComp(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = trim($this->request->param('uid'));
        $type = trim($this->request->param('type',1));
        if(!$uid ||  !$type){
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $data['cp_uid'] = $uid;
        $data['cp_type'] = $type;
        $data['cp_status'] = 1;
        $res1 = Db::table('tk_compare')
            ->join('tk_houses','tk_houses.id = tk_compare.cp_hid')
            ->where($data)
            ->select();
        if($res1){
            foreach ($res1 as $k => $v){
                $images = $v['thumnail'] ? $v['thumnail'] : $this->formatImg($v['images']);
                $res1[$k]['images'] = $images;
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功1！';
            $res['data'] = $res1;
            $res['count'] = sizeof($res1);
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $res1;
        $res['count'] = sizeof($res1);
        return json($res);
    }

  
    public function formatImg($imgs){
        $imgsa = explode(',',$imgs);
        $img = $imgsa[0];
        return $img;
    }

    /***
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function compHouse(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = trim($this->request->param('uid'));
        $type = trim($this->request->param('type',1));
        if(!$uid ||  !$type){
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $data['cp_uid'] = $uid;
        $data['cp_type'] = $type;
        $data['cp_status'] = 1;
        $houseids = Db::table('tk_compare')->where($data)->field('cp_id,cp_hid')->select();
        if($houseids){
            foreach ($houseids as $k => &$v){
                $v['houses'] = $this->getHouse($v['cp_hid']);
                $billsArr = explode(',', $v['houses']['bill']);
                $v['houses']['is_water'] = in_array('包水', $billsArr) ? 1 : 0;
                $v['houses']['is_elet'] = in_array('包电', $billsArr) ? 1 : 0;
                $v['houses']['is_gas'] = in_array('包气', $billsArr) ? 1 : 0;
                $v['houses']['is_net'] = in_array('包网', $billsArr) ? 1 : 0;
            }unset($v);
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $houseids;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '读取失败！';
        return json($res);
    }

    public function getHouse($hid){
        $house = Db::table('tk_houses')->where(['id' =>$hid])->find();
        return $house;
    }


    public function compCount(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = trim($this->request->param('uid'));
        $type = trim($this->request->param('type',1));
        if(!$uid ||  !$type){
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $data['cp_uid'] = $uid;
        $data['cp_type'] = $type;
        $data['cp_status'] = 1;
        $resq = Db::table('tk_compare')->where($data)->count();
        if($resq){
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['count'] = $resq;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '读取失败！';
        $res['count'] = 0;
        return json($res);
    }

}