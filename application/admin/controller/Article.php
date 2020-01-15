<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/4/28
 * Time: 11:11
 * Name: 文章管理
 */
namespace app\admin\controller;
use app\admin\model\Commons;
use think\Controller;
use think\Db;
use think\Request;

class Article extends Controller{

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

    //文章列表
    public function artData(){
        $where = " 1 = 1";
        $keywords=trim($this->request->param('keywords'));
        $art_show=intval(trim($this->request->param('art_show')));
        $art_createtime=trim($this->request->param('art_addtime'));
        $art_type=intval(trim($this->request->param('art_type')));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( art_title like '%".$keywords."%' )";
        }
        if(isset($art_show) && !empty($art_show)){
            $where.=" and art_show = ".$art_show;
        }
        if(isset($art_type) && !empty($art_type)){
            $where.=" and art_type = ".$art_type;
        }
        if(isset($art_createtime) && !empty($art_createtime)){
            $sdate=strtotime(substr($art_createtime,'0','10')." 00:00:00");
            $edate=strtotime(substr($art_createtime,'-10')." 23:59:59");
            $where.=" and ( art_addtime >= ".$sdate." and art_addtime <= ".$edate." ) ";
        }
        $count=Db::table('wechat_article')
            ->where($where)->count();
        $page= $this->request->param('page',1,'intval');
        $limit=$this->request->param('limit',10,'intval');
        $article=Db::table('wechat_article')
            ->limit(($page-1)*$limit,$limit)
            ->where($where)
            ->order('art_top desc,art_order desc')
            ->select();
        $common = new Commons();
        foreach ($article as $k =>$v){
            $article[$k]['art_editime']=date('Y-m-d H:i:s',$v['art_editime']);
            $article[$k]['artShow']=$v['art_show'] == 1 ? '微信' :'站内';
            $article[$k]['artAdmin'] = $common->getInspectors($v['art_admin']);
            $article[$k]['art_type']=Db::table('wechat_art_type')->where(['at_id' => $v['art_type']])->column('at_name');
        }
        $res['code'] = 0;
        $res['data'] = $article;
        $res['count'] = $count;
        return json($res);
    }

    public function article(){
        //操作人管理员
        $article=Db::table('wechat_article')
            ->limit(5)
            ->order('art_top desc,art_order desc')
            ->select();
        return $this->fetch();
    }

    //更改是否显示的状态
    public function status(){
        $ba_id = intval($_GET['art_id']);
        $change = intval($_GET['change']);
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为手机 显示
            if($change){
                $msg = '显示';
                $data['art_isable'] = '1';
                $data['art_admin'] = session('adminId');
            }else{
                $msg = '隐藏';
                $data['art_isable'] = '2';
                $data['art_admin'] = session('adminId');
            }
            $changeStatus = Db::table('wechat_article')->where(['art_id' => $ba_id])->update($data);
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

    //更改是否置顶
    public function top(){
        $ba_id = intval($_GET['art_id']);
        $change = intval(trim($_GET['change']));
        if($ba_id && isset($change)){
            //如果选中状态是true,后台数据将要改为 是
            if($change){
                $msg = '置顶';
                $data['art_top'] = '1';
                $data['art_admin'] = session('adminId');
            }else{
                $msg = '取消置顶';
                $data['art_top'] = '2';
                $data['art_admin'] = session('adminId');
            }
            $changeStatus = Db::table('wechat_article')->where(['art_id' => $ba_id])->update($data);
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



    //发布文章
    public function addArticle(){
        if($_POST){
            $data['art_title']=$_POST['art_title'];
            $data['art_preview']=$_POST['art_preview'];
            $data['art_type']=intval(trim($_POST['art_type']));
            $data['art_img']=$_POST['art_img'];
            $data['art_url']=$_POST['art_url'];
            $data['art_addtime']=time();
            $data['art_editime']=time();
            $data['art_show']=$_POST['art_show'];
            $data['art_content']=$_POST['art_content'];
            $data['seo_title']=$_POST['seo_title'];
            $data['seo_keywords']=$_POST['seo_keywords'];
            $data['seo_desc']=$_POST['seo_desc'];
            $data['art_admin'] = session('adminId');
            $add=Db::table('wechat_article')->insert($data);
            if($add){
                $this->success('发布文章成功！','article');
            }else{
                $this->error('发布文章失败！','article');
            }
        }else{
            $adminId=session('adminId');
            $ad_role=intval(session('ad_role'));
            $provInfo=Db::table('wechat_art_type')->select();
            $this->assign('prov',$provInfo);
            $this->assign('ad_role',$ad_role);
            return $this->fetch();
        }
    }





    //修改文章内容
    public function editArticle(){
        $art_id=intval($_GET['art_id']);
        if($_POST){
            $data['art_title']=$_POST['art_title'];
            $data['art_img']=$_POST['art_img'];
            $data['art_preview']=$_POST['art_preview'];
            $data['art_type']=intval(trim($_POST['art_type']));
            $data['art_show']=$_POST['art_show'];
            $data['art_url']=$_POST['art_url'];
            $data['art_editime']=time();
            $data['art_content']=$_POST['art_content'];
            $data['seo_title']=$_POST['seo_title'];
            $data['seo_keywords']=$_POST['seo_keywords'];
            $data['seo_desc']=$_POST['seo_desc'];
            $data['art_admin'] = session('adminId');
            $edit=Db::table('wechat_article')->where(['art_id'=>$art_id])->update($data);
            if($edit){
                $this->success('修改文章成功','article');
            }else{
                $this->error('修改文章失败','article');
            }
        }else{
            $provInfo=Db::table('wechat_art_type')->select();
            $this->assign('prov',$provInfo);
            $artInfo=Db::table('wechat_article')->where(['art_id'=>$art_id])->find();
            $this->assign('art',$artInfo);
            return $this->fetch();
        }
    }

    //删除某一文章
    public function delArticle(){
        $art_id=intval($_GET['art_id']);
        $delArt=Db::table('wechat_article')->where(['art_id' => $art_id])->delete();
        if($delArt){
            $this->success('删除文章成功','article');
        }else{
            $this->error('删除文章失败','article');
        }
    }



    //刷新某一新闻数据
    public function refresh(){
        $art_id=intval($_GET['art_id']);
        $viewInc=Db::table('wechat_article')->where(['art_id' => $art_id])->update(['art_editime' =>time(),'art_admin' => session('adminId')]);
        if($viewInc){
            $this->success('刷新文章成功','article');
        }else{
            $this->error('刷新文章失败','article');
        }
    }



    public function editUpload(Request $request)
    {
        $file 	= $request->file('file');
        $info 	= $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $name_path =str_replace('\\',"/",$info->getSaveName());
            $result['data']["src"] = "/uploads/layui/".$name_path;
            $url 	= $info->getSaveName();
            //图片上传成功后，组好json格式，返回给前端
            $arr   = array(
                'code' => 0,
                'message'=>'',
                'data' =>array(
                    'src' => "/uploads/".$name_path
                ),
            );
        }
        echo json_encode($arr);
    }


    //文章图片上传
    public function upload(){
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/article');
        if($info){
            $path_filename =  $info->getFilename();
            $path_date=date("Ymd",time());
            $path="/uploads/article/".$path_date."/".$path_filename;
            // 成功上传后 返回上传信息
            return json(array('state'=>1,'path'=>$path,'msg'=> '图片上传成功！'));
        }else{
            // 上传失败返回错误信息
            return json(array('state'=>0,'msg'=>'上传失败,请重新上传！'));
        }
    }

}