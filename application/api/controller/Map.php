<?php


namespace app\api\controller;


use app\xcx\model\Housem;
use think\Controller;
use think\Db;
use think\Log;

class Map extends Controller
{

    /**
     *计算某个经纬度的周围某段距离的正方形的四个点
     * @param lng float 经度
     * @param lat float 纬度
     * @param distance float 该点所在圆的半径，该圆与此正方形内切，默认值为0.5千米
     * @return array 正方形的四个点的经纬度坐标
     */

    public function getFourPoint($southwest,$northeast){
        $sounth = explode(',',$southwest);
        $north = explode(',',$northeast);
        $point['right_bottom_lat'] = $north[0];   //右下纬度
        $point['left_top_lat'] = $sounth[0];           //左上纬度
        $point['left_top_lng'] = $north[1];           //左上经度
        $point['right_bottom_lng'] = $sounth[1];   //右下经度
        return $point;
    }

    public function getMap()
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $southwest = trim($this->request->param('southwest','-37.89130,144.90010'));
        $northeast = trim($this->request->param('northeast','-37.72855,145.02884'));
        $sounth = explode(',',$southwest);
        $north = explode(',',$northeast);
        if(!$north[0] || !$north[1] || !$sounth[0] || !$sounth[1]){
            $res['code'] = 0;
            $res['msg'] = '缺少参数！';
        }
        $uid = trim($this->request->param('uid'));
        $city = trim($this->request->param('city', '墨尔本'));
        $where = "status = 1 and is_del = 1 and city = '" . $city . "'";
        $keys = trim($this->request->param('keys'));
        if (isset($keys) && !empty($keys) && $keys) {
            $where .= " and ( title like '%" . $keys . "%' or dsn like '%" . $keys . "%'  or school like '%" . $keys . "%' or city like '%" . $keys . "%' or area like '%" . $keys . "%')";
            //写入一条关键词查询记录
            if ($uid) {
                $this->addQueryLog($uid, $keys, 1);
            }
        }else{
            $right_bottom_lat = $north[0];   //右下纬度
            $left_top_lat = $sounth[0];           //左上纬度
            $left_top_lng = $north[1];           //左上经度
            $right_bottom_lng = $sounth[1];   //右下经度
            $where .= ' and x > ' . $left_top_lat . ' and  x < ' .$right_bottom_lat  . ' and y > ' .  $right_bottom_lng. ' and y < ' .$left_top_lng ;
        }
        //房屋类型
        $house_type = trim($this->request->param('house_type'));
        if (isset($house_type) && !empty($house_type) && $house_type) {
            $where .= " and house_type = '" . $house_type . "'";
        }
        //租期发布多选，帅选单选
        $term = $this->request->param('lease_term');
        Log::write('获取房源参数lease_term：' . $term, 'info');
        if (isset($term) && !empty($term) && $term) {
            $where .= " and find_in_set('" . $term . "',lease_term)";
        }
        //所有有房源的区
        //租房价格最大值 最小值
        //租房价格最大值 最小值
        $maxprice = trim($this->request->param('maxprice', '9999'));
        Log::write('租房价格最大值：' . $maxprice, 'info');
        $mimprice = trim($this->request->param('minprice', '0'));
        Log::write('租房价格最小值：' . $mimprice, 'info');
        $maxprice = $maxprice ? $maxprice : '9999';
        $mimprice = $mimprice ? $mimprice : '0';
        if (isset($maxprice) && !empty($maxprice) && $maxprice) {
            $where .= " and ( price <= " . $maxprice . " ";
        }
        if (isset($mimprice)) {
            $where .= " and price >= " . $mimprice . "  or price = -1 )";
        }
        $livedate = trim($this->request->param('livedate'));
        $liveDate = $this->getLiveDate($livedate);
        $mintime = $liveDate['min'];
        $maxtime = $liveDate['max'];
        if ((isset($mintime) && !empty($mintime) && $mintime) && !$maxtime) {
            $where .= " and (live_date >= '" . $mintime . "' or ( live_date = '0100-01-01' or live_date = '0000-00-00' ))";
        }

        if ((isset($maxtime) && !empty($maxtime) && $maxtime) && !$mintime) {
            Log::write('入住时间最大值：' . $maxtime, 'info');
            $where .= " and (live_date  <= '" . $maxtime . "' or ( live_date = '0100-01-01' or live_date = '0000-00-00' ))";
        }
        if ($mintime && $maxtime) {
            Log::write('入住时间最小值：' . $mintime . '入住时间最大值' . $maxtime, 'info');
            $where .= " and ((live_date >= '" . $mintime . "' and live_date  <= '" . $maxtime . "')  or ( live_date = '0100-01-01' or live_date = '0000-00-00' ))";
        }
        //户型  卧室 1 2 3 4 5 5+
        //李电话沟通换成12344+ 2020年9月1日16:42:51
        $house_room = $this->request->param('house_room');
        Log::write('卧室house_room：' . $house_room, 'info');
        if (isset($house_room) && !empty($house_room) && $house_room) {
            if ($house_room == '4+') {
                $where .= " and house_room > 4";
            } else {
                $where .= " and house_room = '" . $house_room . "'";
            }
        }
        //是否有视频vid  1 有视频 2  无视频
        $vid = trim($this->request->param('vid'));
        if (isset($vid) && !empty($vid) && $vid) {
            if ($vid == 1) {
                $where .= " and video != '' ";
            } else {
                $where .= " and video = '' ";
            }
        }
        //出租方式
        $type = trim($this->request->param('type'));
        if (isset($type) && !empty($type) && $type) {
            $where .= " and type = '" . $type . "'";
        }
        //宠物
        $pet = trim($this->request->param('pet'));
        if (isset($pet) && !empty($pet) && $pet) {
            $where .= " and ( pet = '接受' or pet = '不限' ) ";
        }
        //吸烟
        $smoke = trim($this->request->param('smoke'));
        if (isset($smoke) && !empty($smoke) && $smoke) {
            $where .= " and ( smoke = '可以' or smoke = '不限' ) ";
        }
        //接受情侣
        $is_couple = trim($this->request->param('is_couple'));
        if (isset($is_couple) && !empty($is_couple) && $is_couple) {
            $where .= " and  is_couple = '接受' ";
        }
        //卫生间
        $toilet = $this->request->param('toilet');
        if (isset($toilet) && !empty($toilet) && $toilet) {
            if ($toilet == '3+') {
                $where .= " and toilet > 3";
            } else {
                $where .= " and toilet = " . $toilet;
            }
        }
        //车位 1 2 3 3+
        $car = $this->request->param('car');
        Log::write('车位car：' . $car, 'info');
        if (isset($car) && !empty($car) && $car) {
            if ($car == '3+') {
                $where .= " and car > 3";
            } else {
                $where .= " and car = " . $car;
            }
        }
        //房源特色
        $tags = trim($this->request->param('tags'));
        if (isset($tags) && !empty($tags) && $tags) {
            $where .= " and (";
            $tgs = explode(',', $tags);
            for ($i = 0; $i < count($tgs); $i++) {
                if ($i == (count($tgs) - 1)) {
                    $where .= " find_in_set('" . $tgs[$i] . "',tags)";
                } else {
                    $where .= " find_in_set('" . $tgs[$i] . "',tags) and ";
                }
            }
            $where .= " ) ";
        }
        //楼宇设施
        $home = trim($this->request->param('home'));
        if (isset($home) && !empty($home) && $home) {
            $where .= " and (";
            $homes = explode(',', $home);
            for ($i = 0; $i < count($homes); $i++) {
                if ($homes[$i] == '门禁系统') {
                    $homes[$i] = '门禁';
                }
                Log::write('用户查询furniture：' . $homes[$i], 'info');
                if ($i == (count($homes) - 1)) {
                    $where .= " find_in_set('" . $homes[$i] . "',furniture)";
                } else {
                    $where .= " find_in_set('" . $homes[$i] . "',furniture) and ";
                }
            }
            $where .= " ) ";
        }
        //宠物
        $limit = trim($this->request->param('limit', '76'));
        $page = trim($this->request->param('page', '0'));
        Log::write('前端用户：' . $uid . '进行了翻页，当前页码' . $page, 'info');
        $order = 'top desc,cdate desc';
        $field = ' count(`x`) as count,id,type,x,y,thumnail,images';
        $housem = new Housem();
        $houses = $housem->readDatas($where, $order, $limit, $page, $field);
        $houseCount = $housem->houscount($where);
        if ($houses) {
            //是否收藏
            $collects = $this->getCollects($uid);
            $nowCount = 0;
            foreach ($houses as $k => $v){
                $colt = in_array($v['id'],$collects,true);
                $houses[$k]['is_colt'] = $colt ? 1 : 0;
                $nowCount += $v['count'];
                $count = $v['count'] >9 ? 10 : $v['count'];
                $houses[$k]['mark_url'] = 'https://oa.huaxiangxiaobao.com/xcx/new/'.$count.'.png';
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功！';
            $res['totalcount'] = $houseCount;
            $res['nowcount'] = $nowCount;
            $res['data'] = $houses;
            $res['where'] = $where;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['totalcount'] = 0;
        $res['nowcount'] = 0;
        $res['data'] = $houses;
        $res['where'] = $where;
        return json($res);
    }


    public function getHouseByLocation(){
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        $uid = trim($this->request->param('uid','59'));
        $lat = trim($this->request->param('x', '-37.786769'));
        $lng = trim($this->request->param('y', '144.951699'));
        if(!$lat || !$uid || ! $lng){
            $res['code'] = 0;
            $res['msg'] = '缺少参数';
            return json($res);
        }
        $city = trim($this->request->param('city', '墨尔本'));
        $where = "status = 1 and is_del = 1 and city = '" . $city . "'";
        $keys = trim($this->request->param('keys'));
        if (isset($keys) && !empty($keys) && $keys) {
            $where .= " and ( title like '%" . $keys . "%' or dsn like '%" . $keys . "%'  or school like '%" . $keys . "%' or city like '%" . $keys . "%' or area like '%" . $keys . "%')";
            //写入一条关键词查询记录
            if ($uid) {
                $this->addQueryLog($uid, $keys, 1);
            }
        }
        //房屋类型
        $house_type = trim($this->request->param('house_type'));
        if (isset($house_type) && !empty($house_type) && $house_type) {
            $where .= " and house_type = '" . $house_type . "'";
        }
        //租期发布多选，帅选单选
        $term = $this->request->param('lease_term');
        Log::write('获取房源参数lease_term：' . $term, 'info');
        if (isset($term) && !empty($term) && $term) {
            $where .= " and find_in_set('" . $term . "',lease_term)";
        }
        //所有有房源的区
        //租房价格最大值 最小值
        //租房价格最大值 最小值
        $maxprice = trim($this->request->param('maxprice', '9999'));
        Log::write('租房价格最大值：' . $maxprice, 'info');
        $mimprice = trim($this->request->param('minprice', '0'));
        Log::write('租房价格最小值：' . $mimprice, 'info');
        $maxprice = $maxprice ? $maxprice : '9999';
        $mimprice = $mimprice ? $mimprice : '0';
        if (isset($maxprice) && !empty($maxprice) && $maxprice) {
            $where .= " and ( price <= " . $maxprice . " ";
        }
        if (isset($mimprice)) {
            $where .= " and price >= " . $mimprice . "  or price = -1 )";
        }
        $livedate = trim($this->request->param('livedate'));
        $liveDate = $this->getLiveDate($livedate);
        $mintime = $liveDate['min'];
        $maxtime = $liveDate['max'];
        if ((isset($mintime) && !empty($mintime) && $mintime) && !$maxtime) {
            $where .= " and (live_date >= '" . $mintime . "' or ( live_date = '0100-01-01' or live_date = '0000-00-00' ))";
        }

        if ((isset($maxtime) && !empty($maxtime) && $maxtime) && !$mintime) {
            Log::write('入住时间最大值：' . $maxtime, 'info');
            $where .= " and (live_date  <= '" . $maxtime . "' or ( live_date = '0100-01-01' or live_date = '0000-00-00' ))";
        }
        if ($mintime && $maxtime) {
            Log::write('入住时间最小值：' . $mintime . '入住时间最大值' . $maxtime, 'info');
            $where .= " and ((live_date >= '" . $mintime . "' and live_date  <= '" . $maxtime . "')  or ( live_date = '0100-01-01' or live_date = '0000-00-00' ))";
        }
        //户型  卧室 1 2 3 4 5 5+
        //李电话沟通换成12344+ 2020年9月1日16:42:51
        $house_room = $this->request->param('house_room');
        Log::write('卧室house_room：' . $house_room, 'info');
        if (isset($house_room) && !empty($house_room) && $house_room) {
            if ($house_room == '4+') {
                $where .= " and house_room > 4";
            } else {
                $where .= " and house_room = '" . $house_room . "'";
            }
        }
        //是否有视频vid  1 有视频 2  无视频
        $vid = trim($this->request->param('vid'));
        if (isset($vid) && !empty($vid) && $vid) {
            if ($vid == 1) {
                $where .= " and video != '' ";
            } else {
                $where .= " and video = '' ";
            }
        }
        //出租方式
        $type = trim($this->request->param('type'));
        if (isset($type) && !empty($type) && $type) {
            $where .= " and type = '" . $type . "'";
        }
        //宠物
        $pet = trim($this->request->param('pet'));
        if (isset($pet) && !empty($pet) && $pet) {
            $where .= " and ( pet = '接受' or pet = '不限' ) ";
        }
        //吸烟
        $smoke = trim($this->request->param('smoke'));
        if (isset($smoke) && !empty($smoke) && $smoke) {
            $where .= " and ( smoke = '可以' or smoke = '不限' ) ";
        }
        //接受情侣
        $is_couple = trim($this->request->param('is_couple'));
        if (isset($is_couple) && !empty($is_couple) && $is_couple) {
            $where .= " and  is_couple = '接受' ";
        }
        //卫生间
        $toilet = $this->request->param('toilet');
        if (isset($toilet) && !empty($toilet) && $toilet) {
            if ($toilet == '3+') {
                $where .= " and toilet > 3";
            } else {
                $where .= " and toilet = " . $toilet;
            }
        }
        //车位 1 2 3 3+
        $car = $this->request->param('car');
        Log::write('车位car：' . $car, 'info');
        if (isset($car) && !empty($car) && $car) {
            if ($car == '3+') {
                $where .= " and car > 3";
            } else {
                $where .= " and car = " . $car;
            }
        }
        //房源特色
        $tags = trim($this->request->param('tags'));
        if (isset($tags) && !empty($tags) && $tags) {
            $where .= " and (";
            $tgs = explode(',', $tags);
            for ($i = 0; $i < count($tgs); $i++) {
                if ($i == (count($tgs) - 1)) {
                    $where .= " find_in_set('" . $tgs[$i] . "',tags)";
                } else {
                    $where .= " find_in_set('" . $tgs[$i] . "',tags) and ";
                }
            }
            $where .= " ) ";
        }
        //楼宇设施
        $home = trim($this->request->param('home'));
        if (isset($home) && !empty($home) && $home) {
            $where .= " and (";
            $homes = explode(',', $home);
            for ($i = 0; $i < count($homes); $i++) {
                if ($homes[$i] == '门禁系统') {
                    $homes[$i] = '门禁';
                }
                Log::write('用户查询furniture：' . $homes[$i], 'info');
                if ($i == (count($homes) - 1)) {
                    $where .= " find_in_set('" . $homes[$i] . "',furniture)";
                } else {
                    $where .= " find_in_set('" . $homes[$i] . "',furniture) and ";
                }
            }
            $where .= " ) ";
        }
        //宠物
        $limit = trim($this->request->param('limit', '76'));
        $page = trim($this->request->param('page', '0'));
        Log::write('前端用户：' . $uid . '进行了翻页，当前页码' . $page, 'info');
        $field = 'id,type,title,house_room,area,images,price,toilet,thumnail,x,y,house_type,address,car';
        $where .= ' and x = '.$lat.' and y = '.$lng.' ';
        $order = "id";
        $page = 0;
        $housem = new Housem();
        $houses = $housem->readDatasss($where, $order, $limit, $page, $field);
        if ($houses) {
            //是否收藏
            $collects = $this->getCollects($uid);
            foreach ($houses as $k => $v){
                $colt = in_array($v['id'],$collects,true);
                $houses[$k]['is_colt'] = $colt ? 1 : 0;
                unset($houses[$k]['images']);
            }
            $res['code'] = 1;
            $res['msg'] = '读取成功1！';
            $res['where'] = $where;
            $res['data'] = $houses;
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '数据为空！';
        $res['data'] = $houses;
        $res['where'] = $where;
        return json($res);
    }

    public function getCollects($uid){
        $collects = Db::table('xcx_collect')
            ->where(['cl_user_id' => $uid,'cl_type' => 1])
            ->field('cl_house_id')
            ->select();
        $collect =  array_column($collects,'cl_house_id');
        return $collect;
    }

    public function getLiveDate($date)
    {
        $now = date('Y-m-d');
        if ($date) {
            $time['min'] = date('Y-m-d', strtotime($now . ' -' . $date . ' days'));
            $time['max'] = date('Y-m-d', strtotime($now . ' +' . $date . ' days'));
        } else {
            $time['min'] = '';
            $time['max'] = '';
        }
        return $time;
    }


    public function addQueryLog($uid,$key,$type){
        $data['sk_keywords'] = $key;
        $data['sk_userid'] = $uid;
        $data['sk_type'] = $type;
        $data['sk_addtime'] = date('Y-m-d H:i:s');
        $resault = Db::table('xcx_search_keywords')->insertGetId($data);
        //更新上次登录时间
        Db::table('tk_user')->where(['id' => $uid])->update(['mdate' =>date('Y-m-d H:i:s')]);
        return $resault;
    }

}