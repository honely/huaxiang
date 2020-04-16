<?php
namespace app\api\controller;
use app\xcx\model\Housem;
use think\Controller;
use think\Db;

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
        $uid = trim($this->request->param('uid'));
        $city = trim($this->request->param('city','墨尔本'));
        //区域里面  热门  学校  所有区
        //热门区域
        $where = "status = 1 and city = '".$city."'";
        $area = trim($this->request->param('area'));
        if(isset($area) && !empty($area) && $area){
            $where.=" and area = '".$area."'";
        }
        $keys = trim($this->request->param('keys'));
        if(isset($keys) && !empty($keys) && $keys){
            $where.=" and ( title like '%".$keys."%' or dsn like '%".$keys."%'  or school like '%".$keys."%' or city like '%".$keys."%')";
            //写入一条关键词查询记录
            $this->addQueryLog($uid,$keys,1);
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
            $where.=" and price <= ".$maxprice;
        }
        $mimprice = trim($this->request->param('minprice'));
        if(isset($mimprice) && !empty($mimprice) && $mimprice){
            $where.=" and price >= ".$mimprice;
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
        //toilet
        $pet = trim($this->request->param('toilet'));
        if(isset($pet) && !empty($pet) && $pet){
            $where.=" and toilet = '".$pet."'";
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
        $limit = trim($this->request->param('limit','10'));
        $page = trim($this->request->param('page','0'));
        $order = trim($this->request->param('order','0'));
        $orders = '';
        if(isset($order)){
            switch ($order)
            {
                //时间倒序
                case 1:
                    $orders = 'mdate desc';
                    break;
                //时间顺序
                case 2:
                    $orders = 'mdate asc';
                    break;
                //价格倒序
                case 3:
                    $orders = 'price desc';
                    break;
                //价格顺序
                case 4:
                    $orders = 'price asc';
                    break;
                default:
                    $orders = 'top desc,mdate desc';
            }
        }
        $order = $orders;
        $field = 'id,type,title,house_room,area,images,price,toilet,furniture,home,school,address,tj,top,mdate';
        $housem = new Housem();
        $house = $housem->readData($where,$order,$limit,$page,$field);
        if($house){
            foreach ($house as $k => $v){
                $house[$k]['tj'] = $v['tj'] == '是' ? '推荐房源'  : '';
                $house[$k]['tingwei'] = $this->formatRoom($v['house_room']).''.$this->formatToilet($v['toilet']);
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $house;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $house;
        return json($res);
    }




    public function addHouse(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $data = $this->request->post();
        if(!$data){
            $res['code'] = 0;
            $res['msg'] = '缺少提交参数！';
            return json($res);
        }
        $data['source'] = '个人房源';
        $data['status'] = 1;
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
        $uid = trim($this->request->param('uid'));
        if(!$id){
            $res['code'] = 2;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $housem = new Housem();
        $house = $housem->getHouse($id,$uid);
        if($house){
            $res['code'] = $house['code'];
            $res['msg'] = $house['msg'];
            $res['data'] = $house['data'];
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




    /***
     * 网站端房源图片上传，通用这个一个接口
     * @return \think\response\Json
     * Dangmengmeng 2019年12月5日09:42:24
     */
    public function upload()
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $path_date=date("Ym",time());
        $file = $_FILES['file']['name'];
        if($file){
            $file = $this->request->file('file');
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/house/'.$path_date.'/');
            if($file){
                $path = 'uploads/house/'.$path_date.'/'.$info->getSaveName();
                return json(array('code'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
            }else{
                return json(array('code'=>0,'path'=>'','msg'=> '图片上传失败！'));
            }
        }
    }


    /***
     * 我发布的房源
     * title 时间  封面图 id  状态
     */
    public function my(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = intval(trim($this->request->param('uid')));
        if(!$uid){
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        $limit = trim($this->request->param('limit','10'));
        $page = trim($this->request->param('page','0'));
        $where = "(status >=1 and user_id = '".$uid."')";
        $order = 'publish_date desc';
        $field = 'id,user_id,title,type,house_room,area,images,price,status,home';
        $housem = new Housem();
        $house = $housem->readData($where,$order,$limit,$page,$field);
        if($house){
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $house;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $house;
        return json($res);
    }


    public function getArea(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $city = trim($this->request->param('city','墨尔本'));
        $result = Db::table('tk_houses')
            ->where(['city' => $city])
            ->where("area != ''")
            ->group('area')
            ->field('area')
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

    public function history(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = trim($this->request->param('uid'));
        $limit = trim($this->request->param('limit','10'));
        $page = trim($this->request->param('page','0'));
        $where = "(user_id = '".$uid."')";
        $order = 'publish_date desc';
        $field = 'id,type,title,house_room,area,images,price,status,home';
        $housem = new Housem();
        $house = $housem->readData($where,$order,$limit,$page,$field);
        if($house){
            foreach ($house as $k => $v){
//                $house[$k]['title'] = $v['type'].''.$v['house_room'].''.$v['area'];

            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $house;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $house;
        return json($res);
    }
    public function sucess($code, $msg = '', $data = '') {
        $arr['code'] = $code;
        $arr['msg'] = $msg;
        $arr['data'] = $data;
        echo json_encode($arr);exit;
    }

    public function topQuery(){
        $data = input('param.');
        if (!@$data['city']) {
            $res['code'] = 0;
            $res['msg'] = '城市不能为空！';
            return json($res);
        }
        $condition['city'] = $data['city'];
        $condition['status'] = 1;
        $list = Db::table('tk_keyword')->where($condition)->field('name')->order('id DESC')->select();
        if($list){
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $list;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $list;
        return json($res);
    }

    public function myQuery(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = trim($this->request->param('uid'));
        if (!@$uid) {
            $res['code'] = 0;
            $res['msg'] = '用户id不能为空！';
            return json($res);
        }
        $list = Db::table('xcx_search_keywords')
            ->where(['sk_userid' => $uid,'sk_type' => 1])
            ->limit(10)
            ->field('sk_keywords')
            ->select();
        if($list){
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $list;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $list;
        return json($res);
    }


    public function addQueryLog($uid,$key,$type){
        $data['sk_keywords'] = $key;
        $data['sk_userid'] = $uid;
        $data['sk_type'] = $type;
        $data['sk_addtime'] = date('Y-m-d H:i:s');
        $resault = Db::table('xcx_search_keywords')->insertGetId($data);
        return $resault;
    }
}