<?php


namespace app\api\controller;


use app\xcx\model\Housem;
use think\Controller;
use think\Db;

class Corp extends Controller
{

    /***
     * 个人主页
     */
    public function personal(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id = trim($this->request->param('aid'));
        if(!$id){
            $res['code'] = 2;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $admin['personal'] = Db::table('super_admin')->where(['ad_id' => $id])->find();
        if($admin['personal']){
            unset($admin['ad_password']);
            //个人在租
            $where = ['pm' => $id];
            $fields = "id,house_type,toilet,car,house_room,area,price,images";
            $hous = new Housem();
            $admin['house'] = $hous->readData($where,'id desc',5,0,$fields);
            $admin['count'] =5;
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $admin;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        return json($res);
    }

    /***
     * 公司主页
     */
    public function comps(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id = trim($this->request->param('cid'));
        if(!$id){
            $res['code'] = 2;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $admin['corp'] = Db::table('xcx_corp')->where(['cp_id' => $id])->find();
        if($admin){
            //我的团队
            $admin['team'] = Db::table('super_admin')
                ->where(['ad_corp' => $id])
                ->field('ad_id,ad_realname,ad_img')
                ->select();
            //全部房产总数
            $fields = "id,house_type,toilet,car,house_room,area,price,images";
            $where = ['corp' => $id];
            $hous = new Housem();
            $admin['house'] = $hous->readData($where,'id desc',5,0,$fields);
            $admin['count'] =5;
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $admin;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        return json($res);
    }

}