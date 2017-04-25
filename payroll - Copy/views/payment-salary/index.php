<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\payroll\models\PaymentSalarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Salary';
$script = <<<SKRIPT
        
$("#close").on('click',function(){        
        var value = $("[name=selection_all]:checked");
        var arrayval = [];
        var loading = $('#loadingDiv');
        var flag = '';
        if(value.val() == 1)
        {        
//            $.get('index.php?r=payroll/payment-salary/slip-all',
//                { });
            //$('#close').attr('href','index.php?r=payroll/payment-salary/slip-all');
        window.open('./index.php?r=payroll/payment-salary/slip-all','Print Slip','location=no,scrollbars=yes')
        }else {
        
            $("input:checkbox:checked").each(function(){
                arrayval.push($(this).val());
            });

            var jsonString = JSON.stringify(arrayval);

//            $.get('index.php?r=payroll/payment-salary/slip-partial',
//                { idarr : jsonString } );
            window.open('./index.php?r=payroll/payment-salary/slip-partial&idarr='+jsonString,'Print Slip','location=no,scrollbars=yes')    
        }   
});
SKRIPT;

$this->registerJs($script);
?>
<div class="payment-salary-index">
    <div class="se-pre-con" style="display:none;" id="loadingDiv">
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'pjax' => false,
                        'columns' => [
                            [
                               'class' => 'yii\grid\CheckboxColumn',
                               'checkboxOptions' => function ($model, $key, $index, $column) {
                                    return ['value' => $model->PayrollGajiIDH];
                                }
                            ],
                            [
                                'header' => 'ID',
                                'format' => 'raw',
                                'value' => function($data)
                                {
                                    return Html::a($data['PayrollGajiIDH'],['payroll-gaji-d/create','pgidh' => $data['PayrollGajiIDH']]);
                                }
                            ],
                            'ProductID',
                            'bln',
                            'thn',
                            'CustomerID',
                             'AreaID',
                             'FixAmount',
                             'TunjanganAmount',
                             'PotonganAmount',
                             'PPH21',
                             'Total',
                //             [
                //                 'header' => 'Status',
                //                 'value' => function($data)
                //                {
                //                    if($data['Status'] == 'P')
                //                    {
                //                        return 'Paid';
                //                    } else if ($data['Status'] == 'C')
                //                    {
                //                        return 'Cancel';
                //                    } else {
                //                        return 'New';
                //                    }
                //                }
                //             ],
                //             [
                //                'label'=>'Process Payment',
                //                'format' => 'raw',
                //                'headerOptions' => ['style'=>'text-align:center'],
                //                'contentOptions'=>['style'=>'text-align:center'],
                //                'value' => function($data){
                //                 if($data['Status'] == 'P' or $data['Status'] == 'C')
                //                 {
                //                     return '-';
                //                 } else {
                //                     return Html::a('<span class="glyphicon glyphicon-usd"></span>',
                //                            ['create','pgidh' => $data['PayrollGajiIDH']]);
                //                 }
                //                },
                //             ]
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::a('Print Slip Gaji','',['class' => 'btn btn-success','id'=>'close','style' => 'margin-top:10px;']) ?>
            </div>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
</div>
