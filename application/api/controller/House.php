<?php
namespace app\api\controller;
use app\xcx\model\Housem;
use think\Controller;

class House extends Controller
{


    /**
     * 房源列表查询接口
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        //城市
        $city = trim($this->request->param('city','墨尔本'));
        //区域里面  热门  学校  所有区
        //热门区域
        $where = "city = '".$city."'";
        $area = trim($this->request->param('area'));
        if(isset($area) && !empty($area) && $area){
            $where.=" and area = '".$area."'";
        }
        //学校
        $school = trim($this->request->param('school'));
        if(isset($school) && !empty($school) && $school){
            $where.=" and school = '".$school."'";
        }

        //所有有房源的区
        //租房价格最大值 最小值
        $maxprice = trim($this->request->param('maxprice'));
        if(isset($maxprice) && !empty($maxprice) && $maxprice){
            $where.=" and maxprice = ".$maxprice;
        }
        $mimprice = trim($this->request->param('minprice'));
        if(isset($mimprice) && !empty($mimprice) && $mimprice){
            $where.=" and mimprice = ".$mimprice;
        }
        //户型
        $house_room = trim($this->request->param('house_room'));
        if(isset($house_room) && !empty($house_room) && $house_room){
            $where.=" and house_room = '".$house_room."'";
        }
        //更多 房源特色，出租方式，性别，宠物，楼宇设施
        //出租方式
        //性别
        $sex = trim($this->request->param('sex'));
        if(isset($sex) && !empty($sex) && $sex){
            $where.=" and sex = '".$sex."'";
        }
        $type = trim($this->request->param('type'));
        if(isset($type) && !empty($type) && $type){
            $where.=" and type = '".$type."'";
        }
        $pet = trim($this->request->param('pet'));
        if(isset($pet) && !empty($pet) && $pet){
            $where.=" and pet = '".$pet."'";
        }
        //房源特色
        $tags = trim($this->request->param('tags'));
        if(isset($tags) && !empty($tags) && $tags){
            $where.=" and find_in_set('".$tags."',tags)";
        }
        //楼宇设施
        $home = trim($this->request->param('home'));
        if(isset($home) && !empty($home) && $home){
            $where.=" and find_in_set('".$home."',home)";
        }
        //宠物
        //楼宇设施
        $order = 'publish_date desc';
        $field = 'id,type,house_room,area,images,price,toilet,furniture,home,school,address,tj';
        $housem = new Housem();
        $house = $housem->readData($where,$order,'12','0',$field);
        if($house){
            foreach ($house as $k => $v){
                $house[$k]['title'] = $v['type'].''.$v['house_room'].''.$v['area'];
                $house[$k]['tj'] = $v['tj'] == '是' ? '推荐房源'  : '';
                $house[$k]['tingwei'] = $this->formatRoom($v['house_room']).''.$this->formatToilet($v['toilet']);
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $house;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '读取失败！';
        $res['data'] = $house;
        return json($res);
    }




    public function addHouse(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $data = $this->request->post();
        if($data){
            $res['code'] = 0;
            $res['msg'] = '缺少提交参数！';
            return json($res);
        }
        $data['source'] = '个人房源';
        //待审核3
        $data['status'] = '3';
        $data['cdate'] = date('Y-m-d H:i:s');
        $data['mdate'] = date('Y-m-d H:i:s');
        $housem = new Housem();
        $addHouse = $housem->addHouse($data);
        if($addHouse){
            $res['code'] = 1;
            $res['msg'] = '写入成功！';
            $res['id'] = $addHouse;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '写入失败！';
        return json($res);
    }


    public function editHouse(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $data = $this->request->post();
        if($data && $data['id'] <= 0){
            $res['code'] = 0;
            $res['msg'] = '缺少提交参数！';
            return json($res);
        }
        $data['mdate'] = date('Y-m-d H:i:s');
        $housem = new Housem();
        $addHouse = $housem->editHouse($data);
        if($addHouse){
            $res['code'] = 1;
            $res['msg'] = '修改成功！';
            $res['id'] = $addHouse;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '修改失败！';
        return json($res);
    }


    public function houseDetail(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id = trim($this->request->param('id'));
        if(!$id){
            $res['code'] = 2;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $housem = new Housem();
        $house = $housem->getHouse($id);
        if($house){
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $house;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '读取失败！';
        return json($res);
    }


    public function formatRoom($room){
//        一室，两室，三室，三室以上
        switch ($room){
            case '三室以上':
                $room = '多室';
                break;
        }
        return $room;
    }
    public function formatToilet($toilet){
        switch ($toilet){
//        1个；2个；3个；3个以上
            case '1个':
                $room = '一卫';
                break;
            case '2个':
                $room = '两卫';
                break;
            case '3个':
                $room = '三卫';
                break;
            case '3个以上':
                $room = '多卫';
                break;
            default:
                $room ='';
        }
        return $room;
    }





}