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
use app\xcx\model\Languages;
use app\xcx\model\Loops;
use app\xcx\model\Rolem;
use think\Controller;
use think\Db;
use think\Image;
use think\Request;
use UrlVideo\BiliBili;
use UrlVideo\Youtube;

class House extends Controller{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $adminName=session('adminName');
        if(empty($adminName)){
            $this->error('Please Login！','login/login');
        }
        if(isset($_SESSION['expiretime'])) {
            if($_SESSION['expiretime'] < time()) {
                unset($_SESSION['expiretime']);
                $this->error('Please Login！','login/login');
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
        $lang = new Languages();
        $langs = $lang->getLang();
        $enLab = $lang->getLanguages();
        $cityinfo = Db::table('tk_cate')
            ->where(['pid' =>0])
            ->field('id,name,ename')
            ->select();
        foreach ($cityinfo as $k => $v){
            if($langs != 'Cn'){
                $cityinfo[$k]['sname'] = $v['ename'];
            }else{
                $cityinfo[$k]['sname'] = $v['name'];
            }
        }
        $this->assign('lable',$enLab);
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
        $roleId = session('ad_role');
        $corpId = session('ad_corp');
        $where ='is_del = 1';
        //角色不是超级管理员且有房源列表的权限的员工仅显示他的公司下的房源
        if($roleId != 1){
            $where .=" and corp in (".$corpId.")";
        }
        $keywords = trim($this->request->param('keywords'));
        $keytype = trim($this->request->param('keytype'));
        $time = trim($this->request->param('time'));
        $city = trim($this->request->param('city'));
        $area = trim($this->request->param('area'));
        $status = trim($this->request->param('status'));
        $address = trim($this->request->param('address'));
        $top = trim($this->request->param('top'));
        $tj = trim($this->request->param('tj'));
        if($keytype == 1){
            if(isset($keywords) && !empty($keywords)){
                $where.=" and title like '%".$keywords."%' ";
            }
        }
        if($keytype == 2){
            if(isset($keywords) && !empty($keywords)){
                $where.=" and dsn like '%".$keywords."%' ";
            }
        }
        if($keytype == 3){
            if(isset($keywords) && !empty($keywords)){
                $where.=" and address like '%".$keywords."%' ";
            }
        }
        if($keytype == 4){
            if(isset($keywords) && !empty($keywords)){
                $users = Db::table('tk_user')
                    ->where("nickname like '%".$keywords."%'")
                    ->column('id');
                $userStr = '';
                if($users){
                    foreach ($users as $k => $v){
                        $userStr.= ",'".$v."'";
                    }
                }
                $userIdsStr = trim($userStr,',');
                $admin = Db::table('super_admin')
                    ->where("ad_realname like '%".$keywords."%'")
                    ->column('ad_id');
                $adminStr = '';
                if($admin){
                    foreach ($admin as $k => $v){
                        $adminStr.= ",'".$v."'";
                    }
                }
                $adminIdsStr = trim($adminStr,',');
                if($userIdsStr && $adminIdsStr){
                    $where .=' and  (( user_id  in ('.$userIdsStr.') and is_admin = 1 ) or  ( user_id  in('.$adminIdsStr.') and is_admin = 2 ))';
                }else{
                    if($userIdsStr){
                        $where .=' and  ( user_id  in ('.$userIdsStr.') and is_admin = 1 ) ';
                    }
                    if($adminIdsStr){
                        $where .=' and  ( user_id  in('.$adminIdsStr.') and is_admin = 2 ) ';
                    }
                }

            }
        }
        if($keytype == 5){
            if(isset($keywords) && !empty($keywords)){
                $where.=" and content like '%".$keywords."%' ";
            }
        }
               //公司
        if($keytype == 6){
            if(isset($keywords) && !empty($keywords)){
                $users = Db::table('xcx_corp')
                    ->where("cp_name like '%".$keywords."%'")
                    ->column('cp_id');
                $userStr = '';
                if($users){
                    foreach ($users as $k => $v){
                        $userStr.= ",'".$v."'";
                    }
                }
                $userIdsStr = trim($userStr,',');
                if($userIdsStr){
                    $where .=' and  ( corp  in ('.$userIdsStr.') and is_admin = 2 ) ';
                }
            }
        }
        //PM
        if($keytype == 7){
            if(isset($keywords) && !empty($keywords)){
                $users = Db::table('super_admin')
                    ->where("ad_realname like '%".$keywords."%'")
                    ->column('ad_id');
                $userStr = '';
                if($users){
                    foreach ($users as $k => $v){
                        $userStr.= ",'".$v."'";
                    }
                }
                $userIdsStr = trim($userStr,',');
                if($userIdsStr){
                    $where .=' and  ( pm  in ('.$userIdsStr.') and is_admin = 2 ) ';
                }
            }
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
            $status = $status == 3 ? 0:$status;
            $where.=" and status = ".$status;
        }

        if(isset($time) && !empty($time)){
            $sdate=substr($time,'0','10')." 00:00:00";
            $edate=substr($time,'-10')." 23:59:59";
            $where.=" and ( cdate >= '".$sdate."' and cdate <= '".$edate."' ) ";
        }
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',50,'intval');
        $order = 'top desc,cdate desc';
        $orders = trim($this->request->param('order'));
        if(isset($orders) && !empty($orders) && $orders){
            switch ($orders)
            {
                case 1:
                    $order ="view desc";
                    break;
                case 2:
                    $order ="view asc";
                    break;
                case 3:
                    $order ="collection desc";
                    break;
                case 4:
                    $order ="collection asc";
                    break;
                case 5:
                    $order ="cdate desc";
                    break;
                case 6:
                    $order ="cdate asc";
                    break;
                default:
                    $order = 'top desc,cdate desc';
            }
        }
        $count=Db::table('tk_houses')
            ->where($where)
            ->count();
        $design=Db::table('tk_houses')
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
            $design[$k]['price'] = $this->getPrice($v['price']);
            $design[$k]['corp'] = $this->getCorp($v['corp']);
            $design[$k]['pm'] = $this->getPmname($v['pm']);
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        return json($res);
    }

    public function getPmname($pm){
        $pminfo = Db::table('super_admin')
            ->where(['ad_id' => $pm])
            ->field('ad_realname')
            ->find();
        return $pminfo ? $pminfo['ad_realname'] : '';
    }
    public function getCorp($price){
        $pminfo = Db::table('xcx_corp')
            ->where(['cp_id' => $price])
            ->field('cp_name')
            ->find();
        return $pminfo ? $pminfo['cp_name'] : '';
    }

    public function getPrice($price){
        if($price == -1){
            $lang = new Languages();
            if($lang == 'Cn'){
               return '租金可议';
            }
            return 'Negotiable';
        }else{
            return $price;
        }
    }

    public function getarea(){
        $city = trim($this->request->param('city','本墨尔'));
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
        $status = trim($this->request->param('status',0));
        $typess = trim($this->request->param('typess',0));
        if($_POST){
            $data = $_POST;
            if(isset($_POST['http']) && $_POST['http']){
                $isRepeat = Db::table('tk_houses')
                    ->where(['http' => $data['http']])
                    ->find();
                if($isRepeat){
                    $this->error('Already Exist！');
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
            if(isset($_POST['lease_term']) && $_POST['lease_term']){
                $term = $_POST['lease_term'];
                $terms = '';
                foreach($term as $key => $val){
                    $terms .= $key.',';
                }
                $data['lease_term'] = rtrim($terms,',');
            }else{
                $data['lease_term'] ='';
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
            $data['status'] = $status ==0 ? 1 : 0;
            $data['city'] = $_POST['city'];
            unset($data['file']);
            $data['dsn'] = $this->genHouseDsn();
            $data['user_id'] = $adminId;
            $data['is_admin'] = 2;
            if(isset($data['address'])){
                $data['area'] = trim(explode(',',$data['address'])[1]);
            }
            $add=Db::table('tk_houses')->insert($data);
            $url =   $typess==1 ? 'myhouse' : 'index';
            if($add){
                $this->success('SuccessFully！',$url);
            }else{
                $this->error('Failed！',$url);
            }
        }else{
            $lang = new Languages();
            $langs = $lang->getLang();
            $enLab = $lang->getLanguages();
            $city = Db::table('tk_cate')->where(['pid' => 0])->select();
            $this->assign('city',$city);
            $all_tags = Db::table('xcx_tags')
                ->where(['type' => 1])
                ->field('id,name,ename')
                ->order('torder asc,id desc')
                ->select();
            foreach ($all_tags as $k => $v){
                if($langs == 'En'){
                    $all_tags[$k]['sname'] = $v['ename'];
                }else{
                    $all_tags[$k]['sname'] = $v['name'];
                }
            }
            //选择公司和PM
            $cropId = session('ad_corp');
            $where='cp_able = 1 and cp_id  in ('.$cropId.')';
            $corp=Db::table('xcx_corp')
                ->where($where)
                ->field('cp_id,cp_name')
                ->select();
            $this->assign('corp',$corp);
            $this->assign('langs',$langs);
            $this->assign('lable',$enLab);
            $this->assign('tags',$all_tags);
            $this->assign('typess',$typess);
            return $this->fetch();
        }

    }


    public function getpm(){
        $cpid = trim($this->request->param('cp_id'));
        //一在多里面 find_in_set  多在一里面 in
        $pmInfo = Db::table('super_admin')
            ->where("find_in_set('".$cpid."',ad_corp) and ad_isable = 1")
            ->field('ad_id,ad_realname')
            ->select();
        if($pmInfo){
            return  json(['code' => '1','data' => $pmInfo]);
        }
        return  json(['code' => '0','data' => null]);

    }

    public function getpminfo(){
        $pmid = trim($this->request->param('pmid'));
        $pmInfo = Db::table('super_admin')
            ->where(['ad_id' => $pmid])
            ->field('ad_realname,ad_phone,ad_email')
            ->find();
        if($pmInfo){
            return  json(['code' => '1','data' => $pmInfo]);
        }
        return  json(['code' => '0','data' => null]);
    }

    //通用缩略图上传接口
    public function upload2()
    {
        if($this->request->isPost()){
            $res['code']=1;
            $res['msg'] = 'Upload success！';
            $file = $this->request->file('file');
            $config = [
                'size' => 1024*1024*10
            ];
            $size = $file->validate($config);
            if($size){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/ceshi');
                //halt( $info);
                if($info){
                    $res['name'] = $info->getFilename();
                    $res['filepath'] = 'uploads/ceshi/'.$info->getSaveName();
                }else{
                    $res['code'] = 0;
                    $res['msg'] = 'Upload Failed！'.$file->getError();
                }
            }else{
                $res['code'] = 0;
                $res['msg'] = '10M maximum Size！';
            }
            return $res;
        }
    }


    public function add1(){
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
            ->order('torder asc,id desc')
            ->select();
        $this->assign('tags',$all_tags);
        $this->assign('typess',1);
        return $this->fetch();
    }


    public function getCityName($id){
        $city = Db::table('tk_cate')->where(['id' =>$id])->field('name')->find();
        return $city ? $city['name'] : 'Unknown City';
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
            ->order('oseq asc')
            ->select();
        $lang = new Languages();
        $langs = $lang->getLang();
        foreach ($city as $k => $v){
            if($langs != 'Cn'){
                $city[$k]['sname'] = $v['ename'];
            }else{
                $city[$k]['sname'] = $v['name'];
            }
        }
        $this->assign('langs',$langs);
        return $city;
    }

    public function getSchool(){
        $id = $this->request->param('id',0,'intval');
        $city = Db::table('tk_cate')
            ->where(['pid' => $id,'type' => 2])
            ->order('oseq asc')
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
        $lang = new Languages();
        $enLab = $lang->getLanguages();
        switch ($status)
        {
            case 1:
                $type = $enLab['on'];
                break;
            case 2:
                $type = $enLab['off'];
                break;
            default:
                $type = $enLab['draft'];
        }
        return $type;
    }
    /*
     * 房源修改
     * */
    public function edit(){
        $id = $this->request->param('id',22,'intval');
        $type = $this->request->get('type');
        $status = trim($this->request->param('status',0));
        if($_POST){
            $data = $_POST;
            if(isset($_POST['http']) && $_POST['http']){
                $isRepeat = Db::table('tk_houses')
                    ->where(['http' => $data['http']])
                    ->where('id != '.$id)
                    ->find();
                if($isRepeat){
                    $this->error('Already Exist！');
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
            if(isset($_POST['lease_term']) && $_POST['lease_term']){
                $term = $_POST['lease_term'];
                $terms = '';
                foreach($term as $key => $val){
                    $terms .= $key.',';
                }
                $data['lease_term'] = rtrim($terms,',');
            }else{
                $data['lease_term'] ='';
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
            //$data['publish_date'] = date('Y-m-d H:i:s');
            $data['mdate'] = date('Y-m-d H:i:s');
            $data['cdate'] = date('Y-m-d H:i:s');
            $data['status'] = $status ==0 ? 1 : 0;
            unset($data['file']);
            $url = $type == 1 ? 'index' : 'myhouse';
            $add=Db::table('tk_houses')->where(['id' => $id])->update($data);
            if($add){
                $this->success('SuccessFully！',$url);
            }else{
                $this->error('Failed！',$url);
            }
        }else{
            $houseInfo = Db::table('tk_houses')->where(['id' => $id])->find();
            if($houseInfo['images']){
                //压缩房源图片
                $houseInfo['images'] = $this->cpHouseImg($houseInfo['images']);
            }
            if($houseInfo['thumnail']){
                //压缩封面图
                $houseInfo['thumnail'] = $this->compImg($houseInfo['thumnail']);
            }
            $lang = new Languages();
            $enLab = $lang->getLanguages();
            $all_bill = [
                [
                    'bill' => '包水',
                    'billtitle' => $enLab['water'],
                    'is_checked' => false
                ],
                [
                    'bill' => '包电',
                    'billtitle' => $enLab['elect'],
                    'is_checked' => false
                ],
                [
                    'bill' => '包气',
                    'billtitle' => $enLab['gas'],
                    'is_checked' => false
                ],
                [
                    'bill' => '包网',
                    'billtitle' => $enLab['nets'],
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
            $all_term = [
                [
                    'term' => '12+',
                    'is_checked' => false
                ],
                [
                    'term' => '6-12',
                    'is_checked' => false
                ],
                [
                    'term' => '3-6',
                    'is_checked' => false
                ],
                [
                    'term' => '0-3',
                    'is_checked' => false
                ]
            ];
            if($houseInfo['lease_term']){
                $houseTerm = explode(',',$houseInfo['lease_term']);
                foreach ($all_term as $key => &$val) {
                    if(in_array($val['term'], $houseTerm)) {
                        $val['is_checked'] = true;
                    }
                }unset($val);
                $houseInfo['lease_term'] = $houseTerm;
            }
            $all_set = [
                [
                    'set' => '游泳池',
                    'setitle' => $enLab['yongchi'],
                    'is_checked' => false
                ],
                [
                    'set' => '健身房',
                    'setitle' => $enLab['jianshenfang'],
                    'is_checked' => false
                ],[
                    'set' => '停车位',
                    'setitle' => $enLab['tingchewei'],
                    'is_checked' => false
                ],
                [
                    'set' => '电影院',
                    'setitle' => $enLab['dianyingyuan'],
                    'is_checked' => false
                ],
                [
                    'set' => '花园',
                    'setitle' => $enLab['huayuan'],
                    'is_checked' => false
                ],
                [
                    'set' => '门禁',
                    'setitle' => $enLab['menjin'],
                    'is_checked' => false
                ],
                [
                    'set' => '前台',
                    'setitle' => $enLab['qiantai'],
                    'is_checked' => false
                ],
                [
                    'set' => '桑拿',
                    'setitle' => $enLab['sangna'],
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
                    'transtitle' => $enLab['bashizhan'],
                    'is_checked' => false
                ],
                [
                    'trans' => '火车站',
                    'transtitle' => $enLab['huochezhan'],
                    'is_checked' => false
                ],
                [
                    'trans' => '电车站',
                    'transtitle' => $enLab['dianchezhan'],
                    'is_checked' => false
                ],
                [
                    'trans' => '餐馆',
                    'transtitle' => $enLab['canguan'],
                    'is_checked' => false
                ],
                [
                    'trans' => '公园',
                    'transtitle' => $enLab['gongyuan'],
                    'is_checked' => false
                ],
                [
                    'trans' => '警察局',
                    'transtitle' => $enLab['jingcaju'],
                    'is_checked' => false
                ],
                [
                    'trans' => '医院',
                    'transtitle' => $enLab['yiyuan'],
                    'is_checked' => false
                ],
                [
                    'trans' => '超市',
                    'transtitle' => $enLab['chaoshi'],
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
                    'transtitle' => $enLab['chuang'],
                    'is_checked' => false
                ],
                [
                    'furn' => '沙发',
                    'transtitle' => $enLab['shafa'],
                    'is_checked' => false
                ],[
                    'furn' => 'WIFI',
                    'transtitle' => $enLab['fWIFI'],
                    'is_checked' => false
                ],[
                    'furn' => '空调',
                    'transtitle' => $enLab['kongtiao'],
                    'is_checked' => false
                ],[
                    'furn' => '洗衣机',
                    'transtitle' => $enLab['xiyiji'],
                    'is_checked' => false
                ],[
                    'furn' => '冰箱',
                    'transtitle' => $enLab['bingxiang'],
                    'is_checked' => false
                ],[
                    'furn' => '微波炉',
                    'transtitle' => $enLab['weibolu'],
                    'is_checked' => false
                ],[
                    'furn' => '暖气',
                    'transtitle' => $enLab['nuanqi'],
                    'is_checked' => false
                ],[
                    'furn' => '烤箱',
                    'transtitle' => $enLab['kaoxiang'],
                    'is_checked' => false
                ],
                [
                    'furn' => '洗碗机',
                    'transtitle' => $enLab['xiwanji'],
                    'is_checked' => false
                ],
                [
                    'furn' => '书桌',
                    'transtitle' => $enLab['shuzhuo'],
                    'is_checked' => false
                ],
                [
                    'furn' => '烘干机',
                    'transtitle' => $enLab['hongganji'],
                    'is_checked' => false
                ],
                [
                    'furn' => '电视',
                    'transtitle' => $enLab['dianshi'],
                    'is_checked' => false
                ],
                [
                    'furn' => '天然气',
                    'transtitle' => $enLab['tianranqi'],
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
                ->field('id,name,ename')
                ->order('torder asc,id desc')
                ->select();
            $langs = $lang->getLang();
            foreach ($all_tags as $key => &$val) {
                if($langs == 'En'){
                    $all_tags[$key]['sname'] = $val['ename'];
                }else{
                    $all_tags[$key]['sname'] = $val['name'];
                }
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
            $langs = $lang->getLang();
            $cityname = $langs == 'Cn' ? $houseInfo['city'] : $this->getCityNames($houseInfo['city']);
            $shcool = $this->getSchools($houseInfo['city']);
            $houseInfo['citys'] = $cityname;
            //选择公司和PM
            $cropId = session('ad_corp');
            $where='cp_able = 1 and cp_id  in ('.$cropId.')';
            $corp=Db::table('xcx_corp')
                ->where($where)
                ->field('cp_id,cp_name')
                ->select();
            $pminfo =Db::table('super_admin')
                ->where("ad_corp in (".$houseInfo['corp'].")")
                ->field('ad_id,ad_realname')
                ->select();
            $this->assign('pminfo',$pminfo);
            $this->assign('corp',$corp);
            $this->assign('langs',$langs);
            $this->assign('lable',$enLab);
            $this->assign('all_bill',$all_bill);
            $this->assign('all_term',$all_term);
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


    public function getCityNames($cnCity){
        $enCityName = Db::table('tk_cate')
            ->where(['name' => $cnCity,'pid' => 0])
            ->field('ename')
            ->find();
        return $enCityName['ename'];

    }

    public function getSchoolNames($cnCity){
        $enCityName = Db::table('tk_cate')
            ->where(['name' => $cnCity,'type' => 2])
            ->field('ename')
            ->find();
        return $enCityName['ename'];

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
                $msg = 'Top ';
                $data['top'] = '是';
            }else{
                $msg = 'UnTop';
                $data['top'] = '否';
            }
            $changeStatus = Db::table('tk_houses')->where(['id' => $ba_id])->update($data);
            if($changeStatus){
                $res['code'] = 1;
                $res['msg'] = $msg.'SuccessFully！';
            }else{
                $res['code'] = 0;
                $res['msg'] = $msg.'Failed！';
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
                $msg = 'Recommended ';
                $data['tj'] = '是';
            }else{
                $msg = '取消推荐';
                $data['tj'] = '否';
            }
            $changeStatus = Db::table('tk_houses')->where(['id' => $ba_id])->update($data);
            if($changeStatus){
                $res['code'] = 1;
                $res['msg'] = $msg.'SuccessFully！';
            }else{
                $res['code'] = 0;
                $res['msg'] = $msg.'Failed！';
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
        $date = date('Y-m-d H:i:s');
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = 'Online ';
                $data['status'] = 1;
                $data['cdate'] = $date;
            }else{
                $msg = 'Off line';
                $data['status'] = 2;
                $data['cdate'] = $date;
            }
            $changeStatus = Db::table('tk_houses')->where(['id' => $ba_id])->update($data);
            if($changeStatus){
                $res['code'] = 1;
                $res['msg'] = $msg.'SuccessFully！';
            }else{
                $res['code'] = 0;
                $res['msg'] = $msg.'Failed！';
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
    public function cpHouseImg($images){
        $imgurl ='';
        if($images){
            $images = explode(',',$images);
            foreach ($images as $k => $item){
                $img = $this->compImg($item);
                $imgurl .= $img.",";
            }
        }
        $imgurl = rtrim($imgurl,',');
        return $imgurl;
    }


    //压缩大于1.5m的房源图片
    public function compImg($files){
        $file = "./".$files;
        $size = filesize($file);
        $imgSize = ceil($size/1024);
        $Size1 = 1.5*1024;
        $Size2 = 2.5*1024;
        $Size3 = 3*1024;
        $Size4 = 6*1024;
        if($Size1 < $imgSize){
            return $file;
        }elseif($Size2 > $imgSize && $imgSize > $Size1){
            $this->compressImg($file,80);
        }elseif($Size3 > $imgSize && $imgSize > $Size2){
            $this->compressImg($file,70);
        }elseif($Size4 > $imgSize && $imgSize > $Size3){
            $this->compressImg($file,60);
        }else{
            $this->compressImg($file,40);
        }
        return $files;
    }

    /***
     * @param $filePath string 文件路径
     * @param $quality int 压缩比率
     * @return mixed
     */
    public function compressImg($filePath,$quality){
        $image = Image::open($filePath);
        $image->save($filePath,null,$quality);
        return $filePath;
    }

    public function detail(){
        $id = $this->request->param('id',22,'intval');
        $houseInfo = Db::table('tk_houses')->where(['id' => $id])->find();
        if($houseInfo['images']){
            //压缩房源图片
            $houseInfo['images'] = $this->cpHouseImg($houseInfo['images']);
        }
        if($houseInfo['thumnail']){
            //压缩封面图
            $houseInfo['thumnail'] = $this->compImg($houseInfo['thumnail']);
        }
        $lang = new Languages();
        $enLab = $lang->getLanguages();
        $all_bill = [
            [
                'bill' => '包水',
                'billtitle' => $enLab['water'],
                'is_checked' => false
            ],
            [
                'bill' => '包电',
                'billtitle' => $enLab['elect'],
                'is_checked' => false
            ],
            [
                'bill' => '包气',
                'billtitle' => $enLab['gas'],
                'is_checked' => false
            ],
            [
                'bill' => '包网',
                'billtitle' => $enLab['nets'],
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
        $all_term = [
            [
                'term' => '12+',
                'is_checked' => false
            ],
            [
                'term' => '6-12',
                'is_checked' => false
            ],
            [
                'term' => '3-6',
                'is_checked' => false
            ],
            [
                'term' => '0-3',
                'is_checked' => false
            ]
        ];
        if($houseInfo['lease_term']){
            $houseTerm = explode(',',$houseInfo['lease_term']);
            foreach ($all_term as $key => &$val) {
                if(in_array($val['term'], $houseTerm)) {
                    $val['is_checked'] = true;
                }
            }unset($val);
            $houseInfo['lease_term'] = $houseTerm;
        }
        $all_set = [
            [
                'set' => '游泳池',
                'setitle' => $enLab['yongchi'],
                'is_checked' => false
            ],
            [
                'set' => '健身房',
                'setitle' => $enLab['jianshenfang'],
                'is_checked' => false
            ],[
                'set' => '停车位',
                'setitle' => $enLab['tingchewei'],
                'is_checked' => false
            ],
            [
                'set' => '电影院',
                'setitle' => $enLab['dianyingyuan'],
                'is_checked' => false
            ],
            [
                'set' => '花园',
                'setitle' => $enLab['huayuan'],
                'is_checked' => false
            ],
            [
                'set' => '门禁',
                'setitle' => $enLab['menjin'],
                'is_checked' => false
            ],
            [
                'set' => '前台',
                'setitle' => $enLab['qiantai'],
                'is_checked' => false
            ],
            [
                'set' => '桑拿',
                'setitle' => $enLab['sangna'],
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
                'transtitle' => $enLab['bashizhan'],
                'is_checked' => false
            ],
            [
                'trans' => '火车站',
                'transtitle' => $enLab['huochezhan'],
                'is_checked' => false
            ],
            [
                'trans' => '电车站',
                'transtitle' => $enLab['dianchezhan'],
                'is_checked' => false
            ],
            [
                'trans' => '餐馆',
                'transtitle' => $enLab['canguan'],
                'is_checked' => false
            ],
            [
                'trans' => '公园',
                'transtitle' => $enLab['gongyuan'],
                'is_checked' => false
            ],
            [
                'trans' => '警察局',
                'transtitle' => $enLab['jingcaju'],
                'is_checked' => false
            ],
            [
                'trans' => '医院',
                'transtitle' => $enLab['yiyuan'],
                'is_checked' => false
            ],
            [
                'trans' => '超市',
                'transtitle' => $enLab['chaoshi'],
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
                'transtitle' => $enLab['chuang'],
                'is_checked' => false
            ],
            [
                'furn' => '沙发',
                'transtitle' => $enLab['shafa'],
                'is_checked' => false
            ],[
                'furn' => 'WIFI',
                'transtitle' => $enLab['fWIFI'],
                'is_checked' => false
            ],[
                'furn' => '空调',
                'transtitle' => $enLab['kongtiao'],
                'is_checked' => false
            ],[
                'furn' => '洗衣机',
                'transtitle' => $enLab['xiyiji'],
                'is_checked' => false
            ],[
                'furn' => '冰箱',
                'transtitle' => $enLab['bingxiang'],
                'is_checked' => false
            ],[
                'furn' => '微波炉',
                'transtitle' => $enLab['weibolu'],
                'is_checked' => false
            ],[
                'furn' => '暖气',
                'transtitle' => $enLab['nuanqi'],
                'is_checked' => false
            ],[
                'furn' => '烤箱',
                'transtitle' => $enLab['kaoxiang'],
                'is_checked' => false
            ],
            [
                'furn' => '洗碗机',
                'transtitle' => $enLab['xiwanji'],
                'is_checked' => false
            ],
            [
                'furn' => '书桌',
                'transtitle' => $enLab['shuzhuo'],
                'is_checked' => false
            ],
            [
                'furn' => '烘干机',
                'transtitle' => $enLab['hongganji'],
                'is_checked' => false
            ],
            [
                'furn' => '电视',
                'transtitle' => $enLab['dianshi'],
                'is_checked' => false
            ],
            [
                'furn' => '天然气',
                'transtitle' => $enLab['tianranqi'],
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
            ->field('id,name,ename')
            ->order('torder asc,id desc')
            ->select();
        $langs = $lang->getLang();
        foreach ($all_tags as $key => &$val) {
            if($langs == 'En'){
                $all_tags[$key]['sname'] = $val['ename'];
            }else{
                $all_tags[$key]['sname'] = $val['name'];
            }
            $all_tags[$key]['is_checked'] = false;
            if(in_array($val['name'], $Tags)) {
                $val['is_checked'] = true;
            }
        }unset($val);
        $cityname = $langs == 'Cn' ? $houseInfo['city'] : $this->getCityNames($houseInfo['city']);
        $schoolname = $langs == 'Cn' ? $houseInfo['school'] : $this->getSchoolNames($houseInfo['school']);
        $houseInfo['city'] = $cityname;
        $houseInfo['school'] = $schoolname;
        //选择公司和PM
        $cropId = session('ad_corp');
        $where='cp_able = 1 and cp_id  in ('.$cropId.')';
        $corp=Db::table('xcx_corp')
            ->where($where)
            ->field('cp_id,cp_name')
            ->select();
        $pminfo =Db::table('super_admin')
            ->where("ad_corp in (".$houseInfo['corp'].")")
            ->field('ad_id,ad_realname')
            ->select();
        $this->assign('pminfo',$pminfo);
        $this->assign('corp',$corp);
        $this->assign('all_term',$all_term);
        $this->assign('lable',$enLab);
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
        $dels = Db::table('tk_houses')
            ->where(['id' => $id])
            ->update(['is_del' => 2]);
        //删除该房源的会话和消息
        $del = Db::table('xcx_msg_person')
            ->where(['mp_hid' => $id])
            ->field('mp_id')
            ->select();
        foreach ($del as $k => $v){
            $this->delMsg($v['mp_id']);
        }
        Db::table('xcx_msg_person')
            ->where(['mp_hid' => $id])
            ->update(['mp_isable' =>2]);
        if($dels){
            $this->success('SuccessFully！','index');
        }else{
            $this->error('Failed！','index');
        }
    }


    public function delMsg($mpid){
        Db::table('xcx_msg_content')
            ->where(['xcx_msg_id' => $mpid])
            ->update(['xcx_msg_isable' => 2]);
    }

    public function delBatch(){
        $ids = ltrim($this->request->param('ids'),',');
        $idArr = explode(',',$ids);
        foreach($idArr as $key => $value)
        {
            Db::table('tk_houses')
                ->where(['id' => $value])
                ->update(['is_del' => 2]);
        }
        $this->success('SuccessFully！','index');
    }

    //通用缩略图上传接口
    public function upload()
    {
        if($this->request->isPost()){
            $res['code']=1;
            $res['msg'] = 'Upload SuccessFully！';
            $file = $this->request->file('file');
            $config = [
                'size' => 1024*1024*30
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
                    $res['msg'] = 'Upload Failed！'.$file->getError();
                }
            }else{
                $res['code'] = 0;
                $res['msg'] = '10M maximum Size！';
            }
            return $res;
        }
    }

    //通过url上传视频
    public function urlUpload($url)
    {
        if ($this->request->isPost()) {
            $url = $this->request->param('url');
            if (preg_match('/(bilibili\.com)/',$url)) {
                $BiliBili = new BiliBili();
                $res = $BiliBili->download($url);
                return $res;
            } elseif(preg_match('/(youtube\.be|youtube\.com)/',$url)) {
                $Youtube = new Youtube();
                $res = $Youtube->download($url);
                return $res;
            }else {
                $res['code'] = 0;
                $res['msg'] = '请输入正确的视频地址！';
                return $res;
            }
        }
    }


    public function video(){
        if($_POST){
            $data = $_POST;

        }else{
            return $this->fetch();
        }
    }

    public function getSign($link,$timestamp){
        $clientSecretKey ='';
        $sign = md5($link . $timestamp . $clientSecretKey);
        return $sign;
    }
    function file_get_contents_post($url, $post) {
        $options = array(
            "http"=> array(
                "method"=>"POST",
                "header" => "Content-type: application/x-www-form-urlencoded",
                "content"=> http_build_query($post)
            ),
        );
        $result = file_get_contents($url,false, stream_context_create($options));
        return $result;
    }
    //通用缩略图上传接口
    public function upload1()
    {
        if($this->request->isPost()){
            $res['code']=1;
            $res['msg'] = 'Upload SuccessFully！';
            $file = $this->request->file('file');
            $config = [
                'size' => 1024*1024*10
            ];
            $size = $file->validate($config);
            $checksize = $file->checkSize(1024*1.5);
            if($size){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/text');
                //halt( $info);
                if($info){
                    $res['name'] = $info->getFilename();
                    $res['filepath'] = 'uploads/text/'.$info->getSaveName();
                }else{
                    $res['code'] = 0;
                    $res['msg'] = 'Upload Failed！'.$file->getError();
                }
            }else{
                $res['code'] = 0;
                $res['msg'] = '10M maximum Size！';
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
                $this->success('SuccessFully！','index');
            }else{
                $this->error('Failed！','index');
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
                ->order('torder asc,id desc')
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
                $res['msg'] = 'Already House url！';
            }else {
                $res['code'] = 1;
                $res['msg'] = 'Available!';
            }
        }else{
            $isRepeat=Db::table('tk_houses')
                ->where(['http' => $order_id])
                ->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = 'Already House url！！';
            }else {
                $res['code'] = 1;
                $res['msg'] = 'Available!';
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
        $lang = new Languages();
        $langs = $lang->getLang();
        $enLab = $lang->getLanguages();
        $cityinfo = Db::table('tk_cate')
            ->where(['pid' =>0])
            ->field('id,name,ename')
            ->select();
        foreach ($cityinfo as $k => $v){
            if($langs != 'Cn'){
                $cityinfo[$k]['sname'] = $v['ename'];
            }else{
                $cityinfo[$k]['sname'] = $v['name'];
            }
        }
        $this->assign('lable',$enLab);
        $this->assign('cityinfo',$cityinfo);
        return $this->fetch();
    }

    public function myData(){
        $adminId = session('adminId');
        $where ='is_del = 1 and  ( user_id = '.$adminId.' or pm = '.$adminId.') and is_admin = 2 ';
        $keywords = trim($this->request->param('keywords'));
        $time = trim($this->request->param('time'));
        $keytype = trim($this->request->param('keytype'));
        $city = trim($this->request->param('city'));
        $area = trim($this->request->param('area'));
        $status = trim($this->request->param('status'));
        $top = trim($this->request->param('top'));
        $tj = trim($this->request->param('tj'));
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
        if($keytype == 1){
            if(isset($keywords) && !empty($keywords)){
                $where.=" and title like '%".$keywords."%' ";
            }
        }
        if($keytype == 2){
            if(isset($keywords) && !empty($keywords)){
                $where.=" and dsn like '%".$keywords."%' ";
            }
        }
        if($keytype == 3){
            if(isset($keywords) && !empty($keywords)){
                $where.=" and address like '%".$keywords."%' ";
            }
        }
        if($keytype == 5){
            if(isset($keywords) && !empty($keywords)){
                $where.=" and content like '%".$keywords."%' ";
            }
        }
        if(isset($status) && !empty($status) && $status){
            $status = $status == 3 ? 0:$status;
            $where.=" and status = ".$status;
        }
         //公司
        if($keytype == 6){
            if(isset($keywords) && !empty($keywords)){
                $users = Db::table('xcx_corp')
                    ->where("cp_name like '%".$keywords."%'")
                    ->column('cp_id');
                $userStr = '';
                if($users){
                    foreach ($users as $k => $v){
                        $userStr.= ",'".$v."'";
                    }
                }
                $userIdsStr = trim($userStr,',');
                if($userIdsStr){
                    $where .=' and  ( corp  in ('.$userIdsStr.') and is_admin = 2 ) ';
                }
            }
        }
        //PM
        if($keytype == 7){
            if(isset($keywords) && !empty($keywords)){
                $users = Db::table('super_admin')
                    ->where("ad_realname like '%".$keywords."%'")
                    ->column('ad_id');
                $userStr = '';
                if($users){
                    foreach ($users as $k => $v){
                        $userStr.= ",'".$v."'";
                    }
                }
                $userIdsStr = trim($userStr,',');
                if($userIdsStr){
                    $where .=' and  ( pm  in ('.$userIdsStr.') and is_admin = 2 ) ';
                }
            }
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
        $limit=$this->request->param('limit',50,'intval');
        $order = 'top desc,cdate desc';
        $orders = trim($this->request->param('order'));
        if(isset($orders) && !empty($orders) && $orders){
            switch ($orders)
            {
                case 1:
                    $order ="view desc";
                    break;
                case 2:
                    $order ="view asc";
                    break;
                case 3:
                    $order ="collection desc";
                    break;
                case 4:
                    $order ="collection asc";
                    break;
                case 5:
                    $order ="cdate desc";
                    break;
                case 6:
                    $order ="cdate asc";
                    break;
                default:
                    $order = 'top desc,cdate desc';
            }
        }
        $design=Db::table('tk_houses')
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
            $design[$k]['price'] = $this->getPrice($v['price']);
            $design[$k]['corp'] = $this->getCorp($v['corp']);
            $design[$k]['pm'] = $this->getPmname($v['pm']);
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        $res['where'] = $where;
        return json($res);
    }


    public function getSchoolss(){
        $city = $this->request->param('city');
        $cityId = Db::table('tk_cate')
            ->where(['name' => $city,'pid' => 0])
            ->field('id')
            ->find();
        if($cityId){
            $where = "pid = ".$cityId['id']." and type = 2";
            $result = Db::table('tk_cate')
                ->where($where)
                ->field('id,name,ename,pid,oseq')
                ->order('oseq asc')
                ->select();
            if($result){
                $lang = new Languages();
                $langs = $lang->getLang();
                foreach ($result as $k => $v){
                    if($langs != 'Cn'){
                        $result[$k]['sname'] = $v['ename'];
                    }else{
                        $result[$k]['sname'] = $v['name'];
                    }
                }
                return  json(['code' => '1','data' => $result]);
            }else{
                return  json(['code' => '0','data' => ['']]);
            }
        }
        return  json(['code' => '0','data' => ['']]);
    }

    public function usertop(){
        $adminId = session('adminId');
        $hid = $this->request->param('id',22,'intval');
        $date = date('Y-m-d');
        $isTopable = $this->topCount($adminId,$date);
        if(!$isTopable){
            $this->success('You have no times left！');
        }
        //写入一条置顶记录；
        $log['tp_hid'] = $hid;
        $log['tp_uid'] = 0;
        $log['tp_aid'] = $adminId;
        $log['tp_date'] = $date;
        $log['tp_top_time'] = date('Y-m-d H:i:s');
        $insert = Db::table('xcx_house_top')->insertGetId($log);
        //更新房源发布时间
        $updateHouseCtime = Db::table('tk_houses')
            ->where(['id' => $hid])
            ->update(['cdate' => date('Y-m-d H:i:s')]);
        $count = $isTopable-1;
        //$lang = $this->getLang();
        $lang = 'En';
        if($lang == 'Cn'){
            $msg = '置顶成功！您今日还剩'.$count.'次置顶机会！';
        }else{
            $msg = 'Succeed! You have '.$count.' times left today!';
        }
        if($insert && $updateHouseCtime){
            $this->success($msg);
        }
        $this->error('Failed！');
    }


    public function topCount($uId,$date){
        $topInfo = Db::table('xcx_house_top')
            ->where(['tp_aid' => $uId,'tp_date' =>$date])
            ->count('tp_id');
        $count = 10-$topInfo;
        return $count;
    }






}