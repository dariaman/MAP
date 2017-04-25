<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;


//$this->title = 'Cost Cal';

?>

<div class="offering-h-index" style="overflow:auto;">
   
    <!--<h1><?= Html::encode($this->title) ?></h1>-->
     <?php Pjax::begin(['id' => 'lookupcoscalPjax']); ?>
    <?php  echo $this->render('_searchcoscal', 
                    ['model' => $searchModel]
            ); 

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' =>['id' => 'idgridcostcal','class'=>'table table-striped table-bordered'],
        'columns' => [
            [
                    'label'=>'',
                    'format'=>'raw',
                    'value'=>function ($data) {
                       return Html::radio('CostcalIDx', false, '');
                    },
             ],
            'CostcalIDH',
            'CostcalDate',
            'JobDescID',
            'JobDescription',
            'DateCrt',
        ],
    ]); ?>
    
</div>

<?php Pjax::end(); 
echo Html::a('Select',NULL,[ 'class' => 'btn btn-success','id'=>'ambildatacoscal']); 
        
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#lookupcoscalPjax')
})
        
$('#ambildatacoscal').click(function(){
        var row = $("#idgridcostcal input[name=CostcalIDx]:checked").closest('tr');
        
        $('#offeringd-costcalidh').val(row.find("td:nth-child(2)").text());
        $('#offeringd-costcalidh').trigger('change');
//        $('#ttgl').val(row.find("td:nth-child(3)").text());
//        $('#jdc').val(row.find("td:nth-child(6)").text()) ;
//    alert(tds.text());
    $('#modalcostcalculationlookup').modal('hide');
});        


SKRIPT;

$this->registerJs($script);



?> 