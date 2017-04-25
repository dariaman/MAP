<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\SOSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'SO';
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
});   

$('#getSOid').click(function(){
    var row = $("#idgridsoh input[name=SOIDH]:checked").closest('tr');
    $('#allocationproducth-soidh').val(row.find("td:nth-child(2)").text());        
    $('#modalsohlookup').modal('hide');
});
        
        
SKRIPT;

$this->registerJs($script);


$this->title = 'SO';
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
        'tableOptions' =>['id' => 'idgridsoh','class'=>'table table-striped table-bordered'],
//        'pager' => [
//            'firstPageLabel' => 'First',
//            'lastPageLabel' => 'Last',
//        ],
         'columns' => [
            [
                    'label'=>'',
                    'format'=>'raw',
                    'value'=>function ($data) {
                       return Html::radio('SOIDH', false,['class'=>'of']);
                       
                    },
             ],
            [
                'contentOptions'=>['style'=>'width: 120px;'],
                'label' => 'SOIDH',
                'format' => 'raw',
                'value' => function($data){        
                    //return Html::a($data['SOIDH'], ['s-o-d/create', 'soidh'=>$data['SOIDH']]); 
                     return $data['SOIDH'];
                }
            ],
//            'SOIDH',
            'SODate',
            'OfferingIDH',
            'IDJobDesc',
            'Description',
            'CustomerID',
            'CustomerName',
            'PONo',
            'POdate',
            'TipeKontrak',
            'TipeBayar',
            'Status'
            

//       ['class' => 'yii\grid\ActionColumn'],
        ],
    ] 
)
 ;
    ?>
    <p>
        <?= Html::a('Select',NULL, ['class' => 'btn btn-success','id'=>'getSOid']) ?>
    </p>
       <?php // print_r($dataProvider);
//    die();
    ?>
     <?php Pjax::end(); ?> 
<!--     Html::a('select', ['index'], ['class' => 'btn btn-primary']); ?>-->

</div>
</div>