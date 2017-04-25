<?php

namespace app\payroll\models;

use Yii;

class CsvUpload extends \yii\base\Model
{
    public $file;
    public $periode;
    public function rules(){
        return [
            [['file'],'required'],
            [['file'],'file','extensions'=>'csv','maxSize'=>1024 * 1024 * 5],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'file' => 'File Absensi CSV',
        ];
    }
}
