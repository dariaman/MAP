<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

$this->title = 'Master Product';

$gridColumns = [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions' => ['style' => 'width: 25px;'],
                'header'=> 'No'
            ],
            [
                'contentOptions' => ['style' => 'width: 120px;'],
                'label' => 'ProductID',
                'value' => function($data) {
                    return $data['ProductID'];
            }
            ],
            [
                'header' => 'Nama Product',
                'value' => 'Nama',
                'contentOptions' => ['style' => 'max-width: 1000px;']
            ],
            [
                'label' => 'JobDesc',
                'value' => 'MJDesc',
            ],
            [
                'label' => 'Customer',
                'value' => 'CusName',
            ],       
            [
                'label' => 'AreaName',
                'value' => 'AreaName',
            ],
            [
                'header' => 'Gender',
                'value' => function($data) {
                    if ($data['Gender'] == 'P') {
                        return 'Perempuan';
                    } else {
                        return 'Laki-Laki';
                    }
                }
            ],
            [
                'label' => 'No KK',
                'value' => 'NoKK',
            ],
            [
                'label' => 'KTP',
                'value' => 'KTP',
            ],
            [
                'label' => 'SIM',
                'value' => 'SIM',
            ],
            [
                'label' => 'SIM Expired Date',
                'value' => 'SIMExpiredDate',
                'format' => ['DateTime', 'php:d-m-Y'],
            ],
            [
                'label' => 'StatusNikah',
                'value' => 'IDNikah',
            ],
            'Address',
            'City',
            'Zip',
            'Phone',
            'Mobile1',
            'Mobile2',
            [
                'label' => 'Bank Name',
                'value' => 'BankName',
            ],
            'BankAccNumber',
            [
                'label' => 'NPWP',
                'value' => 'NPWP',
            ],
            [
                'header' => 'Status<br>Product',
                'format' => 'raw',
                'value' => function($data)
                {
                    if ($data['Status'] == 'GS') {
                        return "<span class='label label-warning'>GS</span>";
                    } else if($data['Status'] == 'FIX'){
                        return "<span class='label label-success'>FIX</span>";
                    } else {
                        return '';
                    }
                }
            ],
            [
                'label' => 'Status',
                'format' => 'raw',
                'value' => function($data) {
                    if ($data['IsActive'] == 1) {
                        return "<span class='label label-success'>Active</span>";
                    } else {
                        return "<span class='label label-danger'>Not Active</span>";
                    }
                }
            ],
];

echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'fontAwesome' => true,
    // 'target'=>ExportMenu::TARGET_BLANK,
    'columnSelectorOptions'=>[
        'label' => 'Cols...',
    ],
    'dropdownOptions' => [
        'label' => 'Export All',
        'class' => 'btn btn-default'
    ],
    'clearBuffers' => true,
    // 'target' => ExportMenu::TARGET_SELF,
    'showConfirmAlert' => false,
    // 'showColumnSelector' => false,
    'exportConfig' => [
        ExportMenu::FORMAT_TEXT => false,
        ExportMenu::FORMAT_HTML => false,
        // ExportMenu::FORMAT_PDF => [
        //     'label' => Yii::t('kvexport', 'PDF'),
        //     // 'icon' =>  'floppy-disk',
        //     'iconOptions' => ['class' => 'text-danger'],
        //     'linkOptions' => [],
        //     'options' => ['title' => Yii::t('kvexport', 'Portable Document Format')],
        //     'alertMsg' => Yii::t('kvexport', 'The PDF export file will be generated for download.'),
        //     'mime' => 'application/pdf',
        //     'extension' => 'pdf',
        //     'writer' => 'PDF'
        // ],
    ],
    // 'filename' => 'exported-data_' . date('Y-m-d_H-i-s'),
]);

?>
<div class="masterproduct-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'autoXlFormat'=>true,
        // 'pjax' => true,
        'columns' => $gridColumns,
    ]);
    ?>
</div>
