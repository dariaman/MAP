<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\payroll\models\PaymentSalarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Salary';

$gridColumns = [
        [
            'class' => 'kartik\grid\SerialColumn',
            'contentOptions' => ['style' => 'width: 25px;'],
            'header'=> 'No'
        ],
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

<div class="payment-salary-index">
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'autoXlFormat'=>true,
        'panel'=>[
            'type'=>'primary',
            'heading'=>'Products'
        ],
        // 'pjax' => true,
        'columns' => $gridColumns,
    ]);
    ?>
</div>