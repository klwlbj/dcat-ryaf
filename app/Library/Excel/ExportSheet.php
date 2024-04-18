<?php
/**
 * Created by PhpStorm.
 * User: zhou_shaohui
 * Date: 2020/11/24
 * Time: 11:37
 */

namespace App\Library\Excel;



use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportSheet extends ExportBase implements WithMultipleSheets
{
    protected $sheets = [];   //设置sheet

    public function __construct($sheets)
    {
        $this->sheets = [];
        foreach ($sheets as $key => $value){
            $this->sheets[] = new GetSheetByArray($value['title'],$value['data']);
        }
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return $this->sheets;
    }
}