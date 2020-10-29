<?php


namespace app\api\controller;


use think\Controller;
use think\Db;
use think\Exception;
use think\Validate;

class Trapply extends Controller
{
    /**
     * 申请列表
     */
    public function getList()
    {
        $uid = trim($this->request->param('uid'));
        $data = Db::table('tk_rapply')
            ->field('id,house_addr,rent,house_img,createtime')
            ->where(['user_id' => $uid, 'status' => array('neq', '9')])
            ->limit(5)
            ->order('updatetime', 'desc')
            ->select();
        if (empty($data)) {
            $res['code'] = 0;
            $res['msg'] = '数据为空';
            return json($res);
        }
        $res['code'] = 1;
        $res['msg'] = '读取成功';
        $res['data'] = $data;
        return json($res);
    }

    /**
     * 申请详情
     */
    public function getInfo()
    {
        $uid = trim($this->request->param('uid'));
        $id = $this->request->post('id');
        $data = Db::table('tk_rapply')
//            ->field('id,house_addr,rent,house_img,createtime')
            ->where(['id' => $id])
            ->find();
        if (empty($data)) {
            $res['code'] = 0;
            $res['msg'] = '数据为空';
            return json($res);
        }
        $data['people'] = Db::table('tk_rapply_people')
            ->where(['apply_id' => $id])
            ->limit(5)
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
        $res['code'] = 1;
        $res['msg'] = '读取成功';
        $res['data'] = $data;
        return json($res);
    }

    /**
     * 创建申请
     */
    public function create()
    {
        if ($this->request->isPost()) {
            $uid = $this->request->post('uid');
            $data = [
                'user_id' => $uid,
                'house_addr' => $this->request->post('house_addr'),
                'house_type' => $this->request->post('house_type'),
                'house_unit' => $this->request->post('house_unit'),
                'house_img' => $this->request->post('house_img'),
                'rent' => $this->request->post('rent'),
                'trent' => $this->request->post('trent'),
                'bond' => $this->request->post('bond'),
                'lease_term' => $this->request->post('lease_term'),
                'live_date' => $this->request->post('live_date'),
                'is_pre' => $this->request->post('is_pre'),
                'agency' => $this->request->post('agency'),
                'agent' => $this->request->post('agent'),
                'email' => $this->request->post('email'),
                'is_accept' => $this->request->post('is_accept'),
                'is_seen' => $this->request->post('is_seen'),
                'people_num' => $this->request->post('people_num'),
                'contact_name' => $this->request->post('contact_name'),
                'contact_mobile' => $this->request->post('contact_mobile'),
                'contact_addr' => $this->request->post('contact_addr'),
                'contact_rela' => $this->request->post('contact_rela'),
                'contact_email' => $this->request->post('contact_email'),
                'referee_name' => $this->request->post('referee_name'),
                'referee_mobile' => $this->request->post('referee_mobile'),
                'referee_addr' => $this->request->post('referee_addr'),
                'referee_rela' => $this->request->post('referee_rela'),
                'referee_email' => $this->request->post('referee_email'),
                'APPLY_ID' => 'S100000000',
                'createtime' => time(),
                'updatetime' => time(),
            ];
            $rule = [
                'house_addr' => 'require',
                'house_type' => 'require',
                'house_unit' => 'require',
                'house_img' => 'require',
                'rent' => 'require',
                'trent' => 'require',
                'bond' => 'require',
                'lease_term' => 'require',
                'live_date' => 'require',
                'is_pre' => 'require',
                'agency' => 'require',
                'agent' => 'require',
                'email' => 'require',
                'is_accept' => 'require',
                'is_seen' => 'require',
                'people_num' => 'require',
                'contact_name' => 'require',
                'contact_mobile' => 'require',
                'contact_addr' => 'require',
                'contact_rela' => 'require',
                'contact_email' => 'require',
                'referee_name' => 'require',
                'referee_mobile' => 'require',
                'referee_addr' => 'require',
                'referee_rela' => 'require',
                'referee_email' => 'require',
            ];
            $msg = [
                'house_addr' => '房源地址不能为空',
                'house_type' => '房源类型不能为空',
                'house_unit' => '户型不能为空',
                'house_img' => '房源图片不能为空',
                'rent' => '租金不能为空',
                'trent' => '提议租金不能为空',
                'bond' => '押金不能为空',
                'lease_term' => '租期不能为空',
                'live_date' => '入住时间不能为空',
                'is_pre' => '是否预付租金不能为空',
                'agency' => '中介公司不能为空',
                'agent' => '中介姓名不能为空',
                'email' => '中介邮箱不能为空',
                'is_accept' => '是否接受不能为空',
                'is_seen' => '是否看过房不能为空',
                'people_num' => '申请人数不能为空',
                'contact_name' => '紧急联系人不能为空',
                'contact_mobile' => '紧急联系人手机号不能为空',
                'contact_addr' => '紧急联系人地址不能为空',
                'contact_rela' => '紧急联系人关系不能为空',
                'contact_email' => '紧急联系人邮箱不能为空',
                'referee_name' => '推荐人不能为空',
                'referee_mobile' => '推荐人手机号不能为空',
                'referee_addr' => '推荐人地址不能为空',
                'referee_rela' => '推荐人关系不能为空',
                'referee_email' => '推荐人邮箱不能为空',
            ];
            $data['material'] = Db::table('tk_rmaterial')
                ->alias('a')
                ->join('tk_rmaterial_type b', 'a.type_id = b.id', 'left')
                ->where(['user_id' => $uid])
                ->sum('b.score');

            if ($data['is_pre'] == 1) {
                $data['prerent'] = $this->request->post('prerent');
            }
            $people = $this->request->post('people/a');

            //验证
            $validate = new Validate($rule, $msg);
            $result = $validate->check($data);
            if (!$result) {
                $res['code'] = 0;
                $res['msg'] = $validate->getError();
                return json($res);
            }

            try {
                $tk_rapply_id = Db::name('tk_rapply')->insertGetId($data);
                foreach ($people as $key => $value) {
                    $value['apply_id'] = $tk_rapply_id;
                    $value['createtime'] = time();
                    $value['updatetime'] = time();
                    if (isset($value['pet_num']) && $value['pet_num'] > 0 && isset($value['pet'])) {
                        $pet = $value['pet'];
                        unset($value['pet']);
                        $tk_rapply_people_id = Db::name('tk_rapply_people')->insertGetId($value);
                        foreach ($pet as $k => $v) {
                            $v['apply_id'] = $tk_rapply_id;
                            $v['people_id'] = $tk_rapply_people_id;
                            $v['createtime'] = time();
                            $v['updatetime'] = time();
                            Db::name('tk_rapply_pet')->insert($v);
                        }
                    } else {
                        Db::name('tk_rapply_people')->insertGetId($value);
                    }
                }
                $res['code'] = 1;
                $res['msg'] = '申请创建成功';
                return json($res);
            } catch (Exception $e) {
                Db::rollback();
                $res['code'] = 0;
                $res['msg'] = '创建失败';
                return json($res);
            }
        }
    }

    /**
     * 修改申请信息
     */
    public function edit()
    {
        if ($this->request->isPost()) {
            $id = $this->request->post('id');
            $uid = $this->request->post('uid');
            $apply = Db::table('tk_rapply')
                ->where(['id' => $id, 'user_id' => $uid])
                ->find();
            if (empty($apply)) {
                $res['code'] = 0;
                $res['msg'] = '该申请不存在';
                return json($res);
            }
            $data = $this->request->post();
            unset($data['uid']);
            $data['user_id'] = $id;
            if (!empty($data['people'])) {
                $people = $data['people'];
                unset($data['people']);
            }
            try {
                Db::name('tk_rapply')->where('id', $id)->update($data);
                if (!empty($people)) {
                    foreach ($people as $key => $value) {
                        $value['updatetime'] = time();
                        if (isset($value['pet_num']) && $value['pet_num'] > 0 && isset($value['pet'])) {
                            $pet = $value['pet'];
                            unset($value['pet']);
                            if(empty( $value['id'])){
                                $value['apply_id'] = $id;
                                $value['createtime'] = time();
                                $tk_rapply_people_id = Db::name('tk_rapply_people')->insertGetId($value);
                                foreach ($pet as $k => $v) {
                                    $v['apply_id'] = $id;
                                    $v['people_id'] = $tk_rapply_people_id;
                                    $v['createtime'] = time();
                                    $v['updatetime'] = time();
                                    Db::name('tk_rapply_pet')->insert($v);
                                }
                            }else{
                                Db::name('tk_rapply_people')->where('id', $value['id'])->update($value);
                                foreach ($pet as $k => $v) {
                                    $v['updatetime'] = time();
                                    Db::name('tk_rapply_pet')->where('id', $v['id'])->update($v);
                                }
                            }
                        } else {
                            Db::name('tk_rapply_people')->where('id', $value['id'])->update($value);
                        }
                    }
                }
                $res['code'] = 1;
                $res['msg'] = '修改成功';
                return json($res);
            } catch (Exception $e) {
                Db::rollback();
                $res['code'] = 0;
                $res['msg'] = '修改失败';
                return json($res);
            }
        }
    }

    /**
     * 删除申请
     */
    public function del()
    {
        if ($this->request->isPost()) {
            $id = $this->request->post('id');
            $user_id = $this->request->post('uid');
            $result = Db::name('tk_rapply')->where(['id' => $id, 'user_id' => $user_id])->setField('status', 9);
            if ($result) {
                $res['code'] = 1;
                $res['msg'] = '删除申请成功';
                return json($res);
            } else {
                $res['code'] = 0;
                $res['msg'] = '删除申请失败';
                return json($res);
            }
        }
    }

    /**
     * 添加租房历史
     */
    public function addHistory()
    {
        if ($this->request->isPost()) {
            $data = [
                'user_id' => $this->request->post('uid'),
                'house_addr' => $this->request->post('house_addr'),
                'live_type' => $this->request->post('live_type'),
                'rent' => $this->request->post('rent'),
                'live_time' => $this->request->post('live_time'),
                'email' => $this->request->post('email'),
                'mobile' => $this->request->post('mobile'),
                'is_br' => $this->request->post('is_br'),
                'is_land' => $this->request->post('is_land'),
                'createtime' => time(),
                'updatetime' => time(),
            ];

            $rule = [
                'user_id' => 'require',
                'house_addr' => 'require',
                'live_type' => 'require',
                'rent' => 'require',
                'live_time' => 'require',
                'email' => 'require',
                'mobile' => 'require',
                'is_br' => 'require',
                'is_land' => 'require',
            ];

            $msg = [
                'user_id' => '用户id不能为空',
                'house_addr' => '租房地址不能为空',
                'live_type' => '居住情况不能为空',
                'rent' => '周租金不能为空',
                'live_time' => '居住时长不能为空',
                'email' => '房东/中介 邮箱不能为空',
                'mobile' => '房东/中介 联系方式不能为空',
                'is_br' => '押金是否返还不能为空',
                'is_land' => '房东/中介不能为空',
                'createtime' => time(),
                'updatetime' => time(),
            ];


            //验证
            $validate = new Validate($rule, $msg);
            $result = $validate->check($data);
            if (!$result) {
                $res['code'] = 0;
                $res['msg'] = $validate->getError();
                return json($res);
            }
            try {
                $tk_history_id = Db::name('tk_rhistory')->insertGetId($data);

                $res['code'] = 1;
                $res['msg'] = '添加租房历史成功';
                return json($res);
            } catch (Exception $e) {
                Db::rollback();
                $res['code'] = 0;
                $res['msg'] = '添加失败';
                return json($res);
            }
        }
    }
}