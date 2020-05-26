<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

class Cate extends Controller
{
    /***
     *Names:读取城市和校区的方法
     * 注意：读取城市不需要传任何值
     * 读取校区，需要传递城市的id
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/11/20 11:44
     */
    public function getCity(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $cId = $this->request->param('cid',0,'intval');
        $where = $cId == 0 ? 'pid = 0' : "pid = ".$cId." and type = 2";
        $result = Db::table('tk_cate')
            ->where($where)
            ->field('id,name,pid,oseq')
            ->order('oseq asc')
            ->select();
        if($result){
            $res['code'] =1;
            $res['msg'] ='读取成功！';
            $res['data'] =$result;
            return json($res);
        }else{
            $res['code'] =1;
            $res['msg'] ='数据为空';
            return json($res);
        }
    }

    public function getTags(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $type = $this->request->param('type',1,'intval');
        $tags = Db::table('xcx_tags')->where(['type' => $type])->field('name')->select();
        if($tags){
            $res['code'] =1;
            $res['msg'] ='读取成功！';
            $res['data'] =$tags;
            return json($res);
        }else{
            $res['code'] =1;
            $res['msg'] ='数据为空';
            return json($res);
        }
    }


}