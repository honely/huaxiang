<?php
/**
 * Created by PhpStorm.
 * User: fogbow
 * Date: 2020/10/22
 * Time: 23:06
 */

namespace app\xcx\controller;

use think\Controller;
use think\Request;
use think\Db;
use app\xcx\model\Rolem;
use think\Log;

class Tickrent extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $adminName = session('adminName');
        if (empty($adminName)) {
            $this->error('请先登录！', 'login/login');
        }
        if (isset($_SESSION['expiretime'])) {
            if ($_SESSION['expiretime'] < time()) {
                unset($_SESSION['expiretime']);
                $this->error('您的登录身份已过期，请重新登录！', 'login/login');
                exit(0);
            } else {
                $_SESSION['expiretime'] = time() + 1800; // 刷新时间戳
            }
        }
    }

    /*
     * 申请管理
     *
     * */
    public function index()
    {
        return $this->fetch();
    }

    public function applyData()
    {
        $where = [];
        $where['b.type'] = '0';
        if (!empty(trim($this->request->param('APPLY_ID')))) $where['a.APPLY_ID'] = trim($this->request->param('APPLY_ID'));
        if (!empty(trim($this->request->param('house_addr')))) $where['house_addr'] = trim($this->request->param('house_addr'));
        if (!empty(trim($this->request->param('agent')))) $where['agent'] = trim($this->request->param('agent'));
        if (!empty(trim($this->request->param('name')))) $where['first_name'] = trim($this->request->param('name'));
        if (!empty(trim($this->request->param('status')))) $where['a.status'] = trim($this->request->param('status'));

        $page = $this->request->param('page', 1, 'intval');
        $limit = $this->request->param('limit', 50, 'intval');

        $count = Db::table('tk_rapply')
            ->alias('a')
            ->join('tk_rapply_people b', 'a.id = b.apply_id', 'left')
            ->where($where)
            ->count();
        $design = Db::table('tk_rapply')
            ->field("a.id,a.APPLY_ID,a.house_addr,a.rent,a.bond,a.trent,a.lease_term,a.live_date,a.prerent,a.agent,a.is_accept,a.people_num
            ,(CASE a.is_seen 
            WHEN 0 THEN '本人未看房'
            WHEN 1 THEN '本人已看房'
            end) as is_seen
            ,(CASE a.status 
            WHEN 0 THEN '未读'
            WHEN 1 THEN '已读'
            WHEN 2 THEN '处理中'
            WHEN 9 THEN '已删除'
            end) as status,b.last_name as people_name")
            ->alias('a')
            ->join('tk_rapply_people b', 'a.id = b.apply_id', 'left')
            ->where($where)
            ->order('a.createtime', 'desc')
            ->limit(($page - 1) * $limit, $limit)
            ->select();

        $res['code'] = 0;
        $res['msg'] = "";
        $res['data'] = $design;
        $res['count'] = $count;
        return json($res);
    }

    public function detail($id)
    {
        $data = Db::table('tk_rapply')
            ->field("a.id,a.APPLY_ID,a.house_addr,a.house_type,a.house_unit,a.user_id
            ,a.rent,a.bond,a.trent,a.lease_term,a.live_date,a.prerent,a.agent,a.people_num
            ,a.contact_name,a.contact_mobile,a.contact_addr,a.contact_rela,a.contact_email
            ,a.referee_name,a.referee_mobile,a.referee_addr,a.referee_rela,a.referee_email
            ,b.first_name,b.last_name,b.country,b.email,b.occupation,b.school,b.birthday,b.mobile,b.pet_num,b.id as people_id
            ,(CASE b.sex 
            WHEN 0 THEN '男'
            WHEN 1 THEN '女'
            end) as sex
            ,(CASE a.is_accept 
            WHEN 0 THEN '否'
            WHEN 1 THEN '是'
            end) as is_accept
            ,(CASE a.is_seen 
            WHEN 0 THEN '本人未看房'
            WHEN 1 THEN '本人已看房'
            end) as is_seen
            ,(CASE a.status 
            WHEN 0 THEN '未读'
            WHEN 1 THEN '已读'
            WHEN 2 THEN '处理中'
            WHEN 3 THEN '同意'
            WHEN 4 THEN '拒绝'
            WHEN 9 THEN '已删除'
            end) as status,b.last_name as people_name")
            ->alias('a')
            ->join('tk_rapply_people b', 'a.id = b.apply_id', 'left')
            ->where(['a.id' => $id, 'b.type' => '0'])
            ->find();
        if ($data['status'] == '未读') {
            Db::name('tk_rapply')->where('id', $id)->update(['status' => '1']);
        }
        if ($data['people_num'] > 1) {
            $data['people'] = Db::table('tk_rapply_people')
                ->where(['apply_id' => $id])
                ->where(['type' => ['neq', '0']])
                ->order('updatetime', 'desc')
                ->select();
            foreach ($data['people'] as $key => &$value) {
                if ($value['pet_num'] > 0) {
                    $value['pet'] = Db::table('tk_rapply_pet')
                        ->where(['people_id' => $value['id']])
                        ->limit(5)
                        ->order('updatetime', 'desc')
                        ->select();
                }
            }
        }

        if ($data['pet_num'] > 0) {
            $data['pet'] = Db::table('tk_rapply_pet')
                ->where(['people_id' => $data['people_id']])
                ->order('updatetime', 'desc')
                ->select();
        }
        $data['history'] = Db::table('tk_rhistory')
            ->field("house_addr,live_type,rent,live_time,email,mobile
            ,(CASE is_br WHEN 0 THEN '否' WHEN 1 THEN '是' end) as is_br
            ,(CASE is_land WHEN 0 THEN '否' WHEN 1 THEN '是' end) as is_land")
            ->where(['user_id' => $data['user_id']])
            ->order('updatetime', 'desc')
            ->select();
        $data['material'] = Db::table('tk_rmaterial')
            ->field('b.name,a.id')
            ->alias('a')
            ->join('tk_rmaterial_type b', 'a.type_id = b.id', 'left')
            ->where(['user_id' => $data['user_id']])
            ->order('a.updatetime', 'desc')
            ->select();

        $this->assign('data', $data);
        $this->assign('id', $id);

        return $this->fetch();
    }

    public function applyDo()
    {
        if ($this->request->isPost()) {
            $ids = $this->request->request('ids');
            $act = $this->request->request('act');
            if ($act == 1) {
                $status = '3';
            }else{
                $status = '4';
            }
            Db::name('tk_rapply')->where('id', $ids)->update(['status' => $status]);

            $res['code'] = '1';
            $res['msg'] = 'success';
            return $res;
        }
    }

}