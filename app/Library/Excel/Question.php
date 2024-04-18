<?php
/**
 * Created by PhpStorm.
 * User: zhou_shaohui
 * Date: 2020/12/15
 * Time: 18:06
 */

namespace App\Library\Excel;


use Maatwebsite\Excel\Concerns\ToArray;

class Question implements ToArray
{
    //重新父类实现
    public function array(array $array){

        return $array;
    }
}