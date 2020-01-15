<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/4/23
 * Time: 14:59
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Excel extends Controller{
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

//    public function excel()
//    {
//        $data = array();
//
//        //我的数据信息
//        $contentRows = Db::table('super_customer')->select();
//        if($contentRows){
//            foreach ($contentRows as $contentRow){
//                $info = array();
//
//                $info['cus_id'] = $contentRow['cus_id'];
//                $info['cus_name'] = $contentRow['cus_name'];
//                $info['cus_phone'] = $contentRow['cus_phone'];
//                $data[] = $info;
//            }
//        }
//        //定义表名称
//        $name = 'ABC';
//
//        //引入PHPExcel，注意看一下是引入的什么！并不是你下载PHPExcel 都是需要的，需要什么就拿过来什么好了
//        Vendor("PHPExcel.Classes.PHPExcel");
//         $excel = new \PHPExcel();
//
//        //定义列数，与excel中的列的命名一样
//         $letter = array('A', 'B', 'C');
//
//        //定义表头信息
//         $tableheader = array('ID', '客户名称', '电话');
//
//
//         for ($i = 0; $i < count($tableheader); $i++)
//         {
//             $excel->getActiveSheet()->setCellValue("$letter[$i]1", "$tableheader[$i]");
//         }
//
//        //写入信息到excel
//         for ($i = 2; $i <= count($data) + 1; $i++)
//         {
//             $j = 0;
//             foreach ($data[$i - 2] as $key => $value)
//             {
//                 $excel->getActiveSheet()->setCellValue("$letter[$j]$i", "$value");
//                 $j++;
//             }
//         }
//
//         //创建Excel输入对象
//         $write = new \PHPExcel_Writer_Excel5($excel);
//         header("Pragma: public");
//         header("Expires: 0");
//         header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
//         header("Content-Type:application/force-download");
//         header("Content-Type:application/vnd.ms-execl");
//         header("Content-Type:application/octet-stream");
//         header("Content-Type:application/download");
//         header('Content-Disposition:attachment;filename="'.$name.'".xls"');
//         header("Content-Transfer-Encoding:binary");
//         $write->save('php://output');
//    }


    public function phpExcelList($field, $list, $title='文件')
    {
        vendor('phpExcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel); //设置保存版本格式
        foreach ($list as $key => $value) {
            foreach ($field as $k => $v) {
                if ($key == 0) {
                    $objPHPExcel->getActiveSheet()->setCellValue($k . '1', $v[1]);
                }
                $i = $key + 2; //表格是从2开始的
                $objPHPExcel->getActiveSheet()->setCellValue($k . $i, $value[$v[0]]);
            }

        }
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename='.$title.'.xls');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save($title.'.xls');
        $objWriter->save('php://output');
    }
    public function outExcelRecharge() {
        $data=Db::table('super_customer')->field('cus_id,cus_name,cus_phone')->select();
        $field = array(
            'A' => array('cus_id', 'ID'),
            'B' => array('cus_name', '客户名称'),
            'C' => array('cus_phone', '用户电话')
        );
        $this->phpExcelList($field, $data, '充值列表_' . date('Y-m-d'));
    }



    //批量导出数据
    public function emportBatch () {
        //文件名称
        $xlsName ='客户列表Excel'.date('Y-m-d');
        //数据字段
        $db = Db::getConnection();
        $fields = $db->getFields("super_customer");
        $xlsCell = [];
        $i = 0;
        foreach ($fields as $key => $v){
            $xlsCell = $this->cn_fields($xlsCell,$i,$key);
            $i++;
        }
        $excid =rtrim($this->request->param('ids'),',');;
        if (empty($excid)) {
            $xlsData =Db::table('super_customer')->select(); //全部导出
        } else {
            $xlsData =Db::table('super_customer')->where('cus_id','IN',$excid)->select(); //选中导出
        }
        if (!$xlsData) $this->error("没有数据,无法导出操作╮(╯_╰)╭");
        $this->exportExcel($xlsName,$xlsCell,$fields);
    }
    //导出方法
    protected function exportExcel($expTitle,$expCellName,$expTableData){
        $fileName = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        $objPHPExcel = new PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.' Time:'.date('Y-m-d H:i:s'));
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
        }
        for($i=0;$i<$dataNum;$i++){
            for($j=0;$j<$cellNum;$j++){
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
            }
        }
        ob_end_clean();
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$fileName.'.xlsx"');
        header("Content-Disposition:attachment;filename=$fileName.xlsx");
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
//字段中文名称
    protected function cn_fields ($xlsCell,$i,$key) {
        $xlsCell[$i][] = $key;
        switch ($key){
            case 'cus_id':
                $xlsCell[$i][] = 'ID';
                break;
            case 'cus_name':
                $xlsCell[$i][] = '名字';
                break;
            case 'cus_phone':
                $xlsCell[$i][] = '电话';
                break;
        }
        return $xlsCell;
    }

}