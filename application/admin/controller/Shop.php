<?php


namespace app\admin\controller;


use think\Controller;
use app\admin\model\Shops;

class Shop extends Controller
{

    /***
     * Name: 商城商品列表方法
     * Created by DangMengmeng at 2019/9/9 10:42
     */
    public function index(){
        $shopModel = new Shops();

        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $where = " 1 = 1";
        $goods_name=trim($this->request->param('goods_name'));
        $goods_add_date=trim($this->request->param('goods_add_date'));
        $goods_type=intval(trim($this->request->param('goods_type')));
        $goods_sort=intval(trim($this->request->param('goods_sort')));
        if(isset($goods_name) && !empty($goods_name)){
            $where.=" and ( goods_name like '%".$goods_name."%')";
            $this->assign('goods_name',$goods_name);
        }
        if(isset($goods_type) && !empty($goods_type)){
            $where.=" and goods_type = ".$goods_type;
            $sorts = $shopModel->getSortList($goods_type);
            $this->assign('sorts',$sorts);
            $this->assign('goods_type',$goods_type);
        }
        if(isset($goods_sort) && !empty($goods_sort)){
            $where.=" and goods_sort = ".$goods_sort;
            $this->assign('goods_sort',$goods_sort);
        }
        if(isset($goods_add_date) && !empty($goods_add_date)){
            $sdate=strtotime(substr($goods_add_date,'0','10')." 00:00:00");
            $edate=strtotime(substr($goods_add_date,'-10')." 23:59:59");
            $where.=" and ( goods_add_date >= ".$sdate." and goods_add_date <= ".$edate." ) ";
            $this->assign('goods_add_date',$goods_add_date);
        }
        $count=$shopModel->countGoods($where);
        $list =$shopModel->getGoodsList($page,$limit,$where);
        $f_id = 0;
        $sort =$shopModel->getSortList($f_id);
        $this->assign('sort',$sort);
        $this->assign('list',$list);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('limit',$limit);
        $this->assign('list',$list);
        return $this->fetch();
    }

    /***
     * Name: 商品分类列表方法
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by DangMengmeng at 2019/9/9 11:52
     */
    public function sort(){
        //$f_id = trim($this->request->param('f_id'));
        $f_id = 0;
        $shopModel = new Shops();
        $list =$shopModel->getSortList($f_id);
        $this->assign('list',$list);
        return $this->fetch();
    }


    /***
     * Name: 添加商品分类方法
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by DangMengmeng at 2019/9/10 9:16
     */
    public function add(){
        $shopModel = new Shops();
        if($_POST){
            $data['ss_title'] = $_POST['ss_title'];
            $data['ss_f_id'] = $_POST['ss_f_id'];
            $data['ss_order'] = $_POST['ss_order'];
            $data['ss_icon'] = isset($_POST['ss_icon'])?$_POST['ss_icon']:'';
            $data['ss_del_flg'] = $_POST['ss_del_flg'];
            $data['ss_admin'] = session('adminId');
            $data['ss_add_date'] = time();
            $data['ss_change_date'] = time();
            $addNew =  $shopModel->addNewSort($data);
            if($addNew){
                $this->success('添加商品分类成功','sort');
            }else{
                $this->error('添加商品分类失败','sort');
            }
        }
        $f_id = 0;
        $list =$shopModel->getSortList($f_id);
        $this->assign('list',$list);
        return $this->fetch();
    }


    
    /***
     * Name: 修改商品分类方法
     * @return mixed
     * Created by DangMengmeng at 2019/9/9 14:13
     */
    public function edit(){
        $nav_id=intval($_GET['nav_id']);
        $nav_fid=intval($_GET['nav_fid']);
        $shopModel = new Shops();
        if($_POST){
            $data['ss_title'] = $_POST['ss_title'];
            $data['ss_order'] = $_POST['ss_order'];
            $data['ss_icon'] = isset($_POST['ss_icon'])?$_POST['ss_icon']:'';
            $data['ss_del_flg'] = $_POST['ss_del_flg'];
            $data['ss_admin'] = session('adminId');
            $data['ss_change_date'] = time();
            $edit = $shopModel->editSort($nav_id,$data);
            if($edit){
                $this->success('修改分类成功！','sort');
            }else{
                $this->error('修改分类成功！','sort');
            }
        }else{
            $navInfo=$shopModel->findOne($nav_id);
            $nav_f_info=$shopModel->findOne($nav_fid);
            $this->assign('nav_fid',$nav_fid);
            $this->assign('nav',$navInfo);
            $this->assign('f_name',$nav_f_info['ss_title']);
            return $this->fetch();
        }
    }



    /****
     * Name: 更改是否显示的状态方法
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * Created by DangMengmeng at 2019/9/10 9:17
     */
    public function status(){
        $ba_id = $_POST['nav_id'];
        $change = $_POST['change'];
        $shopModel = new Shops();
        if($ba_id && isset($change)){
            if($change){
                $msg = '显示';
                $data['ss_del_flg'] = '1';
            }else{
                $msg = '隐藏';
                $data['ss_del_flg'] = '2';
            }
            $changeStatus =$shopModel->editSort($ba_id,$data);
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
     * Name: 商品是否置顶
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * Created by DangMengmeng at 2019/9/11 15:55
     */
    public function goodsTop(){
        $ba_id = $_POST['nav_id'];
        $change = $_POST['change'];
        $shopModel = new Shops();
        if($ba_id && isset($change)){
            if($change){
                $msg = '置顶';
                $data['goods_top_flg'] = '1';
            }else{
                $msg = '取消置顶';
                $data['goods_top_flg'] = '2';
            }
            $changeStatus =$shopModel->editGoods($ba_id,$data);
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
     * Name: 商品分类图标上传方法
     * @return \think\response\Json
     * Created by DangMengmeng at 2019/9/9 13:40
     */
    public function upload(){
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/sort');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/sort/".$path_date."/".$path_filename;
            // 成功上传后 返回上传信息
            return json(array('state'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
        }else{
            // 上传失败返回错误信息
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }


    /**
     * Name: 商品添加方法 【第一步添加商品基础信息】
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by DangMengmeng at 2019/9/10 10:19
     */
    public function addProduct(){
        $shopModel = new Shops();
        if($_POST){
            $data['goods_name'] = $_POST['goods_name'];
            $data['goods_sort'] = $_POST['goods_sort'];
            $data['goods_type'] = $_POST['goods_type'];
            $data['goods_price'] = $_POST['goods_price'];
            $data['goods_dis_price'] = $_POST['goods_dis_price'];
            $data['goods_img'] = isset($_POST['goods_img'])?$_POST['goods_img']:'';
            $data['goods_admin'] = session('adminId');
            $data['goods_add_date'] = time();
            $data['goods_change_date'] = time();
            //是否多图
            $img = isset($_POST['goods_img_more'])?$_POST['goods_img_more']:array();
            $h_img = '';
            for ($i=0;$i<sizeof($img);$i++){
                $h_img.=$img[$i].",";
            }
            $data['goods_img_more']=trim($h_img,',');
            $addNew =  $shopModel->addProduct($data);
            if($addNew){
                return  json(['code' => '1','data' => $addNew]);
            }else{
                return  json(['code' => '0','data' => ['']]);
            }
        }else{
            $f_id = 0;
            $list =$shopModel->getSort($f_id);
            $this->assign('list',$list);
            return $this->fetch();
        }
    }


    /***
     * Name: 添加商品规格【第二步】
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by DangMengmeng at 2019/9/11 11:13
     */
    public function stepTwo(){
        $g_id = intval($_GET['g_id']);
        $shopModel = new Shops();
        if($_POST){
            $data['goods_name'] = $_POST['goods_name'];
            $data['goods_sort'] = $_POST['goods_sort'];
            $data['goods_price'] = $_POST['goods_price'];
            $data['goods_dis_price'] = $_POST['goods_dis_price'];
            $data['goods_img'] = isset($_POST['goods_img'])?$_POST['goods_img']:'';
            $data['goods_admin'] = session('adminId');
            $data['goods_add_date'] = time();
            $data['goods_change_date'] = time();
            //是否多图
            $img=$_POST['goods_img_more'];
            $h_img='';
            for ($i=0;$i<sizeof($img);$i++){
                $h_img.=$img[$i].",";
            }
            $data['goods_img_more']=trim($h_img,',');
            $addNew =  $shopModel->addProduct($data);
            if($addNew){
                $this->success('添加商品成功','stepTwo');
            }else{
                $this->error('添加商品失败','index');
            }
        }
        $list =$shopModel->getGoods($g_id);
        $list['goods_sort'] =$shopModel->getSortName($list['goods_sort']);
        $list['goods_specs'] =$shopModel->getGoodsSpecs($list['goods_id']);
        $detsils =$shopModel->getGoodsDetails($list['goods_id']);
        $list['goods_details'] =$detsils['gd_details'];
        $list['h_imgs']=rtrim($list['goods_img_more'],',');
        $list['goods_img_more']=explode(',',$list['h_imgs']);
        $this->assign('list',$list);
        return $this->fetch();
    }



    public function updateTwo(){
        $shopModel = new Shops();
        if($_POST){
            $goods_id = intval($_POST['goods_id']);
            $data['goods_name'] = $_POST['goods_name'];
            $data['goods_price'] = $_POST['goods_price'];
            $data['goods_dis_price'] = $_POST['goods_dis_price'];
            $data['goods_img'] = isset($_POST['goods_img'])?$_POST['goods_img']:'';
            $data['goods_admin'] = session('adminId');
            $data['goods_details'] = $_POST['goods_details'];
            //是否多图
            $img = isset($_POST['goods_img_more'])?$_POST['goods_img_more']:array();
            $h_img = '';
            for ($i=0;$i<sizeof($img);$i++){
                $h_img.=$img[$i].",";
            }
            $data['goods_img_more']=trim($h_img,',');
            $addNew =  $shopModel->editGoods($goods_id,$data);
            //查询这个商品是否有商品简介
            //若存在商品简介则是修改  若不存在则是添加商品简介信息
            $isDetails =  $shopModel->isDetails($goods_id);
            if($isDetails){
                $details['gd_details'] = $_POST['goods_details'];
                $details['ad_admin'] = session('adminId');
                $details['gd_addtime'] = time();
                $addDetails = $shopModel->editDetails($goods_id,$details);
            }else{
                $add['gd_details'] = $_POST['goods_details'];
                $add['ad_admin'] = session('adminId');
                $add['gd_goods_id'] = $goods_id;
                $add['gd_addtime'] = time();
                $addDetails =    $shopModel->addDetails($add);
            }
            if($addNew && $addDetails){
                return  json(['code' => '1','data' => $addNew]);
            }else{
                return  json(['code' => '0','data' => ['']]);
            }
        }
    }

    
    /***
     * Name: 二级联动 根据传过来的一级分类id获取改分类下的二级分类
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by DangMengmeng at 2019/9/11 9:47
     */
    public function getSubSort(){
        $shopModel = new Shops();
        $ss_id = $_POST['ss_id'];
        $list =$shopModel->getSort($ss_id);
        if($list){
            return  json(['code' => '1','data' => $list]);
        }else{
            return  json(['code' => '0','data' => ['']]);
        }
    }


    /***
     * Name: 添加商品规格
     * @return mixed|\think\response\Json
     * Created by DangMengmeng at 2019/9/11 15:34
     */
    public function addSpec(){
        $g_id = intval($_GET['g_id']);
        $shopModel = new Shops();
        if($_POST){
            $data['gs_goods_id'] = $_POST['gs_goods_id'];
            $data['gs_title'] = $_POST['gs_title'];
            $data['gs_price'] = $_POST['gs_price'];
            $data['gs_stock'] = $_POST['gs_stock'];
            $data['gs_discont'] = $_POST['gs_discont'];
            $data['gs_addtime'] = time();
            $data['gs_update_time'] = time();
            $data['gs_admin'] = session('adminId');
            $data['gs_img'] = isset($_POST['gs_img'])?$_POST['gs_img']:'';
            $addSpec = $shopModel->addSpecs($data);
            if($addSpec){
                return  json(['code' => '1','data' => $addSpec]);
            }else{
                return  json(['code' => '0','data' => ['']]);
            }
        }
        $this->assign('g_id',$g_id);
        return $this->fetch();
    }



    public function delSpec(){
        $gs_id = intval($_GET['gs_id']);
        $shopModel = new Shops();
        $del = $shopModel->deSpec($gs_id);
        if($del){
            return  json(['code' => '1','data' => $del]);
        }else{
            return  json(['code' => '0','data' => ['']]);
        }
    }

    /***
     * Name: 修改规格方法
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by DangMengmeng at 2019/9/12 18:08
     */
    public function editSpec(){
        $shopModel = new Shops();
        $gs_id = intval($_GET['gs_id']);
            $specs = $shopModel->findSpecs($gs_id);
            $this->assign('list',$specs);
            return $this->fetch();

    }


    public function eidtSpecss(){
        if($_POST){
            $shopModel = new Shops();
            $gs_id = intval($_GET['gs_id']);
            $data = $_POST;
            $edit = $shopModel->editSpec($gs_id,$data);
            if($edit){
                return  json(['code' => '1','data' => $edit]);
            }else{
                return  json(['code' => '0','data' => ['']]);
            }
        }
    }


    /****
     * Name: 删除商品方法
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * Created by DangMengmeng at 2019/9/11 16:29
     */
    public function delProduct(){
        $g_id = intval($_GET['g_id']);
        $shopModel = new Shops();
        //真删除
        $del = $shopModel->delGoods($g_id);
        //假删除
        //$data['goods_del_flg']  = 3;
        //$del = $shopModel->editGoods($g_id,$data);
        if($del){
            return  json(['code' => '1','data' => $del,'msg' => '删除成功！']);
        }else{
            return  json(['code' => '0','data' => [''],'msg' => '删除失败！']);
        }
    }


    /***
     * Name: 上架商品
     * @return \think\response\Json
     * Created by DangMengmeng at 2019/9/11 16:41
     */
    public function onLine(){
        $g_id = intval($_GET['g_id']);
        $shopModel = new Shops();
        $data['goods_del_flg']  = 1;
        $Online = $shopModel->editGoods($g_id,$data);
        if($Online){
            return  json(['code' => '1','data' => $Online,'msg' => '上架成功！']);
        }else{
            return  json(['code' => '0','data' => [''],'msg' => '上架成功！']);
        }
    }

    /***
     * Name: 下架商品方法
     * @return \think\response\Json
     * Created by DangMengmeng at 2019/9/11 16:41
     */
    public function offLine(){
        $g_id = intval($_GET['g_id']);
        $shopModel = new Shops();
        $data['goods_del_flg']  = 2;
        $Online = $shopModel->editGoods($g_id,$data);
        if($Online){
            return  json(['code' => '1','data' => $Online,'msg' => '上架成功！']);
        }else{
            return  json(['code' => '0','data' => [''],'msg' => '上架成功！']);
        }
    }
}