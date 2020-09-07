<?php
namespace app\api\controller;
use app\xcx\model\Helpm;
use app\xcx\model\Housem;
use think\Controller;
use think\Db;

class Help extends Controller
{

    public function add(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $data = $this->request->post();
        if(!$data && !isset($data['h_uid'])){
            $res['code'] = 0;
            $res['msg'] = '缺少提交参数！';
            return json($res);
        }
        $data['h_addtime'] = date('Y-m-d H:i:s');
        $helpm = new Helpm();
        $addHelp = $helpm->addHelp($data);
        if($addHelp){
            $res['code'] = 1;
            $res['msg'] = '发布成功！';
            $res['h_id'] = $addHelp;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '发布失败！';
        return json($res);
    }


    public function edit(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $data = $this->request->post();
        if($data && $data['h_id'] <= 0){
            $res['code'] = 0;
            $res['msg'] = '缺少提交参数！';
            return json($res);
        }
        $helpm = new Helpm();
        $addHouse = $helpm->editHelp($data);
        if($addHouse){
            $res['code'] = 1;
            $res['msg'] = '修改成功！';
            $res['h_id'] = $addHouse;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '修改失败！';
        return json($res);
    }


    /***
     * 查询当前用户是否提交了租房需求
     */
    public function myrecomd(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = $this->request->param('uid',0);
        $limit = $this->request->param('limit',2);
        $page = $this->request->param('page',0);
        if(!$uid){
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $myneed = Db::table('xcx_helpme')
            ->where(['h_uid' => $uid])
            ->order(['h_addtime' => 'desc'])
            ->field('h_house_type,area,h_price_min,h_price_max,h_house_style,h_room_type,lease_term,pet,tags,h_regin')
            ->find();
        if($myneed){
            //读取符合条件的所有房源
            $where ='1 = 1';
            //价格区域
            $maxprice = $myneed['h_price_max'];
            $mimprice = $myneed['h_price_min'];
            $maxprice = $maxprice ? $maxprice : '5000';
            $mimprice = $mimprice ? $mimprice : '0';
            if(isset($maxprice) && !empty($maxprice) && $maxprice){
                $where.=" and ( price <= ".$maxprice." ";
            }
            if(isset($mimprice)){
                $where.=" and price >= ".$mimprice."  or price = -1 )";
            }
            //整租合租
            $type = $myneed['h_house_type'];
            if(isset($type) && !empty($type) && $type){
                $where.=" and  house_type = '".$type."' ";
            }
            //租房类型  公寓 别墅 联排别墅
            $housetype = $myneed['h_house_style'];
            if(isset($housetype) && !empty($housetype) && $housetype){
                $where.=" and  type = '".$housetype."' ";
            }
            //户型 几居室  需要处理一下
            //一室 两室 三室 四室及以上
            //1 2 3 4 5 6 7 8 9 0
            $houseroom = $myneed['h_room_type'];
            if(isset($houseroom) && !empty($houseroom) && $houseroom){
                $room = $this->roomFormat($houseroom);
                $where.=" and ".$room;
            }
            //城市
            $city = $myneed['h_regin'];
            if(isset($city) && !empty($city) && $city){
                $where.=" and  city = '".$city."' ";
            }
            //区域
            $area = explode(',',$myneed['area']);
            $areas = '';
            foreach ($area as $key => $item){
                $areas .= "'".$item."',";
            }
            $areas = rtrim($areas,',');
            $where.=" and area in (".$areas.")";

            //宠物 需要处理  可以  不可以
            //接受 不接受
            // $pet = $myneed['pet'];
            // if(isset($pet) && !empty($pet) && $pet){
            //     if($pet == '可以'){
            //         $pets = '接受';
            //     }else{
            //         $pets = '不接受';
            //     }
            //     $where.=" and  pet = '".$pets."' ";
            // }
            // //房源特色
            // $tags = $myneed['tags'];
            // if(isset($tags) && !empty($tags) && $tags){
            //     $where.=" and (";
            //     $tgs = explode(',',$tags);
            //     for($i=0;$i<count($tgs);$i++){
            //         if($i == (count($tgs)-1)){
            //             $where.=" find_in_set('".$tgs[$i]."',tags)";
            //         }else{
            //             $where.=" find_in_set('".$tgs[$i]."',tags) and ";
            //         }
            //     }
            //     $where.=" ) ";
            // }
            $fields = "id,address,title,house_type,toilet,car,house_room,area,price,images";
            $hous = new Housem();
            $houses = $hous->readData($where,'id desc',$limit,$page,$fields);
            if($houses){
                //是否收藏
                $collects = $this->getCollects($uid);
                foreach ($houses as $k => $v){
                    $colt = in_array($v['id'],$collects,true);
                    $houses[$k]['is_colt'] = $colt ? 1 : 0;
                }
            }
            $count = $hous->houseCot($where);
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $myneed;
            $res['house'] = $houses;
            $res['count'] = $count;
            //$res['where'] = $where;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '暂未订阅！';
        $res['data'] = null;
        $res['house'] = null;
        $res['count'] = 0;
        return json($res);
    }

    public function getCollects($uid){
        $collects = Db::table('xcx_collect')
            ->where(['cl_user_id' => $uid,'cl_type' => 1])
            ->field('cl_house_id')
            ->select();
        $collect =  array_column($collects,'cl_house_id');
        return $collect;
    }



    public function roomFormat($room){
        //一室 两室 三室 四室及以上
        //1 2 3 4 5 6 7 8 9 0
        switch ($room){
            case '一室':
                $where = 'house_room = 1 ';
                break;
            case '两室':
                $where = 'house_room = 2 ';
                break;
            case '三室':
                $where = 'house_room = 3 ';
                break;
            case '四室及以上':
                $where = 'house_room >= 4 ';
                break;
            default:
                $where = '1 = 1';
        }
        return $where;
    }
}