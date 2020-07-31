<?php
namespace app\api\controller;
use app\xcx\model\Housem;
use app\xcx\model\Loops;
use think\Controller;
use think\Db;
use think\Image;
use think\Log;
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
        $where = "status = 1 and is_del = 1 and city = '".$city."'";
        $area = trim($this->request->param('area'));
        $hot = trim($this->request->param('hot'));
        if(isset($area) && !empty($area) && $area){
            $where.=" and area = '".$area."'";
        }
        if(isset($hot) && !empty($hot) && $hot){
            $where.=" and area = '".$hot."'";
        }
        $keys = trim($this->request->param('keys'));
        if(isset($keys) && !empty($keys) && $keys){
            $where.=" and ( title like '%".$keys."%' or dsn like '%".$keys."%'  or school like '%".$keys."%' or city like '%".$keys."%')";
            //写入一条关键词查询记录
            if($uid){
                $this->addQueryLog($uid,$keys,1);
            }
        }
        //房屋类型
        $house_type = trim($this->request->param('house_type'));
        if(isset($house_type) && !empty($house_type) && $house_type){
            $where.=" and house_type = '".$house_type."'";
        }
        //租期发布多选，帅选单选
        $term = $this->request->param('lease_term');
        Log::write('获取房源参数lease_term：'.$term,'info');
        if(isset($term) && !empty($term) && $term){
            $where.=" and find_in_set('".$term."',lease_term)";
        }
        //学校
        $school = trim($this->request->param('school'));
        if(isset($school) && !empty($school) && $school){
            $where.=" and school = '".$school."'";
        }

        //是否包含家具
        $isFur = trim($this->request->param('is_fur'));
        if(isset($isFur) && !empty($isFur) && $isFur){
            $where.=" and is_fur = '".$isFur."'";
        }

        //所有有房源的区
        //租房价格最大值 最小值
        //租房价格最大值 最小值
        $maxprice = trim($this->request->param('maxprice','5000'));
        Log::write('租房价格最大值：'.$maxprice,'info');
        $mimprice = trim($this->request->param('minprice','0'));
        Log::write('租房价格最小值：'.$mimprice,'info');
        $maxprice = $maxprice ? $maxprice : '5000';
        $mimprice = $mimprice ? $mimprice : '0';
        if(isset($maxprice) && !empty($maxprice) && $maxprice){
            $where.=" and ( price <= ".$maxprice." ";
        }
        if(isset($mimprice)){
            $where.=" and price >= ".$mimprice."  or price = -1 )";
        }

        //入住时间最大值 最小值 mintime  结束    maxtime  左边加5天
        $mintime = trim($this->request->param('mintime'));
        $maxtime = trim($this->request->param('maxtime'));
        if((isset($mintime) && !empty($mintime) && $mintime) && !$maxtime){
            $mintime = date( 'Y-m-d', strtotime($mintime.' -5 days'));
            Log::write('入住时间最小值：'.$mintime,'info');
            $where.=" and (live_date >= '".$mintime."' or ( live_date = '0100-01-01' or live_date = '0000-00-00' ))";
        }

        if((isset($maxtime) && !empty($maxtime) && $maxtime) && !$mintime){
            Log::write('入住时间最大值：'.$maxtime,'info');
            $where.=" and (live_date  <= '".$maxtime."' or ( live_date = '0100-01-01' or live_date = '0000-00-00' ))";
        }
        if($mintime && $maxtime){
            Log::write('入住时间最小值：'.$mintime.'入住时间最大值'.$maxtime,'info');
            $where.= " and ((live_date >= '".$mintime."' and live_date  <= '".$maxtime."')  or ( live_date = '0100-01-01' or live_date = '0000-00-00' ))";
        }
        //户型  卧室
        $house_room = $this->request->param('house_room');
        Log::write('卧室house_room：'.$house_room,'info');
        if(isset($house_room) && !empty($house_room) && $house_room){
            if($house_room == '4+'){
                $where.=" and house_room > 4";
            }else{
                $where.=" and house_room = '".$house_room."'";
            }
        }
        //更多 房源特色，出租方式，性别，宠物，楼宇设施

        //性别
        $sex = trim($this->request->param('sex'));
        if(isset($sex) && !empty($sex) && $sex){
            $where.=" and ( sex = '限".$sex."' or sex = '不限' ) ";
        }
        //出租方式
        $type = trim($this->request->param('type'));
        if(isset($type) && !empty($type) && $type){
            $where.=" and type = '".$type."'";
        }
        $pet = trim($this->request->param('pet'));
        if(isset($pet) && !empty($pet) && $pet){
            $where.=" and ( pet = '".$pet."' or pet = '不限' )";
        }
        //卫生间
        $toilet = $this->request->param('toilet');
        if(isset($toilet) && !empty($toilet) && $toilet){
            if($toilet == '3+'){
                $where.=" and toilet > 3";
            }else{
                $where.=" and toilet = ".$toilet;
            }
        }
        //车位
        $car = $this->request->param('car');
        Log::write('车位car：'.$car,'info');
        if(isset($car) && !empty($car) && $car){
            if($car == '3+'){
                $where.=" and car > 3";
            }else{
                $where.=" and car = ".$car;
            }
        }
        //房源特色
        $tags = trim($this->request->param('tags'));
        if(isset($tags) && !empty($tags) && $tags){
            $where.=" and (";
            $tgs = explode(',',$tags);
            for($i=0;$i<count($tgs);$i++){
                if($i == (count($tgs)-1)){
                    $where.=" find_in_set('".$tgs[$i]."',tags)";
                }else{
                    $where.=" find_in_set('".$tgs[$i]."',tags) and ";
                }
            }
            $where.=" ) ";
        }
        //楼宇设施
        $home = trim($this->request->param('home'));
        if(isset($home) && !empty($home) && $home){
            $where.=" and (";
            $homes = explode(',',$home);
            for($i=0;$i<count($homes);$i++){
                if($i == (count($homes)-1)){
                    $where.=" find_in_set('".$homes[$i]."',furniture)";
                }else{
                    $where.=" find_in_set('".$homes[$i]."',furniture) and ";
                }
            }
            $where.=" ) ";
        }
        //宠物
        $limit = trim($this->request->param('limit','10'));
        $page = trim($this->request->param('page','0'));
        Log::write('前端用户：'.$uid.'进行了翻页，当前页码'.$page,'info');
        $order = trim($this->request->param('order','0'));
        $orders = '';
        if(isset($order)){
            switch ($order)
            {
                //时间倒序
                case 1:
                    $orders = 'cdate desc';
                    break;
                //时间顺序
                case 2:
                    $orders = 'cdate asc';
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
                    $orders = 'top desc,cdate desc';
            }
        }
        $order = $orders;
        $field = 'id,type,title,house_room,area,images,price,toilet,furniture,home,school,address,tj,top,mdate,tags,area,live_date,car,lease_term';
        $housem = new Housem();
        $house = $housem->readData($where,$order,$limit,$page,$field);
        //更新上次登录时间
        Db::table('tk_user')->where(['id' => $uid])->update(['mdate' =>date('Y-m-d H:i:s')]);
        if($house){
            foreach ($house as $k => $v){
                $house[$k]['tj'] = $v['tj'] == '是' ? '推荐房源'  : '';
                $house[$k]['tingwei'] = $this->formatRoom($v['house_room']).''.$this->formatToilet($v['toilet']);
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $house;
            $res['where'] = $where;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $house;
        $res['where'] = $where;
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
            $soup = new Soup();
            $soups =$soup->getSoup();
            $res['data']['soup'] = $soups;
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
    public function upload(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $path_date=date("Ym",time());
        $file = $_FILES['file']['name'];
        if($file){
            $file = $this->request->file('file');
            $config = [
                'size' => 1024*1024*10,
                'ext' => 'jpg,gif,png,bmp,jpeg,JPG,mp4,MP4'
            ];
            $size = $file->validate($config);
            if($size){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/house/'.$path_date.'/');
                if($info){
                    $path = 'uploads/house/'.$path_date.'/'.$info->getSaveName();
                    return json(array('code'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
                }else{
                    if($file->getError() == '上传文件大小不符！'){
                        return json(array('code'=>0,'path'=>'','msg'=> '文件大小超过10MB，请压缩后重新上传'));
                    }elseif ($file->getError() == '上传文件后缀不允许'){
                        return json(array('code'=>0,'path'=>'','msg'=> '系统仅支持jpg/bmp/gif/jpeg/png格式图片!'));
                    }else{
                        return json(array('code'=>0,'path'=>'','msg'=> '图片上传失败,请联系管理员！<br/>错误信息：'.$file->getError()));
                    }
                }
            }else{
                return json(array('code'=>0,'path'=>'','msg'=> '文件大小不超过10M，或格式错误！'));
            }
        }else{
            return json(array('code'=>0,'path'=>'','msg'=> '没有接收到文件,请重试！'));
        }
    }

    public function delImg(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $img = trim($this->request->param('img'));
        $path_date=date("Ym",time());
        $path_time = date("Ymd",time());
        $file = 'uploads/house/'.$path_date.'/'.$path_time.'/'.$img;
        if(file_exists($file)){
            if (!unlink($file)){
                $res['code'] = 0;
                $res['msg'] = '文件删除失败！';
            }else{
                $res['code'] = 1;
                $res['msg'] = '删除成功！';
            }
        }else{
            $res['code'] = 0;
            $res['msg'] = '文件不存在！';
        }
        return json($res);
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
        $where = "(is_del =1 and user_id = ".$uid." and is_admin = 1 )";
        $isBindAdmin = $this->isBindAdmin($uid);
        if($isBindAdmin){
            $where.=" or (is_del =1 and user_id = ".$isBindAdmin['ad_id']." and is_admin = 2)";
        }
        $order = 'mdate desc';
        $field = 'id,user_id,title,type,house_room,area,images,price,status,home,address';
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

    public function isBindAdmin($uid){
        $isBind = Db::table('super_admin')
            ->where(['ad_wechat' => $uid])
            ->field('ad_id')
            ->find();
        return $isBind ? $isBind : null;
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
        $uid = trim($this->request->param('uid','0'));
        $limit = trim($this->request->param('limit','10'));
        $page = trim($this->request->param('page','0'));
        if($uid == 0){
            $res['code'] = 1;
            $res['msg'] = '数据为空！';
            return json($res);
        }
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


    /***
     * 参数uid = 0  非必选
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function myQuery(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = trim($this->request->param('uid',0));
        if ($uid == 0) {
            $res['code'] = 1;
            $res['msg'] = '数据为空！';
            return json($res);
        }
        $list = Db::table('xcx_search_keywords')
            ->where(['sk_userid' => $uid,'sk_type' => 1])
            ->limit(10)
            ->field('sk_keywords')
            ->order('sk_id desc')
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
        //更新上次登录时间
        Db::table('tk_user')->where(['id' => $uid])->update(['mdate' =>date('Y-m-d H:i:s')]);
        return $resault;
    }


    public function del(){
        $id = trim($this->request->param('id'));
        if (!@$id) {
            $res['code'] = 0;
            $res['msg'] = 'id不能为空！';
            return json($res);
        }
        $one = Db::table('tk_houses')
            ->where(['id' => $id])->field('id')->find();
        if(!$one){
            $res['code'] = 0;
            $res['msg'] = '此房源不存在！';
            return json($res);
        }
        $del = Db::table('tk_houses')
            ->where(['id' => $id])
            ->update(['is_del' => 2]);
        if($del){
            $res['code'] = 1;
            $res['msg'] = '删除成功！';
            return json($res);
        }else{
            $res['code'] = 0;
            $res['msg'] = '删除失败！';
            return json($res);
        }
    }


    /***
     * 房源详情简易版
     * 2020年7月15日11:16:16
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function myDetail(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $id = trim($this->request->param('id'));
        if(!$id){
            $res['code'] = 2;
            $res['msg'] = '缺少参数！';
            return json($res);
        }
        $house = Db::table('tk_houses')
            ->where(['id' => $id])
            ->field('id,title,city,area,price,type,status,house_room,car,toilet,user_id,is_admin')
            ->find();
        if (empty($house)) {
            $res['code'] = 0;
            $res['msg'] = '该房源已经不存在了';
            $res['data'] = null;
            return $res;
        }
        if($house['status'] != 1){
            $res['code'] = 0;
            $res['msg'] = '改房源已被外星人劫持！';
            return json($res);
        }
        if($house){
            $loop = new Loops();
            $house['house_room'] =  $this->houseRoom($house['house_room']);
            $house['nickname'] =  $loop->getUserNicks($house['user_id'],$house['is_admin']);
            $house['avatar'] =  $loop->getUserAvatars($house['user_id'],$house['is_admin']);
            $house['car'] =  $house['car'].'车位';
            $house['suburb'] =  $house['city'].' '.$house['area'];
            $house['toilet'] = $house['toilet'].'卫';
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $house;
//            $soup = new Soup();
//            $soups =$soup->getSoup();
//            $res['data']['soup'] = $soups;
            return json($res);
        }
        $res['code'] = 0;
        $res['msg'] = '读取失败！';
        return json($res);
    }


    public function houseRoom($room){
        if($room == 0){
            $type = 'Studio';
        }else{
            $type = $room.'室';
        }
        return $type;
    }

    public function hotSech(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $pid = trim($this->request->param('pid',27));
        $hotSer = Db::table('tk_cate')
            ->where(['hot' => '是','pid' => $pid])
            ->field('id,name')
            ->order('name asc')
            ->select();
        if($hotSer){
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['data'] = $hotSer;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        return json($res);
    }
}