<?php
namespace app\home\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{


    /**
     * 首页推荐房源
     */
    public function getIndex(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $houses = Db::table('tk_houses')
            ->where(['tj' => '是','status' =>1])
            ->limit(6)
            ->field('id,thumnail,title,price,furniture,school,sex,sation,home')
            ->order('mdate desc')
            ->select();
        foreach ($houses as $k => $v){
            $houses[$k]['tags'] = explode(',',$v['home']);
            $houses[$k]['sation'] = explode(',',$v['sation']);
        }
        if($houses){
            return json(['code' => 1,'msg'=>'读取成功','data' => $houses]);
        }else{
            return json(['code' => 0,'msg'=>'读取失败','data' => null]);
        }

    }


    /***
     * 房源列表
     */
    public function getList(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $where = '1 = 1';
        $page= $this->request->param('page',1,'intval');
        $keywords = trim($this->request->param('keywords'));
        if(isset($keywords) && !empty($keywords) && $keywords){
            $where.=" and ( school like '%".$keywords."%' or area like '%".$keywords."%' or street like '%".$keywords."%')";
        }
        $city= $this->request->param('city');
        if(isset($city) && !empty($city) && $city){
            $where.=" and city = '".$city."'";
        }
        $type= $this->request->param('type');
        if(isset($type) && !empty($type) && $type){
            $where.=" and type = '".$type."'";
        }
        $room= $this->request->param('room');
        if(isset($room) && !empty($room) && $room){
            $where.=" and house_room = '".$room."'";
        }
        $price= $this->request->param('price');
        //价格：全部  0-$300  $300-$500  $500-$700  $700-$1000   $1000及以上
        if(isset($price) && !empty($price) && $price){
            switch ($price) {
                case 1:
                    $priceWhere = ' and price >= 0 and price <= 300';
                    break;
                case 2:
                    $priceWhere =  ' and price >= 300 and price <= 500';
                    break;
                case 3:
                    $priceWhere =  ' and price >= 500 and price <= 700';
                    break;
                case 4:
                    $priceWhere =  ' and price >= 700 and price <= 1000';
                    break;
                case 5:
                    $priceWhere =  ' and price >= 1000';
                    break;
                default:
                    $priceWhere =  '';
            }
            $where .=$priceWhere;
        }
        $limit = 25;
        $list = Db::table('tk_houses')
            ->where(['status' => 1])
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->field('id,thumnail,title,address,price,furniture,school,sex,sation,car,home,type,house_room,city')
            ->order('mdate desc')
            ->select();
        $count = Db::table('tk_houses')
            ->where(['status' => 1])
            ->where($where)
            ->count();
        foreach ($list as $k => $v){
            $list[$k]['tags'] = explode(',',$v['home']);
            $list[$k]['sation'] = explode(',',$v['sation']);
        }
        $data['count'] = $count;
        $data['house'] = $list;
        if($list){
            return json(['code' => 1,'msg'=>'读取成功','data' => $data]);
        }else{
            return json(['code' => 0,'msg'=>'读取失败','data' => null]);
        }
    }

    /***
     *Names:房源详情方法
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/11/13 11:23
     *
     */
    public function getHouseDetails(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $h_id= $this->request->param('h_id');
        $house = Db::table('tk_houses')
            ->where(['id' => $h_id])
            ->field('thumnail,title,address,price,furniture,school,sex,sation,car,home,type,house_room,city,pet,smoke,content,images,area_img,live_date,house_type,toilet,area,lease_term,bill,x,y,real_name,wchat,tel')
            ->find();
        if($house){
            $house['images'] = explode(',',$house['images']);
            $house['tags'] = explode(',',$house['home']);
            $house['sation'] = explode(',',$house['sation']);
            return json(['code' => 1,'msg'=>'读取成功','data' => $house]);
        }else{
            return json(['code' => 0,'msg'=>'读取失败','data' => null]);
        }
    }

}