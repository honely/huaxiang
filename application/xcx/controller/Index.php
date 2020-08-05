<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/5/7
 * Time: 11:33
 */
namespace app\xcx\controller;
use app\xcx\model\Housem;
use app\xcx\model\Languages;
use app\xcx\model\Loops;
use app\xcx\model\Rolem;
use think\Controller;
use think\Request;
use think\Db;
class Index extends Controller
{
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



    public function header(){
        $menuList=Db::table('super_menu')
            ->where(['m_fid' => '0', 'm_type' => '1'])
            ->order('m_id desc')
            ->select();
        foreach ($menuList as $k =>$v){
            $menuList[$k]['child'] = Db::table('super_menu')->where(['m_fid' => $v['m_id'], 'm_type' => '1'])->select();
        }
        $this->assign('menuList',$menuList);
        return  $this->fetch();
    }
    //尾部渲染
    public function footer(){
        return  $this->fetch();
    }
    public function index(){
        $ad_role=session('ad_role');
        $adminId = session('adminId');
        $userData = Db::table("super_admin")
            ->alias('admin')
            //->join('super_role role',"admin.ad_role=role.r_id")
            ->where(['admin.ad_id' => $adminId])
            ->find();
        if($userData){
            //多权限取交集
            $roleM = new Rolem();
            $power_list = $roleM->getPowerList($userData['ad_role']);
            if($power_list){
                foreach ($power_list as $val){
                    $menu_list = Db::table("super_menu")
                        ->where(['m_id' =>$val])
                        ->order('m_sort desc')
                        ->find();
                    $powerData[] = $menu_list;
                }
            }
        };
        if($powerData){
            $parentData = [];
            foreach ($powerData as $key => $val){
                if($val['m_fid'] == 0 && $val['m_type'] == 1){
                    $parentData[] = $val;
                }
            }
            foreach ($powerData as $key => $val){
                if($val['m_fid'] != 0 && $val['m_type'] == 1){
                    if(!empty($parentData)){
                        foreach ($parentData as $k => $v){
                            if($v !== null){
                                if($v['m_id'] == $val['m_fid']){
                                    $parentData[$k]['child'][] = $val;
                                }
                            }
                        }
                    }
                }
            }
        }
        $adminInfo=Db::table('super_admin')
            ->join('super_role','super_admin.ad_role = super_role.r_id')
            ->where(['ad_id' => $adminId])
            ->find();
        $roleM = new Rolem();
        $power_list = $roleM->getPowerListByAdminId($adminId);
        $onlineable = in_array('284',$power_list,true);
        $this->assign('onlineable',$onlineable);
        $this->assign('admin',$adminInfo);
        $this->assign('menuList',$parentData);
        $siteName=Db::table('super_setinfo')->where(['s_key' => 'webname'])->column('s_value');
        $this->assign('siteName',$siteName[0]);
        $this->assign('ad_role',$ad_role);
        //获取当前未读消息数
        $unread = $this->getUnreadMsg($adminId);
        $unread = $unread > 100 ? '99+' : $unread;
        $this->assign('unread',$unread);
        $lang = new Languages();
        $enLab = $lang->getLanguages();
        $langs = $lang->getLang();
        $this->assign('langs',$langs);
        $this->assign('lable',$enLab);
        return  $this->fetch();
    }

    public function changelang(){
        $lang = $this->request->param('lang');
        $lang = $lang == 'Cn' ? 'En' : 'Cn';
        session('language',$lang);
        return json(['code' => 1,'msg' => 'success']);
    }


    public function unread(){
        $adminid = session('adminId');
             //如果这个后台用户已经绑定小程序用户的话，包含小程序用户的未读消息
        $adWechat = session('ad_wechat');
        $where = "(mp_u_id = ".$adminid." and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = ".$adminid." and mp_ultype = 2 and  mp_isable = 1)";
        if($adWechat){
            $where .= " or (mp_u_id = ".$adWechat." and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = ".$adWechat." and mp_ultype = 1 and  mp_isable = 1)";
        }
        $list = Db::table('xcx_msg_person')
            ->where($where)->field('mp_id')
            ->select();
        $count = 0;
        if($list){
            foreach ($list as $k => $v){
                $count  += $this->getUnread($v['mp_id'],$adminid);
            }
        }
        return $count;
    }
    public function getUnreadMsg($adminid){
        //如果这个后台用户已经绑定小程序用户的话，包含小程序用户的未读消息
        $adWechat = session('ad_wechat');
        $where = "(mp_u_id = ".$adminid." and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = ".$adminid." and mp_ultype = 2 and  mp_isable = 1)";
        if($adWechat){
            $where .= " or (mp_u_id = ".$adWechat." and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = ".$adWechat." and mp_ultype = 1 and  mp_isable = 1)";
        }
        $list = Db::table('xcx_msg_person')
            ->where($where)->field('mp_id')
            ->select();
        $count = 0;
        if($list){
            foreach ($list as $k => $v){
                $count  += $this->getUnread($v['mp_id'],$adminid);
            }
        }
        return $count;
    }


    public function getUnread($mpid,$adminid){
        $isbend = $this->isBinduser($adminid);
        //更新已读状态
        if($isbend){
            $readWhere = '( xcx_msg_uid != '.$isbend.' and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != '.$adminid.' and  xcx_msg_u_type = 2 )';
        }else{
            $readWhere = 'xcx_msg_ul_id = '.$adminid.' and  xcx_msg_ul_type = 2 ';
        }
        $unRead = Db::table('xcx_msg_content')
            ->where(['xcx_msg_mp_id' => $mpid,'xcx_msg_isread' => 2,'xcx_msg_isable' =>1])
            ->where($readWhere)
            ->count('xcx_msg_id');
        return $unRead ? $unRead : 0;
    }

    public function isBinduser($adminid){
        $adminInfo = Db::table('super_admin')
            ->where(['ad_id' => $adminid])
            ->field('ad_wechat')
            ->find();
        return $adminInfo ? $adminInfo['ad_wechat'] :0;
    }


    //基本资料
    public function details(){
        return $this->fetch();
    }


    //网站首页。欢迎页
    public function welcome(){
        $corpId = session('ad_corp');
        $houseM = new Housem();
        $ad_role = session('ad_role');
        $adminid = session('adminId');
        $whereHAll = $ad_role == 1 ? "1 = 1" : "1 = 1 and is_admin = 2 and corp in (".$corpId.")";
        $whereAll = '1 = 1';
        $allHouse = $houseM->houseCount($whereHAll);
        $allUser = $houseM->userCount($whereAll);
        $todayStart = date('Y-m-d').' 00:00:00';
        $todayEnd = date('Y-m-d').' 23:59:59';
        $whereToday = "(cdate >= '".$todayStart."' and cdate <= '".$todayEnd."')";
        $where = "(publish_date >= '".$todayStart."' and publish_date <= '".$todayEnd."') and ".$whereHAll;
        $wherePerAll = 'is_admin = 2 and pm = '.$adminid;
        $wherePerTodayHouse = 'is_admin = 2 and pm = '.$adminid." and ".$whereToday;
        $todayUser = $houseM->userCount($whereToday);
        $todayHouse = $houseM->houseCount($where);
        $perAllHouse = $houseM->houseCount($wherePerAll);
        $perTodayHouse = $houseM->houseCount($wherePerTodayHouse);
        //下线一个月之前发布的房源
        $this->offLineHouse();
        //更新房源的点击和收藏量（虚拟数据）
        //2020年7月10日11:34:54佳文做市场推广，咱们是按照浏览量给用户红包
        // $this->updateHouseClickAndCollect();
        $lang = new Languages();
        $enLab = $lang->getLanguages();
        $langs = $lang->getLang();
        $this->assign('adminId',$ad_role);
        $this->assign('langs',$langs);
        $this->assign('lable',$enLab);
        $this->assign('allHouse',$allHouse);
        $this->assign('allUser',$allUser);
        $this->assign('todayHouse',$todayHouse);
        $this->assign('perAllHouse',$perAllHouse);
        $this->assign('perTodayHouse',$perTodayHouse);
        $this->assign('todayUser',$todayUser);
        return $this->fetch();
    }

    public function resetpwd(){
        $adminId=session('adminId');
        $this->assign('admin_id',$adminId);
        return $this->fetch();
    }

    public function resetpass(){
        $adminId=session('adminId');
        if($_POST){
            $oldPwd=md5($_POST['oldPwd']);
            $newPwd=md5($_POST['newPwd']);
            $newPwd1=md5($_POST['newPwd2']);
            $adminInfo=Db::table('super_admin')->where(['ad_id' => $adminId])->field('ad_password')->find();
            $adPwd=$adminInfo['ad_password'];
            if($adPwd != $oldPwd){
                $this->error('您输入的密码与原始密码不一致，请重新输入！');
            }else{
                if($newPwd != $newPwd1){
                    $this->error('您两次输入的新密码不一致，请重新输入！');
                }else{
                    if($adPwd == $newPwd){
                        $this->error('输入的新密码请勿与原密码相同！');
                    }else{
                        $data['ad_password']=$newPwd;
                        $resetPwd=Db::table('super_admin')->where(['ad_id' => $adminId])->update($data);
                        if($resetPwd){
                            session(null);
                            $this->success('修改密码成功，请重新登录！','login/login');
                        }else{
                            $this->error('修改密码失败','index');
                        }
                    }
                }
            }
        }
    }


    public function adminDetails(){
        $ad_id= session('adminId');
        if($ad_id ==  1){
            $adminInfo=Db::table('super_admin')
                ->where(['ad_id' => $ad_id])
                ->find();;
        }else{
            $adminInfo=Db::table('super_admin')
                ->join('super_province','super_province.p_id = super_admin.ad_p_id')
                ->join('super_city','super_city.c_id = super_admin.ad_c_id')
                ->join('super_branch','super_branch.b_id = super_admin.ad_branch')
                ->field('super_admin.*,super_province.p_name,super_city.c_name,super_branch.b_name')
                ->where(['ad_id' => $ad_id])
                ->find();
        }
        $this->assign('admin',$adminInfo);
        return $this->fetch();
    }


    //完善信息
    public function updateAdmin(){
        $ad_id=intval(session('adminId'));
        if($_POST){
            $data=$_POST;
            $update=Db::table('super_admin')->where(['ad_id' => $ad_id])->update($data);
            if($update){
                $this->success('完善信息成功！');
            }else{
                $this->success('完善信息失败！');
            }
        }
    }


    public function getHouse(){
        $today = date('Y-m-d');
        $weekAgo = date("Y-m-d", strtotime("-30 days"));
        $arr = $this->periodDate($weekAgo,$today);
        $houseM = new Housem();
        $ad_role = session('ad_role');
        $corpId = session('ad_corp');
        $ad_id=intval(session('adminId'));
        //角色不是超级管理员且有房源列表的权限的员工仅显示他的公司下的房源
        $where = $ad_role == 1 ? '1 = 1' : 'is_admin = 2 and corp in ('.$corpId.')';
        $whereAdmin = $ad_role == 1 ? '1 = 1' : 'is_admin = 2 and pm = '.$ad_id;
        foreach ($arr as $k => $v){
            $wherehouse = " publish_date <= '".$v['date']." 23:59:59' and is_del = 1";
            $wheres = " cdate >= '".$v['date']." 00:00:00' and cdate <= '".$v['date']." 23:59:59'";
            $arr[$k]['nums'] = $houseM->houseCount($wherehouse." and ".$where);
            //企业每日新增
            $arr[$k]['nums1'] = $houseM->houseCount($wherehouse." and ".$where);
            //个人每日新增
            $arr[$k]['nums2'] = $houseM->houseCount($wherehouse." and ".$whereAdmin);
            $arr[$k]['users'] = $houseM->userCount($wheres);
        }
        $sqldata_json=json_encode($arr);
        echo  $sqldata_json;
    }

    public function getHousePie(){
        $lang = new Languages();
        $langs = $lang->getLang();
        $arr=[
            '0' => $langs == 'Cn' ? '墨尔本':'Melbourne',
            '1' => $langs == 'Cn' ? '悉尼':'Sydney',
            '2' => $langs == 'Cn' ? '塔州':'Tasmania',
            '3' => $langs == 'Cn' ? '布里斯班':'Brisbane'
        ];
        $arrs[0]['name'] = $langs == 'Cn' ? '墨尔本':'Melbourne';
        $arrs[0]['names'] = '墨尔本';
        $arrs[1]['name'] = $langs == 'Cn' ? '悉尼':'Sydney';
        $arrs[1]['names'] = '悉尼';
        $arrs[2]['name'] = $langs == 'Cn' ? '塔州':'Tasmania';
        $arrs[2]['names'] = '塔州';
        $arrs[3]['name'] =  $langs == 'Cn' ? '布里斯班':'Brisbane';
        $arrs[3]['names'] ='布里斯班';
        $houseM = new Housem();
        $ad_role = session('ad_role');
        $corpId = session('ad_corp');
        //角色不是超级管理员且有房源列表的权限的员工仅显示他的公司下的房源
        $where = $ad_role == 1 ? '1 = 1' : 'is_admin = 2 and corp = '.$corpId;
        foreach ($arrs as $k => $v){
            $wheres = "is_del = 1 and city = '".$v['names']."' and ".$where;
            $arrs[$k]['value'] = $houseM->houseCount($wheres);
        }
        $sqldata_json=json_encode($arrs);
        echo  $sqldata_json;
    }
  
  
      public function getHousePieStatus(){
        $type = $this->request->param('type',0);
        $lang = new Languages();
        $langs = $lang->getLang();
        $adminId = session('adminId');
        $corpId = session('ad_corp');
        //角色不是超级管理员且有房源列表的权限的员工仅显示他的公司下的房源
          switch ($type){
              //企业
              case 1:
                  $where = "is_admin = 2 and corp in (".$corpId.")";
                  break;
                  //个人
              case 2:
                  $where = "is_admin = 2 and pm = ".$adminId;
                  break;
                  //管理员
              default:
                  $where = '1 = 1';
          }
        $arrs[0]['name'] = $langs == 'Cn' ? '草稿':'Draft';
        $arrs[1]['name'] = $langs == 'Cn' ? '发布':'On';
        $arrs[2]['name'] = $langs == 'Cn' ? '下线':'Off';
        $arrs[3]['name'] = $langs == 'Cn' ? '已删除':'Deleted';
        $houseM = new Housem();
        foreach ($arrs as $k => $v){
            if($k == 3){
                $delWhere = 'is_del = 2 and '.$where;
                $arrs[$k]['value'] = $houseM->houseCount($delWhere);
            }else{
                $wheres = "is_del = 1 and status = '".$k."' and ".$where;
                $arrs[$k]['value'] = $houseM->houseCount($wheres);
            }
        }
        $sqldata_json=json_encode($arrs);
        echo  $sqldata_json;
    }

    public function periodDate($start_time,$end_time){
        $start_time = strtotime($start_time);
        $end_time = strtotime($end_time);
        $i=0;
        while ($start_time<=$end_time){
            $arr[$i]['date']=date('Y-m-d',$start_time);
            $start_time = strtotime('+1 day',$start_time);
            $i++;
        }
        return $arr;
    }


    /***
     * 下线一个月之前的房源
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function offLineHouse(){
        $aMonthAgo = date("Y-m-d H:i:s", strtotime("-1 month"));
        Db::table('tk_houses')
            ->where("cdate <= '".$aMonthAgo."'")
            ->update(['status' => 2]);
    }


    /**
     *
     *
     * 下一次随机执行
     */
    public function updateHouseClickAndCollect(){
        //查询下次的更新时间是否为今天或者早于今天
        $isUpdate = Db::table('super_house_views')
            ->order('id desc')
            ->field('utime')
            ->find();
        $today = date('Y-m-d');
        if($isUpdate['utime'] != $today){
            //查询所有当前在线的房源
            $allOnLineHouse = Db::table('tk_houses')
                ->where(['status' => 1])
                ->field('id,collection,view')
                ->select();
            if($allOnLineHouse){
                foreach ($allOnLineHouse as $k => $v){
                    $this->updateClickAndCollViaId($v['id'],$v['view'],$v['collection']);
                }
                //更新下次更新虚拟数据的时间
//                $today = date('Y-m-d');
//                $nuDay = mt_rand(2,3);
//                $nextUpdate = date("Y-m-d",strtotime("+".$nuDay." days",strtotime($today)));
                Db::table('super_house_views')
                    ->insert(['utime' => date('Y-m-d')]);
            }
        }
    }


    /***
     * 更新点击量和收藏量
     * @param $id
     * @param $view
     * @param $collect
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function updateClickAndCollViaId($id,$view,$collect){
        $n = mt_rand(1,5);
        //点击量=当前点击量+取整[当前点击量/(10*n)], n取1-5
        //收藏量=当前收藏量+取整[当前点击量/(100*n)], n取1-5
        //每天运行1次，针对所有状态为上线的房源
        $views = $view+ceil($view/($n*10));
        $collects = $collect+ceil($view/($n*100));
        Db::table('tk_houses')
            ->where(['id' => $id])
            ->update(['collection' =>$collects,'view'=> $views]);
    }

    public function updatePhone(){
        //去除所有手机号的空格
        $allUsers = Db::table('tk_user')->field('id,tel')->select();
        foreach ($allUsers  as $k => $v){
            $this->trimPhone($v['id'],$v['tel']);
        }
        dump($allUsers);
    }

    public function trimPhone($id,$tel){
        $tel = str_replace(' ', '',$tel);
        Db::table('tk_user')->where(['id' => $id])->update(['tel' => $tel]);
    }
  
    public function updateHousePublishTime(){
        $houses = Db::table('tk_houses')->field('id,cdate,mdate,publish_date')->select();
        foreach ($houses as $k => $v){
            Db::table('tk_houses')->where(['id' => $v['id']])->update(['publish_date' => $v['mdate']]);
        }
        dump($houses);
    }


    /***
     * 根据发房源的公司信息修改房源的公司信息和PM
     */
    public function updateHouseCorpAndPm(){
        //查询所有是后台发布的房源
        $adminHouse = Db::table('tk_houses')
            ->where(['is_admin' => 2])
            ->field('id,user_id,pm,corp,is_admin')
            ->select();
        if($adminHouse){
            foreach ($adminHouse as $k => $v){
                //根据每个房源的userID查询到发房员的公司id
                //更新房源的公司id和pm
                $adminCorpid = $this->getAdminCorpId($v['user_id']);
                $res = Db::table('tk_houses')
                    ->where(['id' => $v['id']])
                    ->update(['pm' => $v['user_id'],'corp' =>$adminCorpid]);
            }
        }
    }


    public function getAdminCorpId($userid){
        $adminInfo = Db::table('super_admin')
            ->where(['ad_id' => $userid])
            ->field('ad_corp')
            ->find();
        return $adminInfo ? $adminInfo['ad_corp'] : 0;
    }
}
