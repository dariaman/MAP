<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\OfferingHdrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'S O Detail';
//$this->params['breadcrumbs'][] = $this->title;

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})
        
$('.sodbutton').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=1024,height=600,scrollbars=yes,location=no");
});     
SKRIPT;

$this->registerJs($script);

?>
<div class="offering-hdr-index">

    <h1><?= Html::encode($this->title) ?></h1>
 
    <?php
    
    $query = app\operational\models\SOD::find()
            ->where("SOIDH = '".$_GET['id']."'")
            ->orderBy(['SODID'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);
    
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'columns' => [
            [
                'label'=>'SO ID Detail',
                'format' => 'raw',
                'value'=>'SODID'
            ],
            [
                'label' => 'SO ID Header',
                'value' => 'SOIDH'
            ],
            [
                'label'=>'Cost Cal Header',
                'format' => 'raw',
                'value'=>function($data)
                {
                    return Html::a($data['CostcalIDH'],'./index.php?r=operational/offering-h/detailcc&id='.$data['CostcalIDH'],['class'=>'sodbutton']);
                }
            ],
            [
                'label' => 'Area',
                'value' => 'area.Description'
            ],
            [
                'label' => 'Quantity',
                'value' => 'Qty'
            ],
            [
                'label' => 'Period From',
                'value' => 'PeriodFrom'
            ],
            [
                'label' => 'Period To',
                'value' => 'PeriodTo'
            ],
            [
                'label' => 'Status',
                'value' => 'Status'
            ]
            

//       ['class' => 'yii\grid\ActionColumn'],
        ],
    ] 
)
 ;
    ?>
    
    
</div>
