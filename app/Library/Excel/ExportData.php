<?php
/**
 * Created by PhpStorm.
 * User: zhou_shaohui
 * Date: 2020/11/24
 * Time: 10:13
 */

namespace App\Library\Excel;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportData extends ExportBase implements FromCollection
{
    protected $data;

    //设置页面属性时如果无效   更改excel格式尝试即可

    //构造函数传值
    public function __construct($data)
    {
        $this->data = $data;
        $this->createData();
    }

    //数组转集合
    public function collection()
    {
        return new Collection($this->data);
    }

    //业务代码
    public function createData()
    {
        $this->data = collect($this->data)->toArray();
    }



}