<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/9/9
 * Time: 10:11
 * Name: 房源管理
 */
namespace app\xcx\controller;
use app\admin\model\Commons;
use app\xcx\model\Loops;
use app\xcx\model\Rolem;
use think\Controller;
use think\Db;
use think\Request;

class House extends Controller{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $adminName=session('adminName');
        if(empty($adminName)){
            $this->error('请先登录！','login/login');
        }
        if(isset($_SESSION['expiretime'])) {
            if($_SESSION['expiretime'] < time()) {
                unset($_SESSION['expiretime']);
                $this->error('您的登录身份已过期，请重新登录！','login/login');
                exit(0);
            } else {
                $_SESSION['expiretime'] = time() + 1800; // 刷新时间戳
            }
        }
    }
    /*
     * 房源管理
     *
     * */
    public function index(){
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $addable = in_array('230',$power_list,true);
        $editable = in_array('232',$power_list,true);
        $delable = in_array('233',$power_list,true);
        $topable = in_array('241',$power_list,true);
        $tjable = in_array('240',$power_list,true);
        $offable = in_array('279',$power_list,true);
        $this->assign('addable',$addable);
        $this->assign('editable',$editable);
        $this->assign('delable',$delable);
        $this->assign('topable',$topable);
        $this->assign('tjable',$tjable);
        $this->assign('offable',$offable);
        $cityinfo = Db::table('tk_cate')->where(['pid' =>0])->select();
        $this->assign('cityinfo',$cityinfo);
        return $this->fetch();
    }
    public function getUserPowerId($roleIds){
        $roleArr = explode(',',$roleIds);
        $roleNames = '';
        for ($i = 0;$i < count($roleArr);$i++){
            $roleName = $this->getRole($roleArr[$i]);
            $roleNames.= $roleName.',';
        }
        return rtrim($roleNames,',');
    }

    public function getRole($roleid){
        $roleInfo = Db::table('super_role')
            ->where(['r_id' => $roleid])
            ->field('r_power')
            ->find();
        return $roleInfo['r_power'];
    }
    public function houseData(){
        $where =' 1 = 1';
        $keywords = trim($this->request->param('keywords'));
        $time = trim($this->request->param('time'));
        $city = trim($this->request->param('city'));
        $area = trim($this->request->param('area'));
        $status = trim($this->request->param('status'));
        $address = trim($this->request->param('address'));
        $top = trim($this->request->param('top'));
        $tj = trim($this->request->param('tj'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( title like '%".$keywords."%' or dsn like '%".$keywords."%' )";
        }
        if(isset($city) && !empty($city) && $city){
            $where.=" and city = '".$city."'";
        }
        if(isset($area) && !empty($area) && $area){
            $where.=" and area = '".$area."'";
        }if(isset($top) && !empty($top) && $top){
            if($top == '是'){
                $where.=" and top = '".$top."'";
            }
        }if(isset($tj) && !empty($tj) && $tj){
            if($tj == '是'){
                $where.=" and tj = '".$tj."'";
            }
        }
        if(isset($address) && !empty($address) && $address){
            $where.=" and address like '%".$address."%'";
        }
        if(isset($status) && !empty($status) && $status){
            $where.=" and status = ".$status;
        }

        if(isset($time) && !empty($time)){
            $sdate=substr($time,'0','10')." 00:00:00";
            $edate=substr($time,'-10')." 23:59:59";
            $where.=" and ( cdate >= '".$sdate."' and cdate <= '".$edate."' ) ";
        }
        $count=Db::table('tk_houses')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $order = 'top desc,cdate desc';
        $orderv = trim($this->request->param('orderv'));
        $orderc = trim($this->request->param('orderc'));
        if(isset($orderv) && !empty($orderv) && $orderv){
            if($orderv == 1){
                $order ="view desc";
            }else{
                $order ="view asc";
            }
        }
        if(isset($orderc) && !empty($orderc) && $orderc){
            if($orderc == 1){
                $order ="collection desc";
            }else{
                $order ="collection asc";
            }
        }
        $design=Db::table('tk_houses')
            ->limit(($page-1)*$limit,$limit)
            ->order($order)
            ->where($where)
            ->select();
        $designs=Db::table('tk_houses')
            ->limit(($page-1)*$limit,$limit)
            ->order($order)
            ->where($where)
            ->fetchSql(true)
            ->select();
//        dump($design);
        $loopd = new Loops();
        foreach ($design as $k => $v){
            $design[$k]['statuss'] = $this->houseStatus($v['status']);
            $design[$k]['cdate'] = date('m-d H:i',strtotime($v['cdate']));
            $design[$k]['user_id'] = $loopd->getUserNicks($v['user_id'],$v['is_admin']);
            $design[$k]['isTop'] = $this->greaterTops($v['id']);
            $design[$k]['isTj'] = $this->greaterTjs($v['id']);
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        $res['where'] = $designs;
        return json($res);
    }

    public function getarea(){
        $city = trim($this->request->param('city','墨尔本'));
        $cityNames = Db::table('tk_houses')
            ->where(['city' => $city])
            ->where("area != ''")
            ->group('area')
            ->field('id,area')
            ->select();
        if($cityNames){
            return  json(['code' => '1','data' => $cityNames]);
        }else{
            return  json(['code' => '0','data' => ['']]);
        }
    }
    /*
     * 房源添加
     * */
    public function add(){
        $adminId = session('adminId');
        if($_POST){
            $data = $_POST;
            if(isset($_POST['http']) && $_POST['http']){
                $isRepeat = Db::table('tk_houses')
                    ->where(['http' => $data['http']])
                    ->find();
                if($isRepeat){
                    $this->error('此房源已添加！');
                }
            }
            if(isset($_POST['bill']) && $_POST['bill']){
                $bill = $_POST['bill'];
                $bills = '';
                foreach($bill as $key => $val){
                    $bills .= $key.',';
                }
                $data['bill'] = rtrim($bills,',');
            }else{
                $data['bill'] ='';
            }
            if(isset($_POST['home']) && $_POST['home']){
                $home = $_POST['home'];
                $homes = '';
                foreach($home as $key => $val){
                    $homes .= $key.',';
                }
                $data['home'] = rtrim($homes,',');
            }else{
                $data['home'] ='';
            }
            if(isset($_POST['furniture']) && $_POST['furniture']){
                $furn = $_POST['furniture'];
                $furns = '';
                foreach($furn as $key => $val){
                    $furns .= $key.',';
                }
                $data['furniture'] = rtrim($furns,',');
            }else{
                $data['furniture'] ='';
            }
            if(isset($_POST['tags']) && $_POST['tags']){
                $tags = $_POST['tags'];
                $furnss = '';
                foreach($tags as $key => $val){
                    $furnss .= $key.',';
                }
                $data['tags'] = rtrim($furnss,',');
            }else{
                $data['tags'] ='';
            }
            if(isset($_POST['sation']) && $_POST['sation']){
                $sation = $_POST['sation'];
                $sations = '';
                foreach($sation as $key => $val){
                    $sations .= $key.',';
                }
                $data['sation'] = rtrim($sations,',');
            }else{
                $data['sation'] ='';
            }
            if(isset($_POST['images']) && $_POST['images']){
                $img=$_POST['images'];
                $h_img='';
                for ($i=0;$i<sizeof($img);$i++){
                    $h_img.=$img[$i].",";
                }
                $data['images'] = rtrim($h_img,',');
            }else{
                $data['images'] ='';
            }
            $data['publish_date'] = date('Y-m-d H:i:s');
            $data['cdate'] = date('Y-m-d H:i:s');
            $data['mdate'] = date('Y-m-d H:i:s');
            $data['status'] = 1;
            $data['city'] = $this->getCityName($_POST['city']);
            unset($data['file']);
            $data['dsn'] = $this->genHouseDsn();
            $data['user_id'] = $adminId;
            $data['is_admin'] = 2;
            if(isset($data['address'])){
                $data['area'] = trim(explode(',',$data['address'])[1]);
            }
            $add=Db::table('tk_houses')->insert($data);
            if($add){
                $this->success('添加成功！');
            }else{
                $this->error('添加失败！');
            }
        }else{
            $adminId = session('adminId');
            $adminInfo = Db::table('super_admin')
                ->where(['ad_id' => $adminId])
                ->field('ad_realname,ad_email,ad_weixin,ad_phone')
                ->find();
            $this->assign('admin',$adminInfo);
            $city = Db::table('tk_cate')->where(['pid' => 0])->select();
            $this->assign('city',$city);
            $all_tags = Db::table('xcx_tags')
                ->where(['type' => 1])
                ->field('id,name')
                ->select();
            $this->assign('tags',$all_tags);
            return $this->fetch();
        }

    }

    public function getCityName($id){
        $city = Db::table('tk_cate')->where(['id' =>$id])->field('name')->find();
        return $city ? $city['name'] : '未知城市';
    }

    //重新生成找室友编码
    private function genHouseDsn()
    {
        $dsn = 'A';
        $max =$this->max();
        $s = '';
        for ($i = 1; $i < 10 - strlen($max); $i++) {
            $s .= '0';
        }
        $max++;
        $dsn .= $s.$max;
        return $dsn;
    }

    public function max(){
        $max = Db::table('tk_houses')->order('id desc')->find();
        return $max['id'] ? $max['id'] : 0;
    }

    public function getSchools($city){
        $cid = Db::table('tk_cate')
            ->where(['name' => $city,'pid' => 0])
            ->field('id')
            ->find();
        $city = Db::table('tk_cate')
            ->where(['pid' => $cid['id'],'type' => 2])
            ->order(['id' => 'asc'])
            ->select();
        return $city;
    }

    public function getSchool(){
        $id = $this->request->param('id',0,'intval');
        $city = Db::table('tk_cate')
            ->where(['pid' => $id,'type' => 2])
            ->order(['id' => 'asc'])
            ->select();
        if($city){
            return  json(['code' => '1','data' => $city]);
        }else{
            return  json(['code' => '0','data' => ['']]);
        }
    }

    public function getAddress(){
        $query = $this->request->param('id',22,'intval');
        $App_id = "QuHxU6ypXzp37Dci84o8";
        $app_code = "TDu_enlm0QIblRnIl33buw";
        $url =  "https://autocomplete.geocoder.api.here.com/6.2/suggest.json?query=".$query."app_id=".$App_id."&app_code=".$app_code."&country=AUS";
        $res = file_get_contents($url);
        dump($res);

    }

    /***
     * 发布状态 1：已发布；2：下线；3待审核；4。审核不通过；5草稿箱
     * @param $status
     * @return string
     * dangmengmeng 2019年12月5日10:34:15
     */
    public function houseStatus($status){
        switch ($status)
        {
            case 1:
                $type = '发布';
                break;
            case 2:
                $type = '下线';
                break;
            default:
                $type = '---';
        }
        return $type;
    }
    /*
     * 房源修改
     * */
    public function edit(){
        $id = $this->request->param('id',22,'intval');
        $type = $this->request->get('type');
        if($_POST){
            $data = $_POST;
            if(isset($_POST['http']) && $_POST['http']){
                $isRepeat = Db::table('tk_houses')
                    ->where(['http' => $data['http']])
                    ->where('id != '.$id)
                    ->find();
                if($isRepeat){
                    $this->error('此房源已添加！');
                }
            }
            if(isset($_POST['bill']) && $_POST['bill']){
                $bill = $_POST['bill'];
                $bills = '';
                foreach($bill as $key => $val){
                    $bills .= $key.',';
                }
                $data['bill'] = rtrim($bills,',');
            }else{
                $data['bill'] ='';
            }
            if(isset($_POST['home']) && $_POST['home']){
                $home = $_POST['home'];
                $homes = '';
                foreach($home as $key => $val){
                    $homes .= $key.',';
                }
                $data['home'] = rtrim($homes,',');
            }else{
                $data['home'] ='';
            }
            if(isset($_POST['furniture']) && $_POST['furniture']){
                $furn = $_POST['furniture'];
                $furns = '';
                foreach($furn as $key => $val){
                    $furns .= $key.',';
                }
                $data['furniture'] = rtrim($furns,',');
            }else{
                $data['furniture'] ='';
            }
            if(isset($_POST['tags']) && $_POST['tags']){
                $tags = $_POST['tags'];
                $furnss = '';
                foreach($tags as $key => $val){
                    $furnss .= $key.',';
                }
                $data['tags'] = rtrim($furnss,',');
            }else{
                $data['tags'] ='';
            }
            if(isset($_POST['sation']) && $_POST['sation']){
                $sation = $_POST['sation'];
                $sations = '';
                foreach($sation as $key => $val){
                    $sations .= $key.',';
                }
                $data['sation'] = rtrim($sations,',');
            }else{
                $data['sation'] ='';
            }
            if(isset($_POST['images']) && $_POST['images']){
                $img=$_POST['images'];
                $h_img='';
                for ($i=0;$i<sizeof($img);$i++){
                    $h_img.=$img[$i].",";
                }
                $data['images'] = rtrim($h_img,',');
            }else{
                $data['images'] ='';
            }
            $data['city'] = $this->getCityName($_POST['city']);
            $data['publish_date'] = date('Y-m-d H:i:s');
            $data['mdate'] = date('Y-m-d H:i:s');
            unset($data['file']);
            $url = $type == 1 ? 'index' : 'myhouse';
            $add=Db::table('tk_houses')->where(['id' => $id])->update($data);
            if($add){
                $this->success('修改成功！',$url);
            }else{
                $this->error('修改失败！',$url);
            }
        }else{
            $houseInfo = Db::table('tk_houses')->where(['id' => $id])->find();
            $all_bill = [
                [
                    'bill' => '包水',
                    'is_checked' => false
                ],
                [
                    'bill' => '包电',
                    'is_checked' => false
                ],
                [
                    'bill' => '包气',
                    'is_checked' => false
                ],
                [
                    'bill' => '包网',
                    'is_checked' => false
                ]
            ];
            if($houseInfo['bill']){
                $houseBill = explode(',',$houseInfo['bill']);
                foreach ($all_bill as $key => &$val) {
                    if(in_array($val['bill'], $houseBill)) {
                        $val['is_checked'] = true;
                    }
                }unset($val);
                $houseInfo['bill'] = $houseBill;
            }


            $all_set = [
                [
                    'set' => '游泳池',
                    'is_checked' => false
                ],
                [
                    'set' => '健身房',
                    'is_checked' => false
                ],
                [
                    'set' => '电影院',
                    'is_checked' => false
                ],
                [
                    'set' => '花园',
                    'is_checked' => false
                ],
                [
                    'set' => '门禁',
                    'is_checked' => false
                ],
                [
                    'set' => '前台',
                    'is_checked' => false
                ],
                [
                    'set' => '桑拿',
                    'is_checked' => false
                ]
            ];
            if($houseInfo['furniture']){
                $houseSet = explode(',',$houseInfo['furniture']);
                foreach ($all_set as $key => &$val) {
                    if(in_array($val['set'], $houseSet)) {
                        $val['is_checked'] = true;
                    }
                }unset($val);
                $houseInfo['furniture'] = $houseSet;
            }
            $all_trans = [
                [
                    'trans' => '巴士站',
                    'is_checked' => false
                ],
                [
                    'trans' => '火车站',
                    'is_checked' => false
                ],
                [
                    'trans' => '电车站',
                    'is_checked' => false
                ],
                [
                    'trans' => '餐馆',
                    'is_checked' => false
                ],
                [
                    'trans' => '公园',
                    'is_checked' => false
                ],
                [
                    'trans' => '警察局',
                    'is_checked' => false
                ],
                [
                    'trans' => '医院',
                    'is_checked' => false
                ],
                [
                    'trans' => '超市',
                    'is_checked' => false
                ]
            ];
            if($houseInfo['sation']){
                $houseTrans= explode(',',$houseInfo['sation']);
                foreach ($all_trans as $key => &$val) {
                    if(in_array($val['trans'], $houseTrans)) {
                        $val['is_checked'] = true;
                    }
                }unset($val);
                $houseInfo['sub'] = $houseTrans;
            }
            $allFours = [
                [
                    'furn' => '床',
                    'is_checked' => false
                ],
                [
                    'furn' => '沙发',
                    'is_checked' => false
                ],[
                    'furn' => '餐桌',
                    'is_checked' => false
                ],[
                    'furn' => '椅子',
                    'is_checked' => false
                ],[
                    'furn' => 'WIFI',
                    'is_checked' => false
                ],[
                    'furn' => '空调',
                    'is_checked' => false
                ],[
                    'furn' => '洗衣机',
                    'is_checked' => false
                ],[
                    'furn' => '冰箱',
                    'is_checked' => false
                ],[
                    'furn' => '微波炉',
                    'is_checked' => false
                ],[
                    'furn' => '暖气',
                    'is_checked' => false
                ],[
                    'furn' => '电烤箱',
                    'is_checked' => false
                ],
                [
                    'furn' => '洗碗机',
                    'is_checked' => false
                ]
            ];
            $houseFor= explode(',',$houseInfo['home']);
            foreach ($allFours as $key => &$val) {
                if(in_array($val['furn'], $houseFor)) {
                    $val['is_checked'] = true;
                }
            }unset($val);
            $Tags= explode(',',$houseInfo['tags']);
            $all_tags = Db::table('xcx_tags')
                ->where(['type' => 1])
                ->field('id,name')
                ->select();
            foreach ($all_tags as $key => &$val) {
                $all_tags[$key]['is_checked'] = false;
                if(in_array($val['name'], $Tags)) {
                    $val['is_checked'] = true;
                }
            }unset($val);
            $this->assign('tags',$all_tags);
            $houseInfo['home'] = $houseFor;
            $houseInfo['images1'] = explode(',',$houseInfo['images']);
            if($houseInfo['live_date'] == '0000-00-00' || $houseInfo['live_date'] == '0100-01-01'){
                $show = 1;
            }else{
                $show = 2;
            }
            $houseInfo['live_date_show'] =$show;
            $city = Db::table('tk_cate')->where(['pid' => 0])->select();
            $shcool = $this->getSchools($houseInfo['city']);
            $this->assign('all_bill',$all_bill);
            $this->assign('all_trans',$all_trans);
            $this->assign('all_set',$all_set);
            $this->assign('all_four',$allFours);
            $this->assign('city',$city);
            $this->assign('type',$type);
            $this->assign('school',$shcool);
            $this->assign('house',$houseInfo);
            return $this->fetch();
        }
    }



    //更改是否显示的状态
    public function status(){
        $ba_id = intval(trim($_GET['id']));
        $change = intval(trim($_GET['change']));
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                //查询当前城市的房源置顶数量是否超过五个
                $isBeyound = $this->greaterTop($ba_id);
                if(!$isBeyound){
                    $res['code'] =0;
                    $res['msg'] ='置顶失败！此城市的置顶数量已达上限，请取消别的置顶再置顶此房源！';
                    return $res;
                }
                $msg = '置顶';
                $data['top'] = '是';
            }else{
                $msg = '取消置顶';
                $data['top'] = '否';
            }
            $changeStatus = Db::table('tk_houses')->where(['id' => $ba_id])->update($data);
            if($changeStatus){
                $res['code'] = 1;
                $res['msg'] = $msg.'成功！';
            }else{
                $res['code'] = 0;
                $res['msg'] = $msg.'失败！';
            }
        }else{
            $res['code'] = 0;
            $res['msg'] = '这是个意外！';
        }
        return $res;
    }


    //更改是否显示的状态
    public function tjstatus(){
        $ba_id = intval(trim($_GET['id']));
        $change = intval(trim($_GET['change']));
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                //查询当前城市的房源置顶数量是否超过五个
                $isBeyound = $this->greaterTj($ba_id);
                if(!$isBeyound){
                    $res['code'] =0;
                    $res['msg'] ='推荐失败！此城市的推荐数量已达上限！';
                    return $res;
                }
                $msg = '推荐';
                $data['tj'] = '是';
            }else{
                $msg = '取消推荐';
                $data['tj'] = '否';
            }
            $changeStatus = Db::table('tk_houses')->where(['id' => $ba_id])->update($data);
            if($changeStatus){
                $res['code'] = 1;
                $res['msg'] = $msg.'成功！';
            }else{
                $res['code'] = 0;
                $res['msg'] = $msg.'失败！';
            }
        }else{
            $res['code'] = 0;
            $res['msg'] = '这是个意外！';
        }
        return $res;
    }


    //更改是否显示的状态
    public function onstatus(){
        $ba_id = intval(trim($_GET['id']));
        $change = intval(trim($_GET['change']));
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '上线';
                $data['status'] = 1;
            }else{
                $msg = '下线';
                $data['status'] = 2;
            }
            $changeStatus = Db::table('tk_houses')->where(['id' => $ba_id])->update($data);
            if($changeStatus){
                $res['code'] = 1;
                $res['msg'] = $msg.'成功！';
            }else{
                $res['code'] = 0;
                $res['msg'] = $msg.'失败！';
            }
        }else{
            $res['code'] = 0;
            $res['msg'] = '这是个意外！';
        }
        return $res;
    }


    /***
     * @param $id int  房源id
     * @return bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function greaterTop($id){
        $houseCity = Db::table('tk_houses')
            ->where(['id' => $id])
            ->field('city,top')
            ->find();
        $count =Db::table('tk_houses')
            ->where(['city' => $houseCity['city'],'top' => '是'])
            ->count();
        return $count >=5 ? false : true;
    }
    public function greaterTops($id){
        $houseCity = Db::table('tk_houses')
            ->where(['id' => $id])
            ->field('city,top')
            ->find();
        $count =Db::table('tk_houses')
            ->where(['city' => $houseCity['city'],'top' => '是'])
            ->count();
        if($count>=5 && $houseCity['top'] == '否'){
            return false;
        }
        return true;
    }
    public function greaterTj($id){
        $houseCity = Db::table('tk_houses')
            ->where(['id' => $id])
            ->field('city')
            ->find();
        $count =Db::table('tk_houses')
            ->where(['city' => $houseCity['city'],'tj' => '是'])
            ->count();
        return $count >=10 ? false : true;
    }

    public function greaterTjs($id){
        $houseCity = Db::table('tk_houses')
            ->where(['id' => $id])
            ->field('city,tj')
            ->find();
        $count =Db::table('tk_houses')
            ->where(['city' => $houseCity['city'],'tj' => '是'])
            ->count();
        if($count >=10 && $houseCity['tj'] == '否'){
            return false;
        }
        return true;
    }

    public function detail(){
        $id = $this->request->param('id',22,'intval');
        $houseInfo = Db::table('tk_houses')->where(['id' => $id])->find();
        $all_bill = [
            [
                'bill' => '包水',
                'is_checked' => false
            ],
            [
                'bill' => '包电',
                'is_checked' => false
            ],
            [
                'bill' => '包气',
                'is_checked' => false
            ],
            [
                'bill' => '包网',
                'is_checked' => false
            ]
        ];
        $houseBill = explode(',',$houseInfo['bill']);
        foreach ($all_bill as $key => &$val) {
            if(in_array($val['bill'], $houseBill)) {
                $val['is_checked'] = true;
            }
        }unset($val);
        $houseInfo['sub'] = $houseBill;

        $all_set = [
            [
                'set' => '游泳池',
                'is_checked' => false
            ],
            [
                'set' => '健身房',
                'is_checked' => false
            ],
            [
                'set' => '电影院',
                'is_checked' => false
            ],
            [
                'set' => '花园',
                'is_checked' => false
            ],
            [
                'set' => '门禁',
                'is_checked' => false
            ],
            [
                'set' => '前台',
                'is_checked' => false
            ],
            [
                'set' => '桑拿',
                'is_checked' => false
            ]
        ];
        $houseSet = explode(',',$houseInfo['furniture']);
        foreach ($all_set as $key => &$val) {
            if(in_array($val['set'], $houseSet)) {
                $val['is_checked'] = true;
            }
        }unset($val);
        $houseInfo['furniture'] = $houseSet;
        $all_trans = [
            [
                'trans' => '巴士站',
                'is_checked' => false
            ],
            [
                'trans' => '火车站',
                'is_checked' => false
            ],
            [
                'trans' => '电车站',
                'is_checked' => false
            ],
            [
                'trans' => '餐馆',
                'is_checked' => false
            ],
            [
                'trans' => '公园',
                'is_checked' => false
            ],
            [
                'trans' => '警察局',
                'is_checked' => false
            ],
            [
                'trans' => '医院',
                'is_checked' => false
            ],
            [
                'trans' => '超市',
                'is_checked' => false
            ]
        ];
        $houseTrans= explode(',',$houseInfo['sation']);
        foreach ($all_trans as $key => &$val) {
            if(in_array($val['trans'], $houseTrans)) {
                $val['is_checked'] = true;
            }
        }unset($val);
        $houseInfo['sub'] = $houseTrans;

        $allFours = [
            [
                'furn' => '床',
                'is_checked' => false
            ],
            [
                'furn' => '沙发',
                'is_checked' => false
            ],[
                'furn' => '餐桌',
                'is_checked' => false
            ],[
                'furn' => '椅子',
                'is_checked' => false
            ],[
                'furn' => 'WIFI',
                'is_checked' => false
            ],[
                'furn' => '空调',
                'is_checked' => false
            ],[
                'furn' => '洗衣机',
                'is_checked' => false
            ],[
                'furn' => '冰箱',
                'is_checked' => false
            ],[
                'furn' => '微波炉',
                'is_checked' => false
            ],[
                'furn' => '暖气',
                'is_checked' => false
            ],[
                'furn' => '电烤箱',
                'is_checked' => false
            ],
            [
                'furn' => '洗碗机',
                'is_checked' => false
            ]
        ];
        $houseFor= explode(',',$houseInfo['home']);
        foreach ($allFours as $key => &$val) {
            if(in_array($val['furn'], $houseFor)) {
                $val['is_checked'] = true;
            }
        }unset($val);
        $houseInfo['home'] = $houseFor;
        if($houseInfo['live_date'] == '0000-00-00' || $houseInfo['live_date'] == '0100-01-01'){
            $show = 1;
        }else{
            $show = 2;
        }
        $houseInfo['live_date_show'] =$show;
        $houseInfo['images1'] = explode(',',$houseInfo['images']);
        $city = Db::table('tk_cate')->where(['pid' => 0])->select();
        $Tags= explode(',',$houseInfo['tags']);
        $all_tags = Db::table('xcx_tags')
            ->where(['type' => 1])
            ->field('id,name')
            ->select();
        foreach ($all_tags as $key => &$val) {
            $all_tags[$key]['is_checked'] = false;
            if(in_array($val['name'], $Tags)) {
                $val['is_checked'] = true;
            }
        }unset($val);
        $this->assign('tags',$all_tags);
        $this->assign('all_bill',$all_bill);
        $this->assign('all_trans',$all_trans);
        $this->assign('all_set',$all_set);
        $this->assign('city',$city);
        $this->assign('all_four',$allFours);
        $this->assign('house',$houseInfo);
        return $this->fetch();
    }


    public function del(){
        $id = $this->request->param('id',22,'intval');
        $del = Db::table('tk_houses')
            ->where(['id' => $id])
            ->delete();
        if($del){
            $this->success('删除成功！','index');
        }else{
            $this->error('删除失败！','index');
        }
    }

    //通用缩略图上传接口
    public function upload()
    {
        if($this->request->isPost()){
            $res['code']=1;
            $res['msg'] = '上传成功！';
            $file = $this->request->file('file');
            $config = [
                'size' => 1024*1024*10
            ];
            $size = $file->validate($config);
            if($size){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/text');
                //halt( $info);
                if($info){
                    $res['name'] = $info->getFilename();
                    $res['filepath'] = 'uploads/text/'.$info->getSaveName();
                }else{
                    $res['code'] = 0;
                    $res['msg'] = '上传失败！'.$file->getError();
                }
            }else{
                $res['code'] = 0;
                $res['msg'] = '文件大小不超过10M！';
            }
            return $res;
        }
    }


    public function tags(){
        $id = $this->request->param('id',22,'intval');
        if($_POST){
            $bill = $_POST['tags'];
            $bills = '';
            foreach($bill as $key => $val){
                $bills .= $key.',';
            }
            $data['tags'] = rtrim($bills,',');
            $update = Db::table('tk_houses')->where(['id' => $id])->update($data);
            if($update){
                $this->success('更新成功！','index');
            }else{
                $this->error('更新失败！','index');
            }
        }else{
            //读取房源的tags
            $houseTags = Db::table('tk_houses')
                ->where(['id' => $id])
                ->field('id,tags')
                ->find();
            $Tags= explode(',',$houseTags['tags']);
            $all_tags = Db::table('xcx_tags')
                ->where(['type' => 1])
                ->field('id,name')
                ->select();
            foreach ($all_tags as $key => &$val) {
                $all_tags[$key]['is_checked'] = false;
                if(in_array($val['name'], $Tags)) {
                    $val['is_checked'] = true;
                }
            }unset($val);
            $this->assign('house',$houseTags);
            $this->assign('tags',$all_tags);
            return $this->fetch();
        }

    }

    public function checkHouseUrl(){
        $order_id = trim($this->request->param('order_id'));
        $id = trim($this->request->param('id'));
        if($id >0){
            $isRepeat=Db::table('tk_houses')
                ->where(['http' => $order_id])
                ->where('id != '.$id)
                ->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '这个房源已经添加过了呢！';
            }else {
                $res['code'] = 1;
                $res['msg'] = '独一无二的房源链接';
            }
        }else{
            $isRepeat=Db::table('tk_houses')
                ->where(['http' => $order_id])
                ->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '这个房源已经添加过了呢！';
            }else {
                $res['code'] = 1;
                $res['msg'] = '独一无二的房源链接';
            }
        }
        return $res;
    }

    public function myhouse(){
        $adminId = session('adminId');
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $addable = in_array('242',$power_list,true);
        $editable = in_array('243',$power_list,true);
        $delable = in_array('244',$power_list,true);
        $offable = in_array('281',$power_list,true);
        $this->assign('offable',$offable);
        $this->assign('addable',$addable);
        $this->assign('editable',$editable);
        $this->assign('delable',$delable);
        $cityinfo = Db::table('tk_cate')->where(['pid' =>0])->select();
        $this->assign('cityinfo',$cityinfo);
        return $this->fetch();
    }

    public function myData(){
        $userId = session('ad_wechat');
        $adminId = session('adminId');
        $where =' ( user_id = '.$userId.' and is_admin = 1 ) or ( user_id = '.$adminId.' and is_admin = 2) ';
        $keywords = trim($this->request->param('keywords'));
        $time = trim($this->request->param('time'));
        $city = trim($this->request->param('city'));
        $area = trim($this->request->param('area'));
        $status = trim($this->request->param('status'));
        $address = trim($this->request->param('address'));
        $top = trim($this->request->param('top'));
        $tj = trim($this->request->param('tj'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( title like '%".$keywords."%' or dsn like '%".$keywords."%' )";
        }
        if(isset($city) && !empty($city) && $city){
            $where.=" and city = '".$city."'";
        }
        if(isset($area) && !empty($area) && $area){
            $where.=" and area = '".$area."'";
        }if(isset($top) && !empty($top) && $top){
            if($top == '是'){
                $where.=" and top = '".$top."'";
            }
        }if(isset($tj) && !empty($tj) && $tj){
            if($tj == '是'){
                $where.=" and tj = '".$tj."'";
            }
        }
        if(isset($address) && !empty($address) && $address){
            $where.=" and address like '%".$address."%'";
        }
        if(isset($status) && !empty($status) && $status){
            $where.=" and status = ".$status;
        }

        if(isset($time) && !empty($time)){
            $sdate=substr($time,'0','10')." 00:00:00";
            $edate=substr($time,'-10')." 23:59:59";
            $where.=" and ( cdate >= '".$sdate."' and cdate <= '".$edate."' ) ";
        }
        $count=Db::table('tk_houses')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $order = 'top desc,cdate desc';
        $orderv = trim($this->request->param('orderv'));
        $orderc = trim($this->request->param('orderc'));
        if(isset($orderv) && !empty($orderv) && $orderv){
            if($orderv == 1){
                $order ="view desc";
            }else{
                $order ="view asc";
            }
        }
        if(isset($orderc) && !empty($orderc) && $orderc){
            if($orderc == 1){
                $order ="collection desc";
            }else{
                $order ="collection asc";
            }
        }
        $design=Db::table('tk_houses')
            ->limit(($page-1)*$limit,$limit)
            ->order($order)
            ->where($where)
            ->select();
        $designs=Db::table('tk_houses')
            ->limit(($page-1)*$limit,$limit)
            ->order($order)
            ->where($where)
            ->select();
        $loopd = new Loops();
        foreach ($design as $k => $v){
            $design[$k]['statuss'] = $this->houseStatus($v['status']);
            $design[$k]['cdate'] = date('m-d H:i',strtotime($v['cdate']));
            $design[$k]['user_id'] = $loopd->getUserNicks($v['user_id'],$v['is_admin']);
            $design[$k]['isTop'] = $this->greaterTops($v['id']);
            $design[$k]['isTj'] = $this->greaterTjs($v['id']);
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        $res['where'] = $designs;
        return json($res);
    }
}