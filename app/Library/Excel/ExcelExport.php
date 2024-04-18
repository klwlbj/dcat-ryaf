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
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterSheet;

class ExcelExport implements FromCollection,WithHeadings, WithEvents,WithMultipleSheets
{
    protected $data;
    protected $headings;
    protected $columnWidth = [];//设置列宽       key：列  value:宽
    protected $rowHeight = [];  //设置行高       key：行  value:高
    protected $mergeCells = []; //合并单元格      key：第一个单元格  value:第二个单元格
    protected $font = [];       //设置字体       key：A1:K8  value:11
    protected $bold = [];       //设置粗体       key：A1:K8  value:true
    protected $background = []; //设置背景颜色    key：A1:K8  value:#F0F0F0F
    protected $vertical = [];   //设置定位       key：A1:K8  value:center
    protected $sheets = [];   //设置sheet

    //设置页面属性时如果无效   更改excel格式尝试即可

    //构造函数传值
    public function __construct($data, $headings)
    {
        $this->data = $data;
        $this->headings = $headings;
        $this->createData();
    }

    public function headings(): array
    {
        return $this->headings;
    }

    //数组转集合
    public function collection()
    {
        return new Collection($this->data);
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return $this->sheets;
    }

    //业务代码
    public function createData()
    {
        $this->data = collect($this->data)->toArray();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class  => function(AfterSheet $event) {
                //设置列宽
                foreach ($this->columnWidth as $column => $width) {
                    $event->sheet->getDelegate()
                        ->getColumnDimension($column)
                        ->setWidth($width);
                }
                //设置行高，$i为数据行数
                foreach ($this->rowHeight as $row => $height) {
                    $event->sheet->getDelegate()
                        ->getRowDimension($row)
                        ->setRowHeight($height);
                }

                //设置区域单元格垂直居中
                foreach ($this->vertical as $region => $position) {
                    $event->sheet->getDelegate()
                        ->getStyle($region)
                        ->getAlignment()
                        ->setVertical($position);
                }

                //设置区域单元格字体
                foreach ($this->font as $region => $value) {
                    $event->sheet->getDelegate()
                        ->getStyle($region)
                        ->getFont()
                        ->setSize($value);
                }

                //设置区域单元格字体粗体
                foreach ($this->bold as $region => $bool) {
                    $event->sheet->getDelegate()
                        ->getStyle($region)
                        ->getFont()
                        ->setBold($bool);
                }


                //设置区域单元格背景颜色
                foreach ($this->background as $region => $item) {
                    $event->sheet->getDelegate()->getStyle($region)->applyFromArray([
                        'fill' => [
                            'fillType' => 'linear', //线性填充，类似渐变
                            'startColor' => [
                                'rgb' => $item //初始颜色
                            ],
                            //结束颜色，如果需要单一背景色，请和初始颜色保持一致
                            'endColor' => [
                                'argb' => $item
                            ]
                        ]
                    ]);
                }
                //合并单元格
                foreach ($this->mergeCells as $start => $end) {
                    $event->sheet->getDelegate()->mergeCells($start.':'.$end);
                }

            }
        ];
    }

    public function setColumnWidth (array $columnwidth)
    {
        $this->columnWidth = array_change_key_case($columnwidth, CASE_UPPER);
    }

    function setRowHeight (array $rowHeight)
    {
        $this->rowHeight = $rowHeight;
    }


    public function setFont (array $fount)
    {
        $this->font = array_change_key_case($fount, CASE_UPPER);
    }


    public function setBold (array $bold)
    {
        $this->bold = array_change_key_case($bold, CASE_UPPER);
    }


    public function setBackground (array $background)
    {
        $this->background = array_change_key_case($background, CASE_UPPER);
    }

    public function setSheets (array $sheets)
    {
        $this->sheets = [];
        foreach ($sheets as $key => $value){
            $this->sheets[] = new ExportSheet($value['title'],$value['data']);
        }
    }
}