<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\SOSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Product Detail';
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
});   

$('#getProdid').click(function(){
    var row = $("#idgridprod input[name=ProductID]:checked").closest('tr');
    $('#goliveproduct-productid').val(row.find("td:nth-child(2)").text());
    $('#nameprod').val(row.find("td:nth-child(4)").text());
    $('#modalprodlookup').modal('hide');
});
        
        
SKRIPT;

$this->registerJs($script);
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="se-pre-con" style="display:none;" id="loadingDiv">
   
</div>
<div class="so-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // print_r('fgh');
//        die(); // echo $this->render('_search', ['model' => $searchModel]); ?>
      <?php Pjax::begin(['id'=>'PtlCommentsPjax']); 
        echo $this->render('_searchsod', ['model' => $searchModel]);
        
        
        ?>
    
 
<div class="output" style="height: 500px; overflow: auto;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' =>['id' => 'idgridprod','class'=>'table table-striped table-bordered'],
//        'pager' => [
//            'firstPageLabel' => 'First',
//            'lastPageLabel' => 'Last',
//        ],
         'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                    'label'=>'',
                    'format'=>'raw',
                    'value'=>function ($data) {
                       return Html::radio('ProductID', false);
                       
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
//                 'options' => ['style' => 'max-width:2000px;'],
//                'header'=>'<span style:width:2000px;>Nama</span>', 
                 'header'=>'Nama Product',
                 'value' => 'Nama',
                  'contentOptions'=>['style'=>'max-width: 1000px;'] ,
                  'headerOptions'=>['style'=>'width: 1050px'],
//                 'label' => 'Nama',
//                  'contentOptions' => ['style' => 'width:200px;'],
//                    'value'=>'Nama',    
            ],
          
             [
                'label'=>'JobDesc',
                'value'=>'MJDesc',
//              'value'=>'IDJobDesc',
            ],
           
            'Gender',
           
              [
                'label'=>'KTP',
                'value'=>'KTP',
//                 'value'=>'IDJobDesc',
            ],
            [
                'header'=>'KTP<br>Expired Date',
                'value'=> 'KTPExpiredDate',
                'format'=>['DateTime','php:d-m-Y'],
            ],
            // 'KTPExpireddate',
              [
                'label'=>'SIM',
                'value'=>'SIM',
//                 'value'=>'IDJobDesc',
            ],
            [
                 'label'=>'SIM Expired Date',
                'value'=> 'SIMExpiredDate',
                'format'=>['DateTime','php:d-m-Y'],
            ],
            // 'simexpireddate',
            
            [
                'label'=>'StatusNikah',
                'value'=>'MSD',
//                'value'=>'IDStatusNikah',
            ],
             'Address',
             'City',
        ],
    ] 
)
 ;
    ?>
    <p>
        <?= Html::a('Select',NULL, ['class' => 'btn btn-success','id'=>'getProdid']) ?>
    </p>
       <?php // print_r($dataProvider);
//    die();
    ?>
     <?php Pjax::end(); ?> 
<!--     Html::a('select', ['index'], ['class' => 'btn btn-primary']); ?>-->

</div>
</div>