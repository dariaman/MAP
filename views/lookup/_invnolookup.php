<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
//use yii\widgets\ActiveForm;

?>

<div class="offering-h-index" style="overflow:auto;">
   
    <!--<h1><?= Html::encode($this->title) ?></h1>-->
     <?php   echo $this->render('_searchinvnolookup', ['model' => $searchModel]);?>
    
<div class="offering-h-search">
    
<?php Pjax::begin(['id' => 'lookupinvnoPjax']);?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' =>['id' => 'idgridoffering','class'=>'table table-striped table-bordered'],
        'columns' => [
            [
                'label'=>'',
                'format'=>'raw',
                'value'=>function ($data) {
                   return Html::radio('InvoiceNo', false, '');
                },
             ],
            'InvoiceNo',
            [
              'label' =>'Invoice Date',
              'value' => function($data)
                {                    
                    return date('Y-m-d',strtotime($data['InvoiceDate']));
                }
            ],
            'TotalDPP',
            'TotalMFee',
            'TotalPPN',
            'TotalInvoice',
            'NoFakturPajak',
            'Status',
        ],
    ]); ?>
    
</div>

<?php Pjax::end(); 
echo Html::a('Select',NULL,[ 'class' => 'btn btn-success','id'=>'ambilIDinvno']); 
        
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
    $.pjax.submit(event, '#lookupinvnoPjax')
});
        
$('#ambilIDinvno').click(function(){
    var row = $("#idgridoffering input[name=InvoiceNo]:checked").closest('tr');
    $('#accountreceivable-invoiceno').val(row.find("td:nth-child(2)").text());
        
    $('#modalinvnolookup').modal('hide');
});

SKRIPT;

$this->registerJs($script);

?> 