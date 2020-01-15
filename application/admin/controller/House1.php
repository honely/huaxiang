<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/9/9
 * Time: 10:11
 * Name: 房源管理
 */
namespace app\admin\controller;
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
     * */
    public function index(){
        return $this->fetch();
    }

    public function houseData(){
        $where =' 1 = 1';
        $keywords = trim($this->request->param('keywords'));
        $case_decotime=trim($this->request->param('case_decotime'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( h_name like '%".$keywords."%' or h_b_id like '%".$keywords."%' )";
        }
        if(isset($case_decotime) && !empty($case_decotime)){
            $sdate=strtotime(substr($case_decotime,'0','10')." 00:00:00");
            $edate=strtotime(substr($case_decotime,'-10')." 23:59:59");
            $where.=" and ( h_addtime >= ".$sdate." and h_addtime <= ".$edate." ) ";
        }
        $count=Db::table('super_houses')
            ->join('super_province','super_province.p_id = super_houses.h_p_id')
            ->join('super_city','super_city.c_id = super_houses.h_c_id')
            ->join('super_area','super_area.area_id = super_houses.h_a_id')
            ->join('super_admin','super_admin.ad_id = super_houses.h_admin')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $design=Db::table('super_houses')
            ->join('super_province','super_province.p_id = super_houses.h_p_id')
            ->join('super_city','super_city.c_id = super_houses.h_c_id')
            ->join('super_area','super_area.area_id = super_houses.h_a_id')
            ->join('super_admin','super_admin.ad_id = super_houses.h_admin')
            ->limit(($page-1)*$limit,$limit)
            ->order('h_istop asc,h_isable,h_view desc')
            ->where($where)
            ->select();
        if($design){
            foreach($design as $key => $val){
                $type=$val['h_rent_type']== 1 ? '月':'日';
                $design[$key]['h_updatetime'] = date('Y-m-d H:i:s',$val['h_updatetime']);
                $design[$key]['h_iscop'] = $val['h_iscop']== 1 ? '整租':'合租';
                $design[$key]['c_name'] = $val['c_name']."-".$val['area_name'];
                $design[$key]['h_rent'] = "￥".$val['h_rent']."/".$type;
                $design[$key]['case_num']=Db::table('super_case')->where(['case_designer' => $val['h_id']])->count();
            }
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
            $data=$_POST;
            $data['h_addtime']=time();
            $data['h_updatetime']=time();
            $data['h_config'] =implode(',',array_keys($_POST['h_config']));
            $img=$_POST['h_img'];
            $h_img='';
            for ($i=0;$i<sizeof($img);$i++){
                $h_img.=$img[$i].",";
            }
            $data['h_img']=trim($h_img,',');
            $data['h_admin'] = session('adminId');
            $add=Db::table('super_houses')->insert($data);
            if($add){
                return  json(['code' => '1','msg' => '发布成功！','data' => $data]);
            }else{
                return  json(['code' => '2','msg' => '发布失败！','data' => $data]);
            }
        }else{
            //房屋配置 备选
            $houseConf=Db::table('super_type')
                ->where(['type_sort' => 2,'type_isable' => 1])
                ->order('type_order')
                ->select();
            $this->assign('houseConf',$houseConf);
            //房屋类型 备选
            $houseType=Db::table('super_type')
                ->where(['type_sort' => 1,'type_isable' => 1])
                ->order('type_order')
                ->select();
            $this->assign('houseType',$houseType);
            $provInfo=Db::table('super_province')->select();
            $this->assign('prov',$provInfo);
            return $this->fetch();
        }

    }

    /*
     * 房源修改
     * */
    public function edit(){
        $h_id=intval(trim($_GET['h_id']));
        if($_POST){
            $data=$_POST;
            $data['h_updatetime']=time();
            $data['h_config'] =implode(',',array_keys($_POST['h_config']));
            $img=$_POST['h_img'];
            $h_img='';
            for ($i=0;$i<sizeof($img);$i++){
                $h_img.=$img[$i].",";
            }
            $data['h_img']=trim($h_img,',');
            $data['h_admin'] = session('adminId');
            $update=Db::table('super_houses')->where(['h_id' => $h_id])->update($data);
            if($update){
                return  json(['code' => '1','msg' => '修改成功！','data' => $data]);
            }else{
                return  json(['code' => '2','msg' => '修改失败！','data' => $data]);
            }
        }else{
            $houseInfo=Db::table('super_houses')->where(['h_id' => $h_id])->find();
            $houseInfo['h_imgs']=rtrim($houseInfo['h_img'],',');
            $houseInfo['h_img']=explode(',',$houseInfo['h_imgs']);
            $type_list = "";
            if($houseInfo['h_config']){
                $type_list = explode(',',trim($houseInfo['h_config'],','));
            }
            $this->assign('type_list',$type_list);
            $this->assign('house',$houseInfo);
            $city=Db::table('super_city')->where(['p_id' => $houseInfo['h_p_id']])->select();
            $this->assign('city',$city);
            $area=Db::table('super_area')->where(['area_c_id' => $houseInfo['h_c_id']])->select();
            $this->assign('area',$area);
            //房屋配置 备选
            $houseConf=Db::table('super_type')
                ->where(['type_sort' => 2,'type_isable' => 1])
                ->order('type_order')
                ->select();
            $this->assign('houseConf',$houseConf);
            //房屋类型 备选
            $houseType=Db::table('super_type')
                ->where(['type_sort' => 1,'type_isable' => 1])
                ->order('type_order')
                ->select();
            $this->assign('houseType',$houseType);
            $provInfo=Db::table('super_province')->select();
            $this->assign('prov',$provInfo);
            return $this->fetch();
        }
    }





    //更改是否显示的状态
    public function status(){
        $h_id = $_GET['h_id'];
        $change = $_GET['change'];
        if($h_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '显示';
                $data['h_isable'] = '1';
                $data['h_admin'] = session('adminId');
            }else{
                $msg = '隐藏';
                $data['h_isable'] = '2';
                $data['h_istop'] = '2';
                $data['h_admin'] = session('adminId');
            }
            $changeStatus = Db::table('super_houses')->where(['h_id' => $h_id])->update($data);
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

    //top
    public function top(){
        $h_id = $_GET['h_id'];
        $change = $_GET['change'];
        if($h_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '置顶';
                $data['h_istop'] = '1';
                $data['h_admin'] = session('adminId');
            }else{
                $msg = '取消置顶';
                $data['h_istop'] = '2';
                $data['h_admin'] = session('adminId');
            }
            $changeStatus = Db::table('super_houses')->where(['h_id' => $h_id])->update($data);
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




    /*
     * 删除某一房源
     * */
    public function del(){
        $h_id=intval($_GET['h_id']);
        $delArt=Db::table('super_houses')->where(['h_id' => $h_id])->delete();
        if($delArt){
            $this->success('删除房源成功','index');
        }else{
            $this->error('删除房源失败','index');
        }
    }


    public function refresh(){
        $h_id=intval($_GET['h_id']);
        $refresh=Db::table('super_houses')->where(['h_id' => $h_id])->update(['h_updatetime' => time()]);
        $setView=Db::table('super_houses')->where(['h_id' => $h_id])->setInc('h_view');
        if($refresh && $setView){
            $this->success('刷新房源成功','index');
        }else{
            $this->error('刷新房源失败','index');
        }
    }



    /*
     * 房源托管列表
     * */
    public function seek(){
        $admin_id=session('adminId');
        $regin = Db::table('super_city')->field('c_id,c_name')->select();
        if($regin){
           $this->assign('regin',$regin);
        }
        $this->assign('admin_id',$admin_id);
        return $this->fetch();
    }




    public function seekData(){
        $where =' 1 = 1 ';
        $city_id=session('ad_c_id');
        $admin_id=session('adminId');
        if($admin_id != 1){
            if(!empty($city_id)){
                $where .=' and dp_c_id = '.$city_id;
            }
        }
        $case_admin = trim($this->request->param('case_admin'));
        if(isset($case_admin) && !empty($case_admin)){
            $where.=" and dp_c_id = ".$case_admin;
        }
        $count=Db::table('super_deposit')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $design=Db::table('super_deposit')
            ->limit(($page-1)*$limit,$limit)
            ->order('dp_addtime desc')
            ->where($where)
            ->select();
        if($design){
            foreach($design as $key => $val){
                $design[$key]['dp_area'] = $this->getCityNameViaCid($val['dp_c_id']);
                $design[$key]['dp_addtime'] = date('Y-m-d H:i:s',$val['dp_addtime']);
                $design[$key]['dp_updatetime'] = date('Y-m-d H:i:s',$val['dp_updatetime']);
                $design[$key]['dp_admin'] = $val['dp_admin'] == null? '暂未回访':Db::table('super_admin')->where(['ad_id ' => $val['dp_admin']])->column('ad_realname');
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        return json($res);
    }

    public function getCityNameViaCid($c_id){
        $cityName=Db::table('super_city')->where(['c_id' => $c_id])->column('c_name');
        return $cityName?$cityName[0]:'西安';
    }

    /*
     * delseek
     *
     * */
    public function delseek(){
        $dp_id=intval($_GET['dp_id']);
        $delArt=Db::table('super_deposit')->where(['dp_id' => $dp_id])->delete();
        if($delArt){
            $this->success('删除成功','seek');
        }else{
            $this->error('删除失败','seek');
        }
    }


    /*
     * editseek
     * */
    public function editseek(){
        $dp_id=intval(trim($_GET['dp_id']));
        $deposit=Db::table('super_deposit')->where(['dp_id' => $dp_id])->find();
        $deposit['dp_addtime']=date('Y-m-d H:i:s',$deposit['dp_addtime']);
        $this->assign('deposit',$deposit);
        return $this->fetch();
    }

    /*
     *
     * editdept
     * */
    public function editdept(){
        $dp_id=intval(trim($_GET['dp_id']));
        $data['dp_tips']=$_POST['dp_tips'];
        $data['dp_updatetime'] = time();
        $data['dp_admin'] = session('adminId');
        $update=Db::table('super_deposit')->where(['dp_id' => $dp_id])->update($data);
        if($update){
            $this->success('修改成功！');
        }else{
            $this->success('修改失败！');
        }
    }



    /*
     *预约看房
     **/
    public function orders(){
        return $this->fetch();
    }

    public function orderData(){
        $where =' 1 = 1';
        $keywords = trim($this->request->param('keywords'));
        $case_decotime=trim($this->request->param('case_decotime'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( h_name like '%".$keywords."%' or h_b_id like '%".$keywords."%' )";
        }
        if(isset($case_decotime) && !empty($case_decotime)){
            $sdate=strtotime(substr($case_decotime,'0','10')." 00:00:00");
            $edate=strtotime(substr($case_decotime,'-10')." 23:59:59");
            $where.=" and ( h_addtime >= ".$sdate." and h_addtime <= ".$edate." ) ";
        }
        $count=Db::table('super_house_order')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $design=Db::table('super_house_order')
            ->limit(($page-1)*$limit,$limit)
            ->where($where)
            ->order('ho_addtime desc')
            ->select();
        if($design){
            foreach($design as $key => $val){
                $design[$key]['ho_addtime'] = date('Y-m-d H:i:s',$val['ho_addtime']);
            }
        }
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        return json($res);
    }


    public function addquiz(){
        return $this->fetch();
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

}