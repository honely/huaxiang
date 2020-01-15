<?php
namespace app\home\controller;

use think\Controller;
use think\Db;

class Article extends Controller
{


    /**
     * 首页文章咨询
     */
    public function getIndex(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $type = $this->request->param('type','1','intval');
        $article = Db::table('wechat_article')
            ->where(['art_status' => 1])
            ->where(['art_type' => $type])
            ->limit(6)
            ->order('art_addtime desc')
            ->field('art_id,art_title,art_img,art_url,art_preview,art_type,art_addtime')
            ->select();
        if($article){
            foreach ($article as $k => $v){
                $article[$k]['art_addtime'] = date('Y-m-d',$v['art_addtime']);
            }
            return json(['code' => 1,'msg'=>'读取成功','data' => $article]);
        }else{
            return json(['code' => 0,'msg'=>'读取失败','data' => null]);
        }

    }



    /**
     * 首页文章咨询
     */
    public function getArticles(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $type = $this->request->param('type','1','intval');
        $page = $this->request->param('page','1','intval');
        $keywords = $this->request->param('keywords');
        $where ="art_title like '%".$keywords."%'";
        $limit = 20;
        $count = Db::table('wechat_article')
            ->where(['art_status' => 1])
            ->where(['art_type' => $type])
            ->where($where)
            ->count();
        $article = Db::table('wechat_article')
            ->where(['art_status' => 1])
            ->where(['art_type' => $type])
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('art_addtime desc')
            ->field('art_id,art_title,art_img,art_url,art_preview,art_type,art_addtime')
            ->select();
        if($article){
            foreach ($article as $k => $v){
                $article[$k]['art_addtime'] = date('Y-m-d',$v['art_addtime']);
            }
            return json(['code' => 1,'msg'=>'读取成功','count' => $count,'data' => $article]);
        }else{
            return json(['code' => 0,'msg'=>'读取失败','data' => null]);
        }

    }


    public function artDetails(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $art_id = $this->request->param('art_id','1','intval');
        $article = Db::table('wechat_article')
            ->where(['art_status' => 1,'art_id' =>$art_id])
            ->find();
        $ids = $this->getRand();
        $articles = Db::table('wechat_article')
            ->where(['art_status' => 1])
            ->where('art_id != '.$art_id)
            ->where('art_id','in',$ids)
            ->limit(4)
            ->field('art_id,art_title,art_img,art_show,art_editime,art_url')
            ->select();
        if($articles){
            foreach($articles as $k => $v){
                $articles[$k]['art_editime'] = date('Y-m-d',$v['art_editime']);
            }
        }
        if($article){
            Db::table('wechat_article')
                ->where(['art_status' => 1,'art_id' =>$art_id])
                ->setInc('art_view');
            $article['art_addtime'] = date('Y-m-d',$article['art_editime']);
            return json(['code' => 1,'msg'=>'读取成功','data' => $article,'articles' => $articles]);
        }else{
            return json(['code' => 0,'msg'=>'读取失败','data' => null]);
        }
    }


    public function getRand(){
        $num = 5;//需要抽取的默认条数
        $countcus = db('wechat_article')->count();//获取总记录数
        $min = db('wechat_article')->min('art_id');//统计某个字段最小数据
        $max = db('wechat_article')->max('art_id');//统计某个字段最大数据
        if($countcus<$num){
            $num = $countcus;
        }
        $i = 1;
        $flag = 0;
        $ary = array();
        while($i<=$num){
            $rundnum = rand($min,$max);//抽取随机数
            if($flag != $rundnum){
                //过滤重复
                if(!in_array($rundnum,$ary)){
                    $ary[] = $rundnum;
                    $flag = $rundnum;
                }else{
                    $i--;
                }
                $i++;
            }
        }
       return  $ary;
    }
}