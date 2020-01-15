<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class Shops extends Model
{


    /***
     * Name: 读取商品分类方法
     * @param $f_id
     * @return false|\PDOStatement|string|\think\Collection|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by DangMengmeng at 2019/9/9 11:14
     */
    public function getSortList($f_id){
        $list = Db::table('super_goods_sorts')
            ->where('ss_f_id = '.$f_id)
            ->select();
        if($list){
            foreach ($list as $key => $val){
                if($val['ss_f_id'] == 0){
                    $list[$key]['subSort'] = $this->getSubSort($val['ss_id']);
                }
            }
        }
        return $list ? $list : null;
    }


    /***
     * Name: 添加新的商品分类方法
     * @param $data
     * @return bool|int|string
     * Created by DangMengmeng at 2019/9/9 13:50
     */
    public function addNewSort($data){
        $add=Db::table('super_goods_sorts')->insert($data);
        return $add ? $add : false;
    }


    /***
     * Name: 获取子分类方法
     * @param $f_id  int 父级分类
     * @return false|\PDOStatement|string|\think\Collection|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by DangMengmeng at 2019/9/9 13:48
     */
    public function getSubSort($f_id){
        $list = Db::table('super_goods_sorts')
            ->where('ss_f_id = '.$f_id)
            ->select();
        return $list ? $list : null;
    }


    /***
     * Name: 商品分类方法
     * @param $nav_id  int 商品ID
     * @param $data array 需要修改的信息
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * Created by DangMengmeng at 2019/9/9 14:19
     */
    public function editSort($nav_id,$data){
        $edit = Db::table('super_goods_sorts')
            ->where(['ss_id' => $nav_id])
            ->update($data);
        return $edit ? true : false;
    }



    public function editGoods($nav_id,$data){
        $edit = Db::table('super_goods')
            ->where(['goods_id' => $nav_id])
            ->update($data);
        return $edit ? true : false;
    }


    public function isDetails($g_id){
        $edit = Db::table('super_goods_details')
            ->where(['gd_goods_id' => $g_id])
            ->find();
        return    $edit ? true : false;
    }

    public function editDetails($g_id,$data){
        $edit = Db::table('super_goods_details')
            ->where(['gd_goods_id' => $g_id])
            ->update($data);
        return $edit ? true : false;
    }


    public function  addDetails($data){
        $edit = Db::table('super_goods_details')
            ->insert($data);
        return $edit ? true : false;
    }

    /***
     * Name: 查询一条商品分类方法
     * @param $nav_id   int 分类ID
     * @return array|false|\PDOStatement|string|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by DangMengmeng at 2019/9/9 14:22
     */
    public function findOne($nav_id){
        $sort = Db::table('super_goods_sorts')
            ->where(['ss_id' => $nav_id])
            ->find();
        return $sort ? $sort : null;
    }


    /***
     * Name: 添加商品主表方法
     * @param $data
     * @return int|string
     * Created by DangMengmeng at 2019/9/10 10:59
     */
    public function addProduct($data){
        $addPro = Db::table('super_goods')->insert($data);
        $userId = Db::table('super_goods')->getLastInsID();
        return $addPro ? $userId : 0;
    }


    /***
     * Name: 获取商品分类方法
     * @param $ss_id
     * @return false|\PDOStatement|string|\think\Collection|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by DangMengmeng at 2019/9/10 17:39
     */
    public function getSort($ss_id){
        $list = Db::table('super_goods_sorts')
            ->where(['ss_f_id' => $ss_id])
            ->order('ss_order desc')
            ->select();
        return $list ? $list : null;
    }
    
    /***
     * Name: 统计商品个数
     * @param $where
     * @return int|string
     * Created by DangMengmeng at 2019/9/12 15:00
     */
    public function countGoods($where){
        $count = Db::table('super_goods')
            ->where($where)
            ->count('goods_id');
        return $count;
    }

    /***
     * Name: 获取商品列表方法
     * @param $page
     * @param $limit
     * @param $where
     * @return false|\PDOStatement|string|\think\Collection|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by DangMengmeng at 2019/9/12 15:00
     */
    public function getGoodsList($page,$limit,$where){
        $list = Db::table('super_goods')
            ->where($where)
            ->order('goods_top_flg asc,goods_change_date desc')
            ->limit(($page-1)*$limit,$limit)
            ->select();
        if($list){
            foreach($list as $key => $val){
                $list[$key]['goods_sort'] = $this->getSortName($val['goods_sort']);
                $list[$key]['goods_admin'] = $this->getAdmin($val['goods_admin']);
                $list[$key]['goods_del_flgs'] = $this->getGoodsStatus($val['goods_del_flg']);
            }
        }
        return $list ? $list : null;
    }


    /***
     * Name: 获取管理员名称方法
     * @param $admin
     * @return mixed|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by DangMengmeng at 2019/9/10 17:39
     */
    public function getAdmin($admin){
        $adminName = Db::table('super_admin')->where(['ad_id' => $admin])->find();
        return    $adminName ? $adminName['ad_realname']  :  '一位来历不明的管理员';
    }


    /****
     * Name: 获取商品分类名称方法
     * @param $sort
     * @return mixed|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by DangMengmeng at 2019/9/10 17:40
     */
    public function getSortName($sort){
        $sortName = Db::table('super_goods_sorts')->where(['ss_id' => $sort])->find();
        if($sortName['ss_f_id'] != 0 ){
            $sortSubName = Db::table('super_goods_sorts')->where(['ss_id' => $sortName['ss_f_id']])->find();
        }else{
            $sortSubName = '默认一级分类';
        }
        $sortSubName = $sortSubName ? '默认' : '默认分类';
        return    $sortName ? $sortSubName.'-'.$sortName['ss_title']  :  '默认分类';
    }


    /***
     * Name: 获取商品的规格方法
     * @param $g_id  int 商品ID
     * @return false|\PDOStatement|string|\think\Collection|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by DangMengmeng at 2019/9/11 15:29
     */
    public function getGoodsSpecs($g_id){
        $goodsSpec = Db::table('super_goods_spec')
            ->where(['gs_goods_id' => $g_id])
            ->order('gs_id desc')
            ->select();
        if($goodsSpec){
            foreach($goodsSpec as $key => $val){
                $goodsSpec[$key]['gs_addtime'] = date('Y-m-d H:i:s',$val['gs_addtime']);
                $goodsSpec[$key]['gs_status'] = $val['gs_status'] == 1 ? '正常' : '隐藏' ;
            }
        }
        return  $goodsSpec ? $goodsSpec : null;
    }


    public function getGoodsDetails($g_id){
        $goodsSpec = Db::table('super_goods_details')
            ->where(['gd_goods_id' => $g_id])
            ->find();
        return  $goodsSpec ? $goodsSpec : null;
    }


    /***
     * Name: 获取商品状态方法
     * @param $status
     * @return string
     * Created by DangMengmeng at 2019/9/10 17:40
     */
    public function getGoodsStatus($status){
        //商品状态：1.待上架；2，已下架，3删除
        switch($status){
            case  1;
                $typeName = '上架中';
                break;
            case 2;
                $typeName = '待上架';
                break;
            case  3;
                $typeName = '删除';
                break;
        }
        return $typeName;
    }


    /***
     * Name: 获取商品基础信息
     * @param $g_id
     * @return array|false|\PDOStatement|string|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by DangMengmeng at 2019/9/11 10:36
     */
    public function getGoods($g_id){
         $goods = Db::table('super_goods')
             ->where(['goods_id' => $g_id])
             ->field('goods_id,goods_name,goods_sort,goods_price,goods_dis_price,goods_img,goods_img_more')
             ->find();
         return   $goods ? $goods : null;
    }




    public function addSpecs($data){
        $addPro = Db::table('super_goods_spec')->insert($data);
        $userId = Db::table('super_goods_spec')->getLastInsID();
        return $addPro ? $userId : 0;
    }


    /****
     * Name: 删除商品规格
     * @param $gs_id
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * Created by DangMengmeng at 2019/9/11 16:26
     */
    public function deSpec($gs_id){
        $delSpec = Db::table('super_goods_spec')->where(['gs_id' =>$gs_id])->delete();
        return $delSpec ? true : false;
    }


    /***
     * Name: 查找一个商品分类
     * @param $gs_id
     * @return array|false|\PDOStatement|string|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Created by DangMengmeng at 2019/9/11 17:16
     */
    public function findSpecs($gs_id){
        $Spec = Db::table('super_goods_spec')->where(['gs_id' =>$gs_id])->find();
        return $Spec ? $Spec : null;
    }


    public function editSpec($gs_id,$data){
        $Spec = Db::table('super_goods_spec')->where(['gs_id' =>$gs_id])->update($data);
        return $Spec ? $Spec : null;
    }



    /***
     * Name: 删除商品 1.删除商品规格；2.删除商品
     * @param $g_id   int 商品ID
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * Created by DangMengmeng at 2019/9/11 16:26
     */
    public function delGoods($g_id){
        Db::table('super_goods_spec')->where(['gs_goods_id' =>$g_id])->delete();
        $del = Db::table('super_goods')->where(['goods_id' =>$g_id])->delete();
        return $del ? true : false;
    }
}