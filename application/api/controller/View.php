<?php


namespace app\api\controller;
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
        $uId = intval(trim($this->request->param('uid')));
        $type = intval(trim($this->request->param('type',1)));
        $page = intval(trim($this->request->param('page',0)));
        $limit = intval(trim($this->request->param('limit',10)));
        $where = [
            'vh_userid' => $uId,
            'vh_type' => $type,
        ];
        $order = 'vh_add_time desc';
        $field = 'vh_id,vh_house_id';
        $col = new Views();
        if($type == 1){
            $collects = $col->readData($where,$order,$limit,$page,$field);
        }elseif ($type == 2){
            $collects = $col->readDataV($where,$order,$limit,$page,$field);
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

}