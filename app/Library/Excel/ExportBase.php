<?php
/**
 * Created by PhpStorm.
 * User: zhou_shaohui
 * Date: 2020/11/24
 * Time: 14:32
 */

namespace App\Library\Excel;


use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;

class ExportBase implements WithEvents
{
    protected $columnWidth = [];//设置列宽       key：列  value:宽
    protected $rowHeight = [];  //设置行高       key：行  value:高
    protected $mergeCells = []; //合并单元格      key：第一个单元格  value:第二个单元格
    protected $font = [];       //设置字体       key：A1:K8  value:11
    protected $bold = [];       //设置粗体       key：A1:K8  value:true
    protected $background = []; //设置背景颜色    key：A1:K8  value:#F0F0F0F
    protected $vertical = [];   //设置定位       key：A1:K8  value:center
    protected $horizontal = [];   //设置定位       key：A1:K8  value:center
    protected $hyperlink = [];   //设置定位       key：A1:K8  value:center
    protected $wrapText = []; //换行

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

                //设置区域单元格水平居中
                foreach ($this->horizontal as $region => $position) {
                    $event->sheet->getDelegate()
                        ->getStyle($region)
                        ->getAlignment()
                        ->setHorizontal($position);
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

                //设置超链接
                foreach ($this->hyperlink as $key => $value){
                    $event->sheet->getDelegate()->setHyperlink($key,new Hyperlink(urlencode($value)));
                }

                //设置自动换行
                foreach ($this->wrapText as $key => $value){
                    $event->sheet->getDelegate()->getStyle($key)->getAlignment()->setWrapText($value);
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

    public function setHorizontal (array $position)
    {
        $this->horizontal = array_change_key_case($position, CASE_UPPER);
    }

    public function setHyperlink($hyperlink){
        $this->hyperlink = array_change_key_case($hyperlink, CASE_UPPER);
    }

    public function setWrapText($wrapText){
        $this->wrapText = array_change_key_case($wrapText, CASE_UPPER);
    }

    public function setMergeCells($mergeCells){
        $this->mergeCells = array_change_key_case($mergeCells, CASE_UPPER);
    }

    public function setVertical($vertical){
        $this->vertical = array_change_key_case($vertical, CASE_UPPER);
    }
}