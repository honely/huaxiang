<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

class Cate extends Controller
{
    /***
     *Names:读取城市和校区的方法
     * 注意：读取城市不需要传任何值
     * 读取校区，需要传递城市的id
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *Created by Dang Mengmeng at 2019/11/20 11:44
     */
    public function getCity(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $cId = $this->request->param('cid',0,'intval');
        $where = $cId == 0 ? 'pid = 0' : "pid = ".$cId." and type = 2";
        $result = Db::table('tk_cate')
            ->where($where)
            ->field('id,name,pid,oseq')
            ->order('oseq asc')
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

    public function getTags(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $type = $this->request->param('type',1,'intval');
        $tags = Db::table('xcx_tags')
            ->where(['type' => $type])
            ->field('id,name')
            ->order('torder asc,id desc')
            ->select();
        if($tags){
            $res['code'] =1;
            $res['msg'] ='读取成功！';
            $res['data'] =$tags;
            return json($res);
        }else{
            $res['code'] =1;
            $res['msg'] ='数据为空';
            return json($res);
        }
    }

    public function getlines(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $city = $this->request->param('city','墨尔本');
        $lines = Db::table('tk_stop')
            ->where(['city' => $city])
            ->group('line')
            ->field('id,line')
            ->select();
        if($lines){
            foreach($lines as $k => $v){
                $lines[$k]['child'] = $this->getStop($v['line']);
            }
            $res['code'] =1;
            $res['msg'] ='读取成功！';
            $res['data'] =$lines;
            return json($res);
        }else{
            $res['code'] =1;
            $res['msg'] ='数据为空';
            return json($res);
        }
    }


    public function getStop($line){
        $lines = Db::table('tk_stop')
            ->where(['line' => $line])
            ->field('stop,area')
            ->order('sorder asc')
            ->select();
        $arr = $lines;
        $last_arr = [];
        foreach ($arr as $key => $val) {
            $key = array_key_exists($val['stop'], $last_arr);
            if($key) {
                $last_arr[$val['stop']]['area'] .= ",".$val['area'];
            } else {
                $last_arr[$val['stop']] = $val;
                $last_arr[$val['stop']]['area'] .= ",".$val['area'];
            }
        }
        $aschol = array_values($last_arr);
        return $aschol;
    }

    public function getSchool(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $city = $this->request->param('city','墨尔本');
        $lines = Db::table('tk_school')
            ->where(['city' => $city])
            ->group('school')
            ->field('id,school')
            ->select();
        if($lines){
            foreach($lines as $k => $v){
                $lines[$k]['child'] = $this->getsarea($v['school']);
            }
            $res['code'] =1;
            $res['msg'] ='读取成功！';
            $res['data'] =$lines;
            return json($res);
        }else{
            $res['code'] =1;
            $res['msg'] ='数据为空';
            return json($res);
        }
    }


    public function getsarea($line){
        $lines = Db::table('tk_school')
            ->where(['school' => $line])
            ->field('compus,area')
            ->select();
        $arr = $lines;
        $last_arr = [];
        foreach ($arr as $key => $val) {
            $key = array_key_exists($val['compus'], $last_arr);
            if($key) {
                $last_arr[$val['compus']]['area'] .= ",".$val['area'];
            } else {
                $last_arr[$val['compus']] = $val;
                $last_arr[$val['compus']]['area'] .= ",".$val['area'];
            }
        }
        $aschol = array_values($last_arr);
        return $aschol;
    }


    /***
     * 搜索联想
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getass(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $city = $this->request->param('city','墨尔本');
        $keys = trim($this->request->param('keys'));
        if(!$keys || strlen($keys) < 3){
            $res['code'] =0;
            $res['msg'] ='请输入至少3个字符以上进行查找！';
            return json($res);
        }
        //车站 学校 区域
        $stops = Db::table('tk_stop')
            ->where(['city' => $city])
            ->where("stop like '%".$keys."%'")
            ->field('stop,area')
            ->group('stop')
            ->select();
        foreach ($stops as $k => $items){
            $stops[$k]['count'] = $this->houseCount($city,"area = '".$items['area']."'");
        }
        $data['stops'] = $stops;
        $school = Db::table('tk_school')
            ->where(['city' => $city])
            ->where("sac like '%".$keys."%'")
            ->field('sac,area,compus')
            ->group('area')
            ->select();
        foreach ($school as $k => $v){
            $school[$k]['count'] = $this->houseCount($city,"area = '".$v['area']."'");
        }
        $arr = $school;
        $last_arr = [];
        foreach ($arr as $key => $val) {
            $key = array_key_exists($val['sac'], $last_arr);
            if($key) {
                $last_arr[$val['sac']]['count'] += $val['count'];
                $last_arr[$val['sac']]['area'] .= ",".$val['area'];
            } else {
                $arr[$key]['count'] = $val['count'];
                $last_arr[$val['sac']] = $val;
                $last_arr[$val['sac']]['area'] .= ",".$val['area'];
            }
        }
        $aschol = array_values($last_arr);
        foreach ($aschol as $k => $v){
            $aschol[$k]['area'] = rtrim($v['area'],',');
        }
        $data['school'] = $aschol;
        $area = Db::table('tk_houses')
            ->where(['city' => $city])
            ->where("area like '%".$keys."%'")
            ->group('area')
            ->field('area')
            ->select();
        foreach ($area as $k => $items){
            $area[$k]['count'] = $this->houseCount($city,"area = '".$items['area']."'");
        }
        $data['area'] = $area;
        if($data){
            $res['code'] =1;
            $res['msg'] ='读取成功！';
            $res['data'] =$data;
            return json($res);
        }else{
            $res['code'] =1;
            $res['msg'] ='数据为空';
            return json($res);
        }
    }

    public function houseCount($city,$where){
        $wheres = "status = 1 and is_del = 1 and city = '".$city."'";
        $count = Db::table('tk_houses')
            ->where($wheres)
            ->where($where)
            ->count('id');
        return $count ? $count : 0;
    }




    //获取附近
    public function getnearby(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $x = $this->request->param('x');
        $y = $this->request->param('y');
        $cate = $this->request->param('cate');
        $at=$x."%2C".$y;
        $url="https://browse.search.hereapi.com/v1/browse?at=".$at."&categories=".$cate."&circle=".$at."%3Br%3D3000&limit=5&apiKey=WgZd-Ykul-3XNV5agUgW2vMohtzAlYEA64GIQvcrfaw";
        $res = json_decode(file_get_contents($url),true);
        return json($res);
    }
}