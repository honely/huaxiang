<?php
/**
 *Author:DangMengmeng
 *Dates:2019/10/31
 *Times:17:13
 */
namespace app\xcx\controller;
use app\admin\model\Commons;
use app\xcx\model\Loops;
use think\Controller;
use PHPExcel_IOFactory;
use PHPExcel;
use think\Db;
class Export extends Controller{

    public function index()
    {
        return view();
    }

    public function out()
    {
        $path = dirname(__FILE__);
        vendor("PHPExcel.PHPExcel");
        vendor("PHPExcel.PHPExcel.Writer.Excel5");
        vendor("PHPExcel.PHPExcel.Writer.Excel2007");
        vendor("PHPExcel.PHPExcel.IOFactory");
        $objPHPExcel = new PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $keywords = trim($this->request->param('keywords'));
        $user = trim($this->request->param('user'));
        $today = date('Y-m-d')." 23:59:59";
        $month = date( 'Y-m-d', strtotime($today.' -1 month')).' 00:00:00';
        $where ="sk_keywords != '' and sk_addtime >= '".$month."' and sk_addtime <= '".$today."'";
        //$where ="1 = 1";
        //分页统计总数；
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( sk_keywords like '%".$keywords."%')";
        }
        if(isset($user) && !empty($user) && $user){
            $where.=" and ( nickname like '%".$user."%')";
        }
        $sql = Db::table('xcx_search_keywords')
            ->join('tk_user','tk_user.id = xcx_search_keywords.sk_userid')
            ->where($where)
            ->order('sk_addtime desc')
            ->field('xcx_search_keywords.*,tk_user.nickname')
            ->select();
        $loopd = new Loops();
        if($sql){
            foreach ($sql as $k => $v){
                $sql[$k]['sk_type'] = $v['sk_type'] == 1 ? '房源' : '找室友';
                $sql[$k]['sk_username'] = $loopd->getUserNick($v['sk_userid']);
            }
        }
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '搜索ID')
            ->setCellValue('B1', '搜索关键词')
            ->setCellValue('C1', '搜索类型')
            ->setCellValue('D1', '用户id')
            ->setCellValue('E1', '用户昵称')
            ->setCellValue('F1', '搜索时间');
        $count = count($sql); //计算有多少条数据
        for ($i = 2; $i <= $count + 1; $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sql[$i - 2]['sk_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $sql[$i - 2]['sk_keywords']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $sql[$i - 2]['sk_type']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $sql[$i - 2]['sk_userid']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $sql[$i - 2]['nickname']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $sql[$i - 2]['sk_addtime']);
        }
        /*--------------下面是设置其他信息------------------*/

        $objPHPExcel->getActiveSheet()->settitle('搜索记录表'); //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0); //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); //通过PHPExcel_IOFactory的写函数将上面数据写出来
        $PHPWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        header('Content-Disposition: attachment;filename="搜索记录表.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
    }

}
