<?php
class Housem extends \think\Model
{

    public  function getHouseDsn()
    {
        // 找室友编号开始为B
        $dsn = 'C';
        $max = \think\Db::table('tk_houses')->max('id');
        $s = '';
        for ($i = 1; $i < 10 - strlen($max); $i++) {
            $s .= '0';
        }
        $max++;
        $dsn .= $s.$max;
        return $dsn;
    }

}