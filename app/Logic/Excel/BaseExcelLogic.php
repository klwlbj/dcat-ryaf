<?php

namespace App\Logic\Excel;

use App\Logic\BaseLogic;
use App\Library\Excel\ExportData;
use Maatwebsite\Excel\Facades\Excel;

class BaseExcelLogic extends BaseLogic
{
    protected $columnNameArr = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    protected $column;
    protected $row;
    protected $wrapText;

    /**获取列名
     * @param $columnIndex
     * @return string
     */
    public function getColumnName($columnIndex): string
    {
        $count = count($this->columnNameArr);
        $group = intval(($columnIndex - 1) / count($this->columnNameArr));
        $index = ($columnIndex - 1) - ($count * $group);

        return (empty($group) ? '' : $this->columnNameArr[$group - 1]) . $this->columnNameArr[$index];
    }

    /**导出
     * @param $exportData
     * @param $fileName
     * @param $type
     * @param array $config
     * @param string $exportPath
     * @return bool|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export($exportData, $fileName, $type = 'data', $config = [])
    {
        switch ($type) {
            case 'data':
                $excel = new ExportData($exportData);
                break;
            default:
                $excel = new ExportData($exportData);
                break;
        }
        foreach ($config as $key => $value) {
            switch ($key) {
                case 'column_width': #列宽
                    $excel->setColumnWidth($value);
                    break;
                case 'row_height': #行宽
                    $excel->setRowHeight($value);
                    break;
                case 'font_size': #字体大小
                    $excel->setFont($value);
                    break;
                case 'bold': #加粗
                    $excel->setBold($value);
                    break;
                case 'background': #背景色
                    $excel->setBackground($value);
                    break;
                case 'horizontal': #水平居中
                    $excel->setHorizontal($value);
                    break;
                case 'vertical': #垂直居中
                    $excel->setVertical($value);
                    break;
                case 'hyperlink': #超链接
                    $excel->setHyperlink($value);
                    break;
                case 'wrap_text': #自动换行
                    $excel->setWrapText($value);
                    break;
                case 'merge_cells': #合并单元格
                    $excel->setMergeCells($value);
                    break;
            }
        }

        return Excel::download($excel, $fileName);
    }
}
