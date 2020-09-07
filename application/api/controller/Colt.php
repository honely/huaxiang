<?php


namespace app\api\controller;


use app\xcx\model\Collects;
use app\xcx\model\Loops;
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
        $uId = intval(trim($this->request->param('uid','0')));
        $hid = intval(trim($this->request->param('hid')));
        if($uId == 0){
            $res['code'] = 0;
            $res['msg'] = '您暂未登录无法收藏！';
            return json($res);
        }
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
        if($uId == 0){
            $res['code'] = 0;
            $res['msg'] = '您暂未登录无法收藏！';
            return json($res);
        }
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


    /**
     * 求租拼租收藏
     * @return \think\response\Json
     */
    public function colRent(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid')));
        $mid = intval(trim($this->request->param('rid')));
        if($uId == 0){
            $res['code'] = 0;
            $res['msg'] = '您暂未登录无法收藏！';
            return json($res);
        }
        if(!$uId || !$mid){
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $col = new Collects();
        $add = $col->addCollect($uId,$mid,3);
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
        $ids = ltrim($this->request->param('cl_id'),',');
        $idArr = explode(',',$ids);
        foreach($idArr as $key => $value)
        {
            $colt =  Db::table('xcx_collect')
                ->where(['cl_id' => $value])
                ->field('cl_user_id')
                ->find();
            Db::table('xcx_collect')
                ->where(['cl_id' => $value])
                ->delete();
            Db::table('tk_user')->where(['id' => $colt['cl_user_id']])->setDec('count');
        }
        $res['code'] = 1;
        $res['msg'] = '取消收藏成功！';
        return json($res);
    }


    public function getCollect(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uId = intval(trim($this->request->param('uid',0)));
        $page = intval(trim($this->request->param('page',0)));
        $limit = intval(trim($this->request->param('limit',10)));
        if($uId == 0){
            $res['code'] = 1;
            $res['msg'] = '数据为空！';
            return json($res);
        }
        $where = 'cl_user_id = '.$uId;
        $collection = Db::table('xcx_collect')
            ->where($where)
            ->limit(($page)*$limit,$limit)
            ->order('cl_addtime desc')
            ->select();
        if($collection){
            foreach ($collection as $k => $v){
                if($v['cl_type'] == 1){
                    $houseInfo = $this->gethouse($v['cl_house_id']);
                    $collection[$k]['imgs'] =$houseInfo['imgs'];
                    $collection[$k]['title'] =$houseInfo['title'];
                    $collection[$k]['price'] =$houseInfo['price'];
                    $collection[$k]['type'] =$houseInfo['type'];
                    $collection[$k]['address'] =$houseInfo['address'];
                }else{
                    $coltInfo = $this->getcolt($v['cl_house_id']);
                    $collection[$k]['title'] =$coltInfo['title'];
                    $collection[$k]['type'] =$coltInfo['type'];
                    $collection[$k]['userid'] =$coltInfo['userid'];
                    $collection[$k]['avatar'] =$coltInfo['avatar'];
                    $collection[$k]['nickname'] =$coltInfo['nickname'];
                }
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $collection;
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
            ->field('title,price,images,type,address,thumnail')
            ->find();
        if($houseInfo){
            $houseInfo['imgs'] = $houseInfo['thumnail'] ? $houseInfo['thumnail'].",".$houseInfo['images'] : $houseInfo['images'];
            unset($houseInfo['images']);
            unset($houseInfo['thumnail']);
        }
        return $houseInfo ? $houseInfo : null;
    }



    public function getcolt($id){
        $houseInfo = Db::table('tk_forent')
            ->where(['id' => $id])
            ->field('title,type,userid')
            ->find();
        if($houseInfo){
            $loop = new Loops();
            $houseInfo['avatar'] = $loop->getUserAvatar($houseInfo['userid']);
            $houseInfo['nickname'] = $loop->getUserNick($houseInfo['userid']);
        }
        return $houseInfo ? $houseInfo : null;
    }
  
   public function updateUserColl(){
        $sql = "select cl_user_id, count(*) as count from xcx_collect group by  cl_user_id";
        $ress = Db::query($sql);
        foreach ($ress as $k => $v){
            Db::table('tk_user')->where(['id' => $v['cl_user_id']])->update(['count' => $v['count']]);
        }
    }


    /***
     * 用户点赞
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function likes(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id = intval(trim($this->request->param('id')));
        $uid = intval(trim($this->request->param('uid')));
        $clid = intval(trim($this->request->param('type')));
        $date = date('Y-m-d');
        $colt =  Db::table('xcx_likes')
            ->where(['uid' => $uid,'tid'=>$id,'type' => $clid,'addtime' => $date])
            ->find();
        if(!$colt){
            $data['addtime'] = $date;
            $data['uid'] = $uid;
            $data['tid'] = $id;
            $data['type'] = $clid;
            $insert = Db::table('xcx_likes')->insertGetId($data);
            if($insert){
                if($clid == 1){
                    Db::table('tk_houses')
                        ->where(['id' => $id])
                        ->setInc('likes');
                }elseif($clid == 2){
                    Db::table('tk_forent')
                        ->where(['id' => $id])
                        ->setInc('likes');
                }
            }
            $res['code'] = 1;
            $res['msg'] = '点赞成功！';
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '您今天已经点过赞了！';
        return json($res);
    }

    public function unlike(){
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
}