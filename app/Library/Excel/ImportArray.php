<?php
/**
 * Created by PhpStorm.
 * User: zhou_shaohui
 * Date: 2022/1/18
 * Time: 17:01
 */

namespace App\Library\Excel;


use Maatwebsite\Excel\Concerns\ToArray;

class ImportArray implements ToArray
{
    //重新父类实现
    public function array(array $array){
        return $array;
    }
}