<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\payroll\models\PaymentSalarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Salary';
//$script = <<<SKRIPT
//
//$(document).on('submit', 'form[data-pjax]', function(event) {
//  $.pjax.submit(event, '#PtlCommentsPjax')
//})
//
//SKRIPT;
//
//$this->registerJs($script);
//
            $gridColumns = [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'contentOptions' => ['style' => 'width: 25px;'],
                            'header'=> 'No'
                        ],
//                        'columns' => [
//                            [
//                                'class' => 'yii\grid\SerialColumn',
//                                'contentOptions' => ['style' => 'width: 25px;'],
//                                'header'=> 'No'
//                            ],
//                            [
//                               'class' => 'kartik\grid\CheckboxColumn',
//                               'contentOptions' => ['style' => 'width: 25px;'],
//                               'checkboxOptions' => function ($model, $key, $index, $column) {
//                                    return ['value' => $model->ProductID];
//                                }
//                            ],
                            [
                                'header'=>'Product ID',
                                'value' =>'ProductID',
                                'headerOptions' => ['style' => 'text-align:center'],
                            ],
                            [
                                'header'=>'Nama',
                                'value' =>'Nama',
                                'headerOptions' => ['style' => 'text-align:center'],
                            ],
                            [
                                'header'=>'Job Description',
                                'value' =>'NamaJob',
                                'headerOptions' => ['style' => 'text-align:center']
                            ],
                            [
                                'label' => 'FixAmount',
                                'value' => 'FixAmount',
                                'format' => ['decimal', 2],
                                'contentOptions' => ['Align' => 'right','style' => 'width: 130px;'],
                                'headerOptions' => ['style' => 'text-align:center']
                            ],
                            [
                                'label' => 'PotonganAmount',
                                'value' => 'PotonganAmount',
                                'format' => ['decimal', 2],
                                'contentOptions' => ['Align' => 'right','style' => 'width: 130px;'],
                                'headerOptions' => ['style' => 'text-align:center']
                            ],
                            [
                                'label' => 'PPH21',
                                'value' => 'PPH21',
                                'format' => ['decimal', 2],
                                'contentOptions' => ['Align' => 'right','style' => 'width: 130px;'],
                                'headerOptions' => ['style' => 'text-align:center']
                            ],
                            [
                                'label' => 'Total',
                                'value' => 'Total',
                                'format' => ['decimal', 2],
                                'contentOptions' => ['Align' => 'right','style' => 'width: 130px;'],
                                'headerOptions' => ['style' => 'text-align:center']
                            ],
                        ];
            ?>
<?= $this->render('_searchSalary', ['model' => $searchModel]); ?>
<?php echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'target'=>ExportMenu::TARGET_BLANK,
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
<div class="payment-salary-index">
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'autoXlFormat'=>true,
        // 'pjax' => true,
        'columns' => $gridColumns,
    ]);
    ?>
</div>