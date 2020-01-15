<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Loader;
class Import extends Controller{
    public function import(){
        header('Content-type: text/html; charset=utf-8'); //设置页面编码
        set_time_limit(0);
        ini_set('memory_limit','1024M');
        $save_path = "./uploadfile/excle/";
        if(!is_dir($save_path)){
            mkdir($save_path, 0777, true ); //不存创建新的文件夹
        }
        if(!is_writable($save_path)){       //给目录存在没有权限
            chmod($save_path, 0777);
        }
        if(!empty($_FILES)){
            $name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $name_tmp = $_FILES['file']['tmp_name'];
            $type = explode('.',$name);
            $allow_type = array('xls', 'xlsx', 'csv');
            if (empty($name)) {
                $this->error('您未选择文件！');
            }
            if(!in_array(strtolower($type[1]),$allow_type)){
                $this->error('上传的文件格式不正确~');
            }
            $file_name = time() . rand(1000000, 9999999);
            $file_path = $save_path.$file_name .'.'. $type[1]; //文件路径
            if(move_uploaded_file($name_tmp, $file_path)){
                Loader::import('PHPExcel/IOFactory',EXTEND_PATH);
                if($type[1] =='xlsx'||$type=='xls' ){
                    $reader = \PHPExcel_IOFactory::createReader('Excel2007');
                }else{
                    $reader = \PHPExcel_IOFactory::createReader('CSV');
                }
                $PHPExcel = $reader->load($file_path);
                $objWorksheet = $PHPExcel->getSheet(0);
                $highestRow   = $objWorksheet->getHighestRow();    //取得总行数
                $highestColumn = $objWorksheet->getHighestColumn();
                $highestColumn = $this->columnIndexFromString($highestColumn);    // 取得总列数转成数字
                if($highestRow>5000){
                    $this->error('数据太多，请分批次导入（每次小于5000条');
                }
                $data = array();
                $string='';
                $str = "INSERT INTO super_goods(`goods_name`,`goods_sort`,`goods_type`,`goods_price`,`goods_dis_price`,`goods_stock`,`goods_img`,`goods_img_more`,`goods_sales_num`,`goods_view`,`goods_top_time`,`goods_top_flg`,`goods_del_flg`,`goods_add_date`,`goods_change_date`,`goods_admin`) VALUES ";
                for ($row =2; $row <= $highestRow; $row++) {//去除标题
                    for ($column =0;$column<$highestColumn;$column++){
                        $val = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                        if ($column==13||$column==14)  {
                            $val = strtotime($val);
                        }
                        $string .= "'$val'".',';
                    }
                    $str .='('.trim($string,',').'),';
                    $string=''; //清空值
                }
                $str = trim($str,',').';';
                $result = Db::execute($str);
                if($result > 0){
                    $this->success('数据导入成功!');
                }else{
                    $this->error('数据导入失败!');
                }
                // $result = db()->query();
                unlink($file_path);
            }
        }
    }


//将列名字母转换成数字
    public  function columnIndexFromString($pString = 'A'){
        static $_indexCache = array();
        if (isset($_indexCache[$pString])) {
            return $_indexCache[$pString];
        }
        static $_columnLookup = array(
            'A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'F' => 6, 'G' => 7, 'H' => 8, 'I' => 9, 'J' => 10, 'K' => 11, 'L' => 12, 'M' => 13,
            'N' => 14, 'O' => 15, 'P' => 16, 'Q' => 17, 'R' => 18, 'S' => 19, 'T' => 20, 'U' => 21, 'V' => 22, 'W' => 23, 'X' => 24, 'Y' => 25, 'Z' => 26,
            'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5, 'f' => 6, 'g' => 7, 'h' => 8, 'i' => 9, 'j' => 10, 'k' => 11, 'l' => 12, 'm' => 13,
            'n' => 14, 'o' => 15, 'p' => 16, 'q' => 17, 'r' => 18, 's' => 19, 't' => 20, 'u' => 21, 'v' => 22, 'w' => 23, 'x' => 24, 'y' => 25, 'z' => 26
        );
        if (isset($pString{0})) {
            if (!isset($pString{1})) {
                $_indexCache[$pString] = $_columnLookup[$pString];
                return $_indexCache[$pString];
            } elseif (!isset($pString{2})) {
                $_indexCache[$pString] = $_columnLookup[$pString{0}] * 26 + $_columnLookup[$pString{1}];
                return $_indexCache[$pString];
            } elseif (!isset($pString{3})) {
                $_indexCache[$pString] = $_columnLookup[$pString{0}] * 676 + $_columnLookup[$pString{1}] * 26 + $_columnLookup[$pString{2}];
                return $_indexCache[$pString];
            }
        }
    }
}
