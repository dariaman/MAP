<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\finance\models\BillingH;

$this->title = 'Invoice';

$globalFungsi = new \app\controllers\GlobalFunction();
$script = <<<SKRIPT
        
$("#print").on('click',function(){        
        var value = $("[name=selection_all]:checked");
        var arrayval = [];
        var loading = $('#loadingDiv');
        var flag = '';
        if(value.val() == 1)
        {        
            $('#print').attr('href','index.php?r=finance/billing-h/print-all');
        }else {
        
            $("input:checkbox:checked").each(function(){
                arrayval.push($(this).val());
            });

            var jsonString = JSON.stringify(arrayval);
            $('#print').attr('href','index.php?r=finance/billing-h/print-partial&idinv='+jsonString);
        }   
});
SKRIPT;

$this->registerJs($script);
?>
<div class="billing-h-index">

    <h1><center><?= Html::encode($this->title) ?></center></h1>
    
    <?php 
    
    $model = new BillingH();
    
    ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
               'class' => 'yii\grid\CheckboxColumn',
               'checkboxOptions' => function ($model, $key, $index, $column){
                    return ['value' => $model['InvoiceNo']];
                }
            ],
            [
               'header' => 'Invoice<br>No',
               'headerOptions' => ['style'=>'text-align:center'],
               'format' => 'raw',
               'value' => function($data){
                    return Html::a($data['InvoiceNo'],['billing-d/create','invno'=>$data['InvoiceNo']]);
                }
            ],
            [
                'header' => 'Invoice<br>Date',
                'headerOptions' => ['style'=>'text-align:center'],
                'contentOptions' => ['style'=>'text-align:center'],
                'value' => 'InvoiceDate'
            ],
            [
                'header' => 'Customer<br>Name',
                'headerOptions' => ['style'=>'text-align:center'],
                'contentOptions' => ['style'=>'text-align:center'],
                'value' => 'CusName'
            ],
            [
                'header' => 'Total<br>DPP',
                'headerOptions' => ['style'=>'text-align:center'],
                'contentOptions' => ['style'=>'text-align:center'],
                'value' => 'TotalDPP'
             ],
             [
                'header' => 'Total<br>Management Fee',
                'headerOptions' => ['style'=>'text-align:center'],
                'contentOptions' => ['style'=>'text-align:center'],
                'value' => 'TotalMFee'
             ],
             [
                'header' => 'Total<br>PPN',
                'headerOptions' => ['style'=>'text-align:center'],
                 'contentOptions' => ['style'=>'text-align:center'],
                'value' => 'TotalPPN'
             ],
             [
                'header' => 'Total<br>PPH23',
                'headerOptions' => ['style'=>'text-align:center'],
                 'contentOptions' => ['style'=>'text-align:center'],
                'value' => 'TotalPPH23'
             ],
             [
                'header' => 'Total<br>Invoice',
                'headerOptions' => ['style'=>'text-align:center'],
                 'contentOptions' => ['style'=>'text-align:center'],
                'value' => 'TotalInvoice'
             ],
             [
                 'header' => 'No<br>Faktur Pajak',
                 'headerOptions' => ['style'=>'text-align:center'],
                 'value' => 'NoFakturPajak'
             ],
//             [
//                 'header' => 'Status',
//                 'headerOptions' => ['style'=>'text-align:center'],
//                 'contentOptions' => ['style'=>'text-align:center'],
//                 'value' => function($data)
//                  {
//                        if($data['Status'] == 'C')
//                        {
//                            return 'Cancel';
//                        } else if ($data['Status'] == 'P')
//                        {
//                            return 'Paid';
//                        } else {
//                            return 'New';
//                        }
//                        
//                  }
//             ],
              [
                  'header' => 'Pengirim',
                  'format' => 'raw',
                  'headerOptions' => ['style' => 'text-align:center;'],
                  'contentOptions' => ['style' => 'text-align:center'],
                  'value' => function($data)
                   {
                        return $data['SendBy'];
                   }
              ],
              [
                  'header' => 'Tanggal Kirim',
                  'format' => 'raw',
                  'headerOptions' => ['style' => 'text-align:center;'],
                  'contentOptions' => ['style' => 'text-align:center'],
                  'value' => function($data)
                   {
                         return $data['SendDate'];
                   }
              ],
              [
                  'header' => 'Penerima',
                  'format' => 'raw',
                  'headerOptions' => ['style' => 'text-align:center;'],
                  'contentOptions' => ['style' => 'text-align:center'],
                  'value' => function($data)
                   {
                         return $data['ReceivedBy'];
                   }
              ],
              [
                  'header' => 'Tanggal Terima',
                  'format' => 'raw',
                  'headerOptions' => ['style' => 'text-align:center;'],
                  'contentOptions' => ['style' => 'text-align:center'],
                  'value' => function($data)
                   {
                         return $data['ReceivedDate'];
                   }
              ],
             [
                 'header' => 'Cancel<br>Date',
                 'headerOptions' => ['style'=>'text-align:center'],
                 'contentOptions' => ['style'=>'text-align:center'],
                 'value' => function($data)
                {
                    if($data['CancelDate'] == NULL)
                    {
                        return '-';
                    } else {
                        return date('Y-m-d',strtotime($data['CancelDate']));
                    }
                 
                }
             ],
             [
                 'header' => 'Cancel<br>Reason',
                 'headerOptions' => ['style'=>'text-align:center'],
                 'contentOptions' => ['style'=>'text-align:center'],
                 'value' => 'CancelReason'
             ],
             [
                  'header' => 'Tanda Terima<br>Billing',
                  'format' => 'raw',
                  'headerOptions' => ['style' => 'text-align:center;'],
                  'contentOptions' => ['style' => 'text-align:center'],
                  'value' => function($data)
                   {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                        ['tanda-terima-billing','invno' => $data['InvoiceNo']],['Title' => 'Input Tanda Terima']);
                   }
             ],        
        ],
    ]); ?>
    <div>
        <?= Html::a('Print Invoice', '', ['class' => 'btn btn-success','id' => 'print']); ?>
    </div>
</div>
