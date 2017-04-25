<?php

use yii\helpers\Html;
use kartik\grid\GridView;
 use yii\widgets\Pjax;



$this->title = 'Master Customer';

?>
<div class="data-pjax">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <?= $this->render('_searchcustomer', ['model' => $searchModel]); ?>
                </div>
                <?php Pjax::begin(['id' => 'PtlCommentsPjax']); ?>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions' =>['id' => 'idgridcustomer','class'=>'table table-striped table-bordered'],
                        'columns' => [
                            [
                                'label'=>'',
                                'format'=>'raw',
                                'value'=>function ($data) {
                                   return Html::radio('customerid', false, '');
                                },
                             ],
                            'CustomerID',
                            'CustomerName',
                            'City',
                            'ContactName',
                            'NPWP',
                        ],
                    ]); ?>
                </div>
                <?php Pjax::end();?>
            </div>
        </div>
        <div class="col-xs-12">
            <?= Html::a('Select',NULL,[ 'class' => 'btn btn-success','id'=>'select']); ?>
        </div>
    </div>   
</div>
<?php
$script = <<<SKRIPT
        
function setvalue(){
    
   var row = $("#idgridcustomer input[name=customerid]:checked").closest('tr');

    if (window.opener != null && !window.opener.closed){
        $('#soh-customerid',opener.document).val(row.find("td:nth-child(2)").text());
        $('#customername',opener.document).val(row.find("td:nth-child(3)").text());
        $('#id-sub-cus',opener.document).val(row.find("td:nth-child(2)").text());
        $('#subcustomername',opener.document).val(row.find("td:nth-child(3)").text());
    }
    window.close();
}
        
$('#select').click( setvalue );

   
SKRIPT;

$this->registerJs($script);

?> 