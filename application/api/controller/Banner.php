<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2019/1/21
 * Time: 11:47
 */
namespace app\api\controller;
use think\Controller;
use think\Db;

class Banner extends Controller{

    public function miniBanner(){
        $banner = Db::table('super_banner')
            ->where(['ba_via' => 2,'ba_isable' => 1])
            ->order('ba_order desc')
            ->field('ba_title,ba_img')
            ->select();
        if($banner){
            foreach ($banner as $k =>$v){
                $banner[$k]['ba_img'] =RES_URL.''.$v['ba_img'];
            }
            return json(['msg'=>'读取成功','data' => $banner]);
        }else{
            return json(['msg'=>'读取失败','data' => $banner]);
        }
    }


    public function indexHouse(){
        $houseInfo = Db::table('super_houses')
            ->where(['h_c_id' => 3,'h_rent_status' => 2,'h_isable' => 1])
            ->limit(4)
            ->order('h_view desc')
            ->field('h_id,h_house_img,h_name,h_rent,h_type')
            ->select();
        if($houseInfo){
            foreach ($houseInfo as $k =>$v){
                $houseInfo[$k]['h_house_img'] =RES_URL.''.$v['h_house_img'];
                $houseInfo[$k]['h_type'] = Db::table('super_type')->where(['type_sort' => 1,'type_id' => $v['h_type']])->column('type_name');
            }
            return json(['msg'=>'读取成功','data' => $houseInfo]);
        }else{
            return json(['msg'=>'读取失败','data' => $houseInfo]);
        }
    }


    public function houseList(){
        $type = trim($this->request->param('type'));
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
//        dump($type);
        if($type == 1){
            $houseData = Db::table('super_houses')
                ->where(['h_rent_status' => 2,'h_isable' => 1])
                ->order('h_view desc')
                ->limit(($page-1)*$limit,$limit)
                ->field('h_id,h_house_img,h_name,h_rent,h_type')
                ->select();
            if($houseData){
                foreach ($houseData as $k =>$v){
                    $houseData[$k]['h_house_img'] =RES_URL.''.$v['h_house_img'];
                    $houseData[$k]['h_type'] = Db::table('super_type')->where(['type_sort' => 1,'type_id' => $v['h_type']])->column('type_name');
                }
                return json(['msg'=>'读取成功','data' => $houseData]);
            }else{
                return json(['msg'=>'读取失败','data' => $houseData]);
            }
        }elseif ($type == 2){
            $houseData = Db::table('super_houses')
                ->where(['h_rent_status' => 2,'h_isable' => 1])
                ->order('h_view desc')
                ->limit(($page-1)*$limit,$limit)
                ->field('h_id,h_house_img,h_name,h_rent,h_type')
                ->select();
            if($houseData){
                foreach ($houseData as $k =>$v){
                    $houseData[$k]['h_house_img'] =RES_URL.''.$v['h_house_img'];
                    $houseData[$k]['h_type'] = Db::table('super_type')->where(['type_sort' => 1,'type_id' => $v['h_type']])->column('type_name');
                }
                return json(['msg'=>'读取成功','data' => $houseData]);
            }else{
                return json(['msg'=>'读取失败','data' => $houseData]);
            }
        }elseif ($type == 3){
            $houseData = Db::table('super_houses')
                ->where(['h_rent_status' => 2,'h_isable' => 1])
                ->order('h_rent desc')
                ->limit(($page-1)*$limit,$limit)
                ->field('h_id,h_house_img,h_name,h_rent,h_type')
                ->select();
            if($houseData){
                foreach ($houseData as $k =>$v){
                    $houseData[$k]['h_house_img'] =RES_URL.''.$v['h_house_img'];
                    $houseData[$k]['h_type'] = Db::table('super_type')->where(['type_sort' => 1,'type_id' => $v['h_type']])->column('type_name');
                }
                return json(['msg'=>'读取成功','data' => $houseData]);
            }else{
                return json(['msg'=>'读取失败','data' => $houseData]);
            }
        }
    }



    //房源详情
    public function housedetail(){
        $h_id = trim($this->request->param('h_id'));
        $houseInfo = Db::table('super_houses')->where(['h_id' => $h_id])->find();
        if($houseInfo){
            $houseInfo['h_house_img'] =RES_URL.''.$houseInfo['h_house_img'];
            $houseInfo['h_img'] = explode(',',$houseInfo['h_img']);
            foreach($houseInfo['h_img'] as $key=> $val){
                $houseInfo['h_img'][$key]=RES_URL.'/'.$val;
            }
            $houseInfo['h_type'] = Db::table('super_type')->where(['type_sort' => 1,'type_id' => $houseInfo['h_type']])->column('type_name');
            return json(['msg'=>'读取成功','data' => $houseInfo]);
        }else{
            return json(['msg'=>'读取成功','data' => $houseInfo]);
        }

    }
}