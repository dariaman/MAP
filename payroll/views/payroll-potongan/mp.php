<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


 
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
                            'label'=>'NIK',
                            'value'=>'NIK',
                        ],
           
                        [ 
                            'header'=>'Nama Product',
                            'value' => 'Nama',
                            'contentOptions'=>['style'=>'max-width: 1000px;']
                 
	                ],
                     ],
                                     
           
     ]);
           ?>
 <?php Pjax::end(); ?>

      <p>
          <?= Html::a('Select',NULL, ['class' => 'btn btn-success','id'=>'getpro']) ?>
      </p>
<?php
$script = <<<SKRIPT
   
    $('#getpro').click(function(){
        var row = $("#idgridprod input[name=ProductID]:checked").closest('tr');
        $('#payrollpotongan-productid').val(row.find("td:nth-child(2)").text());
        $('#modalprodlookup').modal('hide');
    });
       

SKRIPT;

$this->registerJs($script);