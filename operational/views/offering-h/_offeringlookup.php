<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

?>

<div class="offering-h-index" style="overflow:auto;">
   
    <!--<h1><?= Html::encode($this->title) ?></h1>-->
     <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' =>['id' => 'idgridoffering','class'=>'table table-striped table-bordered'],
        'columns' => [
            [
                    'label'=>'',
                    'format'=>'raw',
                    'value'=>function ($data) {
                       return Html::radio('offeringid', false, '');
                    },
             ],
            'OfferingIDH',
            'OfferingDate',
            'NoSurat',
            'IDJobDesc',
            'JobDesc',
            'Status',
        ],
    ]); ?>
    
</div>

<?php Pjax::end(); 
echo Html::a('Select',NULL,[ 'class' => 'btn btn-success','id'=>'ambildatacoscal']); 
        
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#lookupofferingPjax')
})

SKRIPT;

$this->registerJs($script);



?> 