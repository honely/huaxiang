<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/5/2
 * Time: 10:15
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
class Designer extends Controller{
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
    //设计师
    public function designData(){

        $ad_role=intval(session('ad_role'));
        //分站id
        $ad_branch = intval(session('ad_branch'));
        if($ad_role == 1 ){// 超级管理员
            $where =' 1 = 1';
        }else{
            $where=' des_b_id = '.$ad_branch;
        }
        $keywords = trim($this->request->param('keywords'));
        $case_p_id = intval(trim($this->request->param('case_p_id')));
        $bu_c_id = intval(trim($this->request->param('bu_c_id')));
        $branch = intval(trim($this->request->param('branch')));
        $case_isable = intval(trim($this->request->param('case_isable')));
        $case_admin = intval(trim($this->request->param('case_admin')));
        $case_decotime=trim($this->request->param('case_decotime'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( des_name like '%".$keywords."%' or des_bid like '%".$keywords."%' )";
        }
        if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
            $where.=" and des_p_id = ".$case_p_id;
        }
        if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
            $where.=" and des_c_id = ".$bu_c_id;
        }
        if(isset($branch) && !empty($branch) && $branch){
            $where.=" and des_b_id = ".$branch;
        }
        if(isset($case_isable) && !empty($case_isable)){
            $where.=" and des_isable = ".$case_isable;
        }
        if(isset($case_admin) && !empty($case_admin)){
            $where.=" and dec_admin = ".$case_admin;
        }
        if(isset($case_decotime) && !empty($case_decotime)){
            $sdate=strtotime(substr($case_decotime,'0','10')." 00:00:00");
            $edate=strtotime(substr($case_decotime,'-10')." 23:59:59");
            $where.=" and ( des_createtime >= ".$sdate." and des_createtime <= ".$edate." ) ";
        }
        $count=Db::table('super_designer')
            ->join('super_province','super_province.p_id = super_designer.des_p_id')
            ->join('super_city','super_city.c_id = super_designer.des_c_id')
            ->join('super_branch','super_branch.b_id = super_designer.des_b_id')
            ->join('super_admin','super_admin.ad_id = super_designer.dec_admin')
            ->where($where)
            ->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $design=Db::table('super_designer')
            ->join('super_province','super_province.p_id = super_designer.des_p_id')
            ->join('super_city','super_city.c_id = super_designer.des_c_id')
            ->join('super_branch','super_branch.b_id = super_designer.des_b_id')
            ->join('super_admin','super_admin.ad_id = super_designer.dec_admin')
            ->limit(($page-1)*$limit,$limit)
            ->order('des_istop asc,des_isable,des_view desc')
            ->where($where)
            ->select();
		if($design){
			foreach($design as $key => $val){
				$type_id = explode(',',trim($val['des_tanlent'],','));
				$type_val = "";
				for($i = 0; $i < count($type_id); $i++){
					$typeData = Db::table("super_type")
								->where(["type_id" => $type_id[$i]])
								->find();
					$type_val .= $typeData ? $typeData['type_name'].',' : "";			
				}
				$design[$key]['type_name'] = trim($type_val,',');
				$design[$key]['des_updatetime'] = date('Y-m-d H:i:s',$val['des_updatetime']);
				$design[$key]['c_name'] = $val['p_name']."-".$val['c_name'];
				$design[$key]['case_num']=Db::table('super_case')->where(['case_designer' => $val['des_id']])->count();
			}
		}
        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        return json($res);
    }


    public function team(){
        $ad_role=intval(session('ad_role'));
        $this->assign('ad_role',$ad_role);
        //分站id
        $ad_branch = intval(session('ad_branch'));
        if($ad_role == 1 ){// 超级管理员
            $admin = Db::table('super_admin')->where(['ad_isable' => 1])->select();
            $where =' 1 = 1';
        }else{
            $admin = Db::table('super_admin')->where(['ad_isable' => 1,'ad_branch' => $ad_branch])->select();
            $where=' des_b_id = '.$ad_branch;
        }
        $this->assign('admin',$admin);
        if($_POST){
            $keywords=trim($_POST['keywords']);
            $case_p_id=trim($_POST['case_p_id']);
            $bu_c_id=trim($_POST['bu_c_id']);
            $branch=trim($_POST['branch']);
            $case_decotime=trim($_POST['case_decotime']);
            $case_admin=intval(trim($_POST['case_admin']));

            if(isset($keywords) && !empty($keywords)){
                $where.=" and ( des_name like '%".$keywords."%' or des_bid like '%".$keywords."%' )";
            }
            if(isset($case_p_id) && !empty($case_p_id) && $case_p_id){
                $where.=" and des_p_id = ".$case_p_id;
            }
            if(isset($bu_c_id) && !empty($bu_c_id) && $bu_c_id){
                $where.=" and des_c_id = ".$bu_c_id;
            }
            if(isset($branch) && !empty($branch) && $branch){
                $where.=" and des_b_id = ".$branch;
            }
            if(isset($case_isable) && !empty($case_isable)){
                $where.=" and des_isable = ".$case_isable;
            }
            if(isset($case_admin) && !empty($case_admin)){
                $where.=" and dec_admin = ".$case_admin;
            }
            if(isset($case_decotime) && !empty($case_decotime)){
                $sdate=strtotime(substr($case_decotime,'0','10')." 00:00:00");
                $edate=strtotime(substr($case_decotime,'-10')." 23:59:59");
                $where.=" and ( des_createtime >= ".$sdate." and des_createtime <= ".$edate." ) ";
            }
            //已展示
            $data['display']=Db::table('super_designer')
                ->join('super_province','super_province.p_id = super_designer.des_p_id')
                ->join('super_city','super_city.c_id = super_designer.des_c_id')
                ->join('super_branch','super_branch.b_id = super_designer.des_b_id')
                ->join('super_admin','super_admin.ad_id = super_designer.dec_admin')
                ->where($where)
                ->where(['des_isable' => 1])
                ->count();
            //未展示
            $data['none']=Db::table('super_designer')
                ->join('super_province','super_province.p_id = super_designer.des_p_id')
                ->join('super_city','super_city.c_id = super_designer.des_c_id')
                ->join('super_branch','super_branch.b_id = super_designer.des_b_id')
                ->join('super_admin','super_admin.ad_id = super_designer.dec_admin')
                ->where($where)
                ->where(['des_isable' => 2])
                ->count();
            $data['all']=intval($data['display'])+intval($data['none']);
            return $data;
        }
        $disShow=Db::table('super_designer')
            ->where($where)
            ->where(['des_isable' => 1])
            ->count();
        $disNone=Db::table('super_designer')
            ->where($where)
            ->where(['des_isable' => 2])
            ->count();
        $this->assign('show',$disShow);
        $this->assign('none',$disNone);
        $this->assign('all',intval($disShow)+intval($disNone));
        return $this->fetch();
    }







    //更改是否显示的状态
    public function status(){
        $ba_id = intval($_GET['des_id']);
        $change = $_GET['change'];
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '显示';
                $data['des_isable'] = '1';
            }else{
                $msg = '隐藏';
                $data['des_isable'] = '2';
            }
            $changeStatus = Db::table('super_designer')->where(['des_id' => $ba_id])->update($data);
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
    public function top(){
        $ba_id = $_GET['des_id'];
        $change = $_GET['change'];
        if($ba_id && isset($change)){
            if($change){
                $msg = '置顶';
                $data['des_istop'] = '1';
            }else{
                $msg = '取消置顶';
                $data['des_istop'] = '2';
            }
            $changeStatus = Db::table('super_designer')->where(['des_id' => $ba_id])->update($data);
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








    public function checkBuname(){
        $des_id=$_POST['des_id'];
        $des_name=$_POST['des_name'];
        if($des_id){
            $isRepeat=Db::table('super_designer')
                ->where('des_id','neq',$des_id)
                ->where(['des_name' => $des_name])
                ->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '此设计师名字与已有重复，请换一个！';
            }else{
                $res['code'] = 1;
                $res['msg'] = '此名字经过检测可用。';
            }
        }else{
            $isRepeat=Db::table('super_designer')->where(['des_name' => $des_name])->find();
            if($isRepeat){
                $res['code'] = 2;
                $res['msg'] = '此设计师名字与已有重复，请换一个！';
            }else {
                $res['code'] = 1;
                $res['msg'] = '此名称经过检测可用。';
            }
        }
        return $res;
    }










    //添加设计师
    public function add(){
        $adminId=intval(session('adminId'));
        $ad_role=intval(session('ad_role'));
        if($_POST){
            $stime=strtotime(date('Y-m-d 00:00:00'));
            $etime=strtotime(date('Y-m-d 23:59:59'));
            //获取当日预约的数量
            $buNum=Db::table('super_designer')->where('des_createtime','between',[$stime,$etime])->count();
            //生成用户编号；
            $data['des_bid'] = date('Ymd').sprintf("%04d", $buNum+1);
            $data['des_name'] = $_POST['des_name'];
            $isRepeat=Db::table('super_designer')->where(['des_name' => $data['des_name']])->find();
            if($isRepeat){
                $this->error('此设计师名字与已有重复，请换一个！','add');
            }
            $data['des_img'] = $_POST['des_img'];
            $data['des_avatar'] = $_POST['des_avatar'];
            $data['des_age'] = intval($_POST['des_age']);
            $data['des_exp'] = intval($_POST['des_exp']);
            $data['des_img_alt'] = $_POST['des_img_alt'];
            $data['des_tanlent'] =implode(',',array_keys($_POST['des_tanlent']));
            $data['des_guand'] = $_POST['des_guand'];
            $data['des_remarks'] = $_POST['des_remarks'];
            $data['des_istop'] = $_POST['des_istop'];
            $data['des_p_id'] = $ad_role == 1 ? $_POST['des_p_id']: session('ad_p_id');
            $data['des_c_id'] = $ad_role == 1 ? $_POST['des_c_id']: session('ad_c_id');
            $data['des_b_id'] = $ad_role == 1 ? $_POST['des_b_id']: session('ad_branch');
            $data['des_seo_keywords'] = $_POST['des_seo_keywords'];
            $data['des_seo_desc'] = $_POST['des_remarks'];
            $data['des_createtime'] = time();
            $data['des_updatetime'] = time();
            $data['dec_admin'] = session('adminId');
            $add=Db::table('super_designer')->insert($data);
            if($add){
                $this->success('添加设计师成功','team');
            }else{
                $this->error('添加设计师失败','team');
            }
        }else{
            $provInfo=Db::table('super_province')->select();
            $this->assign('prov',$provInfo);
            //设计风格
            $designStyle = Db::table('super_type')
                           ->where(['type_sort' => '2','type_isable' => '1'])
                           ->select();
            $this->assign('designStyle',$designStyle);
            if($ad_role == 1 ){// 超级管理员
                $provInfo=Db::table('super_province')->select();
                $this->assign('prov',$provInfo);
            }else{
                $adminInfo=Db::table('super_admin')
                    ->join('super_province','super_province.p_id = super_admin.ad_p_id')
                    ->join('super_city','super_city.c_id = super_admin.ad_c_id')
                    ->join('super_role','super_role.r_id = super_admin.ad_role')
                    ->join('super_branch','super_branch.b_id = super_admin.ad_branch')
                    ->field('super_admin.ad_realname,super_province.p_name,super_city.c_name,super_branch.b_name,super_role.r_name')
                    ->where(['ad_id' => $adminId])
                    ->find();
                $this->assign('admin',$adminInfo);
            }
            $this->assign('ad_role',$ad_role);
            return $this->fetch();
        }
    }

    //修改设计师
    public function edit(){
        $ad_role=intval(session('ad_role'));
        $des_id=intval($_GET['des_id']);
        if($_POST){
            $data['des_name'] = $_POST['des_name'];
            $isRepeat=Db::table('super_designer')
                ->where('des_id','neq',$des_id)
                ->where(['des_name' => $data['des_name']])
                ->find();
            if($isRepeat){
                $this->error('此楼盘名称与已有重复，请换一个！','team');
                //$this->error('此楼盘名称已被占用','edit',array('bu_id'=>$bu_id));
            }
            $data['des_img'] = $_POST['des_img'];
            $data['des_avatar'] = $_POST['des_avatar'];
            $data['des_age'] = intval($_POST['des_age']);
            $data['des_exp'] = intval($_POST['des_exp']);
            $data['des_img_alt'] = $_POST['des_img_alt'];
            $data['des_tanlent'] = implode(',',array_keys($_POST['des_tanlent']));
            $data['des_guand'] = $_POST['des_guand'];
            $data['des_remarks'] = $_POST['des_remarks'];
            $data['des_istop'] = $_POST['des_istop'];
            if($ad_role == 1){
                $data['des_p_id'] = $_POST['des_p_id'];
                $data['des_c_id'] = $_POST['des_c_id'];
                $data['des_b_id'] = $_POST['des_b_id'];
            }
            $data['des_seo_keywords'] = $_POST['des_seo_keywords'];
            $data['des_seo_desc'] = $_POST['des_remarks'];
            $data['des_updatetime'] = time();
            $data['dec_admin'] = session('adminId');
            $edit=Db::table('super_designer')->where(['des_id' => $des_id])->update($data);
            if($edit){
                $this->success('修改设计师成功！','team');
            }else{
                $this->error('修改设计师失败！','team');
            }
        }else{
            $designInfo=Db::table('super_designer')
                ->join('super_province','super_province.p_id = super_designer.des_p_id')
                ->join('super_city','super_city.c_id = super_designer.des_c_id')
                ->join('super_branch','super_branch.b_id = super_designer.des_b_id')
                ->where(['des_id' => $des_id])
                ->field('super_designer.*,super_province.p_name,super_city.c_name,super_branch.b_name')
                ->find();
            $provid=$designInfo['des_p_id'];
            $type_list = "";
            if($designInfo['des_tanlent']){
                $type_list = explode(',',trim($designInfo['des_tanlent'],','));
            }

            $cusCity=Db::table('super_city')->where(['p_id' => $provid])->select();
            //设计风格
            $designStyle = Db::table('super_type')
                ->where(['type_sort' => '2','type_isable' => '1'])
                ->select();
            $c_id=$designInfo['des_c_id'];
            $branch=Db::table('super_branch')->where(['b_city' =>$c_id ])->field('b_id,b_name')->select();
            $this->assign('branchs',$branch);
            $this->assign('city',$cusCity);
            $this->assign('design',$designInfo);
            $this->assign('designStyle',$designStyle);
            $this->assign('type_list',$type_list);
            if($ad_role == 1 ){// 超级管理员
                $provInfo=Db::table('super_province')->select();
                $this->assign('prov',$provInfo);
            }
            $this->assign('ad_role',$ad_role);
            return $this->fetch();
        }
    }


    //删除设计师
    public function del(){
        $des_id=intval($_GET['des_id']);
        $del=Db::table('super_designer')->where(['des_id' => $des_id])->delete();
        if($del){
            $this->success('删除设计师成功','team');
        }else{
            $this->error('删除设计师失败','team');
        }
    }

    //刷新设计师
    public function refresh(){
        $des_id=intval($_GET['des_id']);
        $del=Db::table('super_designer')->where(['des_id' => $des_id])->update(['des_updatetime' => time()]);
        if($del){
            $this->success('刷新设计师成功','team');
        }else{
            $this->error('刷新设计师失败','team');
        }
    }



    //设计师图片上传
    public function upload(){
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/designer');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/designer/".$path_date."/".$path_filename;
            // 成功上传后 返回上传信息
            return json(array('state'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
        }else{
            // 上传失败返回错误信息
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }

}