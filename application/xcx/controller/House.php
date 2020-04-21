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
use think\Controller;
use think\Db;
use think\Request;

class House extends Controller{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $adminName=session('adminId');
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
        return $this->fetch();
    }

    public function houseData(){
        $where =' 1 = 1';
        $keywords = trim($this->request->param('keywords'));
        $case_decotime=trim($this->request->param('case_decotime'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( title like '%".$keywords."%' or dsn like '%".$keywords."%' )";
        }
        if(isset($case_decotime) && !empty($case_decotime)){
            $sdate=strtotime(substr($case_decotime,'0','10')." 00:00:00");
            $edate=strtotime(substr($case_decotime,'-10')." 23:59:59");
            $where.=" and ( cdate >= ".$sdate." and cdate <= ".$edate." ) ";
        }
        $count=Db::table('tk_houses')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $design=Db::table('tk_houses')
            ->limit(($page-1)*$limit,$limit)
            ->order('top desc,mdate desc')
            ->where($where)
            ->select();
        foreach ($design as $k => $v){
            $design[$k]['status'] = $this->houseStatus($v['status']);
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        return json($res);
    }

    /*
     * 房源添加
     * */
    public function add(){
        if($_POST){
            $data = $_POST;
            $bill = $_POST['bill'];
            $bills = '';
            foreach($bill as $key => $val){
                $bills .= $key.',';
            }
            $data['bill'] = rtrim($bills,',');
            $home = $_POST['home'];
            $homes = '';
            foreach($home as $key => $val){
                $homes .= $key.',';
            }
            $data['home'] = rtrim($homes,',');
            $sation = $_POST['sation'];
            $sations = '';
            foreach($sation as $key => $val){
                $sations .= $key.',';
            }
            $img=$_POST['images'];
            $h_img='';
            for ($i=0;$i<sizeof($img);$i++){
                $h_img.=$img[$i].",";
            }
            $data['images'] = rtrim($h_img,',');
            $data['sation'] = rtrim($sations,',');
            $data['publish_date'] = date('Y-m-d H:i:s');
            $data['cdate'] = date('Y-m-d H:i:s');
            $data['mdate'] = date('Y-m-d H:i:s');
            $data['status'] = 1;
            unset($data['file']);
            $data['dsn'] = $this->genHouseDsn();
            $add=Db::table('tk_houses')->insert($data);
            if($add){
                $this->success('添加成功！');
            }else{
                $this->error('添加失败！');
            }
        }else{
            $apartemnt  = Db::table('tk_apartment')
                ->where('status','1')
                ->field('id,title,content,thumbnail')
                ->select();
            $city = Db::table('tk_cate')->where(['pid' => 0])->select();
            $this->assign('city',$city);
            $this->assign('apartemnt',$apartemnt);
            return $this->fetch();
        }

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
        if($_POST){
            $data = $_POST;
            $bill = $_POST['bill'];
            $bills = '';
            foreach($bill as $key => $val){
                $bills .= $key.',';
            }
            $data['bill'] = rtrim($bills,',');
            $home = $_POST['home'];
            $homes = '';
            foreach($home as $key => $val){
                $homes .= $key.',';
            }
            $data['home'] = rtrim($homes,',');
            $sation = $_POST['sation'];
            $sations = '';
            foreach($sation as $key => $val){
                $sations .= $key.',';
            }
            $img=$_POST['images'];
            $h_img='';
            for ($i=0;$i<sizeof($img);$i++){
                $h_img.=$img[$i].",";
            }
            $data['images'] = rtrim($h_img,',');
            $data['sation'] = rtrim($sations,',');
            $data['publish_date'] = date('Y-m-d H:i:s');
            $data['mdate'] = date('Y-m-d H:i:s');
            unset($data['file']);
            $add=Db::table('tk_houses')->where(['id' => $id])->update($data);
            if($add){
                $this->success('修改成功！','index');
            }else{
                $this->error('修改失败！','index');
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
                    'bill' => '包煤气',
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
                    'set' => '车位',
                    'is_checked' => false
                ]
            ];
            $houseSet = explode(',',$houseInfo['home']);
            foreach ($all_set as $key => &$val) {
                if(in_array($val['set'], $houseSet)) {
                    $val['is_checked'] = true;
                }
            }unset($val);
            $houseInfo['set'] = $houseSet;

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
                    'trans' => '免费电车',
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

            $apartemnt  = Db::table('tk_apartment')
                ->where('status','1')
                ->field('id,title,content,thumbnail')
                ->select();
            $houseInfo['images1'] = explode(',',$houseInfo['images']);
            $city = Db::table('tk_cate')->where(['pid' => 0])->select();
            $this->assign('all_bill',$all_bill);
            $this->assign('all_trans',$all_trans);
            $this->assign('all_set',$all_set);
            $this->assign('city',$city);
            $this->assign('apartemnt',$apartemnt);
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
            ->field('city')
            ->find();
        $count =Db::table('tk_houses')
            ->where(['city' => $houseCity['city'],'top' => '是'])
            ->count();
        return $count >=5 ? false : true;
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
                'bill' => '包煤气',
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
                'set' => '车位',
                'is_checked' => false
            ]
        ];
        $houseSet = explode(',',$houseInfo['home']);
        foreach ($all_set as $key => &$val) {
            if(in_array($val['set'], $houseSet)) {
                $val['is_checked'] = true;
            }
        }unset($val);
        $houseInfo['set'] = $houseSet;

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
                'trans' => '免费电车',
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

        $apartemnt  = Db::table('tk_apartment')
            ->where('status','1')
            ->field('id,title,content,thumbnail')
            ->select();
        $houseInfo['images1'] = explode(',',$houseInfo['images']);
        $city = Db::table('tk_cate')->where(['pid' => 0])->select();
        $this->assign('all_bill',$all_bill);
        $this->assign('all_trans',$all_trans);
        $this->assign('all_set',$all_set);
        $this->assign('city',$city);
        $this->assign('apartemnt',$apartemnt);
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
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/text');
            //halt( $info);
            if($info){
                $res['name'] = $info->getFilename();
                $res['filepath'] = 'uploads/text/'.$info->getSaveName();
            }else{
                $res['code'] = 0;
                $res['msg'] = '上传失败！'.$file->getError();
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
}