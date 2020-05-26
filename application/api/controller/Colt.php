<?php


namespace app\api\controller;


use app\xcx\model\Collects;
use app\xcx\model\Msgs;
use think\Controller;
use think\Db;

class Colt extends Controller
{


    /***
     * 收藏房源
     * 2020年3月13日14:10:18
     * Dmm
     * uid 用户id
     * hid 房源id
     * @return \think\response\Json
     */
    public function colHouse(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid')));
        $hid = intval(trim($this->request->param('hid')));
        if(!$uId || !$hid){
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $col = new Collects();
        $add = $col->addCollect($uId,$hid,1);
        if($add){
            $res['code'] = 1;
            $res['msg'] = '收藏成功！';
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '收藏失败！';
        return json($res);
    }


    /***
     * 收藏找室友
     * 2020年3月13日14:11:09
     * Dmm
     * uid 用户id
     * mid 找室友id
     * @return \think\response\Json
     */
    public function colMate(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid')));
        $mid = intval(trim($this->request->param('mid')));
        if(!$uId || !$mid){
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $col = new Collects();
        $add = $col->addCollect($uId,$mid,2);
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

    public function canCollect(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $clid = intval(trim($this->request->param('cl_id')));
        $colt =  Db::table('xcx_collect')
            ->where(['cl_id' => $clid])
            ->field('cl_user_id')
            ->find();
        $del = Db::table('xcx_collect')->where(['cl_id' => $clid])->delete();
        //更新用户收藏量
        Db::table('tk_user')->where(['id' => $colt['cl_user_id']])->setDec('count');
        if($del){
            $res['code'] = 1;
            $res['msg'] = '取消收藏成功！';
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '取消收藏失败！';
        return json($res);
    }

    public function getCollect(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid',1)));
        $type = intval(trim($this->request->param('type',1)));
        $page = intval(trim($this->request->param('page',0)));
        $limit = intval(trim($this->request->param('limit',10)));
        $where = 'cl_user_id = '.$uId.' and cl_type = '.$type;
        $order = 'cl_addtime desc';
        $field = 'cl_id,cl_house_id';
        $colm = new Collects();
        if($type == 1){
            $collects = $colm->readData($where,$order,$limit,$page,$field);
        }elseif ($type == 2){
            $collects = $colm->readDataM($where,$order,$limit,$page,$field);
        }

        if($collects){
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $collects;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $collects;
        return json($res);

    }

    public function updateUserColl(){
        $sql = "select cl_user_id, count(*) as count from xcx_collect group by  cl_user_id";
        $ress = Db::query($sql);
        foreach ($ress as $k => $v){
            Db::table('tk_user')->where(['id' => $v['cl_user_id']])->update(['count' => $v['count']]);
        }
    }

}