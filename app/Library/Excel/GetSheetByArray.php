<?php
/**
 * Created by PhpStorm.
 * User: zhou_shaohui
 * Date: 2020/11/24
 * Time: 14:34
 */

namespace App\Library\Excel;


use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class GetSheetByArray extends ExportBase implements FromArray, WithTitle
{
    protected $title;
    protected $data;
    public function __construct($title,$data)
    {
        $this->title = $title;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return $this->data;
    }
}