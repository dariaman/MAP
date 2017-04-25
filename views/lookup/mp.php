<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

 
?>

 <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
 <?php echo $this->render('_searchp', ['searchmodell' => $searchModell]); ?>

 <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' =>['id' => 'idgridprod','class'=>'table table-striped table-bordered'],
        'columns' => [
            [
                'format'=>'raw',
                'value'=>function ($data) {
                return Html::radio('ProductID', false,['value'=>$data['ProductID']]);
                 },
            ],
            [
                'label'=>'Product',
                'value'=>'ProductID',
            ],
            [ 
                'header'=>'Nama Product',
                'value' => 'Nama',
                'contentOptions'=>['style'=>'max-width: 1000px;']
            ],
            [ 
                'header'=>'Job Description',
                'value' => 'JobDesk',
                'contentOptions'=>['style'=>'max-width: 1000px;']
            ],
        ],
     ]);
           ?>
 <?php Pjax::end(); ?>

      <p>
          <?= Html::a('Select',NULL, ['class' => 'btn btn-success','id'=>'select']) ?>
      </p>
<?php
$script = <<<SKRIPT
function setvalue(){

    var row = $("#idgridprod input[name=ProductID]:checked").closest('tr');

    if (window.opener != null && !window.opener.closed){
        $('input[name=prod-id-payroll]',opener.document).val(row.find("td:nth-child(2)").text());
        $('#prod-name-payroll',opener.document).text(row.find("td:nth-child(3)").text());
        $('#prod-jobdesk-payroll',opener.document).text(row.find("td:nth-child(4)").text());
     }
     window.close();
 }

 $('#select').click( setvalue );
       
SKRIPT;

$this->registerJs($script);