<?php

namespace App\Logic\Word;

use App\Logic\BaseLogic;

class BaseWordLogic extends BaseLogic
{
    protected function download($phpWord,$name){
        $file = $name . '.docx';
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $OBJETWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $OBJETWriter->save("php://output");
    }
}
