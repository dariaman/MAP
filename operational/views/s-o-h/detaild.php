<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\OfferingHdrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if($_GET['type'] == 'of')
{
   $this->title = 'Offering Detail'; 
} else {
   $this->title = 'Cost Calc Detail';
}


//$this->params['breadcrumbs'][] = $this->title;

$script = <<<SKRIPT
   
$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})
        
$('.ed').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
});

$('#addbtn').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
});
SKRIPT;

$this->registerJs($script);

?>
<div class="offering-hdr-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    
    if($_GET['type'] == 'of')
    {
        $query = app\operational\models\OfferingD::find()
            ->where("OfferingDID = '".$_GET['id']."'")
            ->orderBy(['OfferingDID'=>SORT_ASC]);
    } else {
        $query = app\operational\models\SOCostCalc::find()
            ->where("CostcalIDH = '".$_GET['id']."'")
            ->orderBy(['BiayaID'=>SORT_ASC,'CostcalDID'=>SORT_ASC]);
    }
    

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);
    
    ?>
    
    <?php 
    
    if($_GET['type'] == 'of')
    {
        echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label'=>'Offering Detail',
                'value' => 'OfferingDID'
            ],
            [
                'label'=>'Cost Cal ID',
                'value' => 'CostcalIDH'
            ],
            [
                'label'=>'Gaji Pokok',
                'value' => 'gP.Amount'
            ],
            [
                'label'=>'Area',
                'value' => 'area.Description'
            ], 
            [
                'label'=>'Class',
                'value' => 'class.ClassDesc'
            ] 
            
            //
        ],
    ]); 
    } else {
        
      echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Cost Calc Detail',
                'value' => 'CostcalDID'
            ],
            [
                'label'=>'Tipe Biaya',
                'value' => 'TipeBiaya'
            ],
            [
                'label'=>'Jenis Biaya',
                'value' => function($data)
                {
                    $biayadesc = \app\master\models\MasterBiaya::find()
                            ->select('Description')
                            ->where("BiayaID = '".$data['BiayaID']."'")
                            ->one();
                    
                    if($data['BiayaID'][0] == 'T')
                    {
                        $detail = "Tunjangan ".$biayadesc['Description'];
                        
                    } else {
                        $detail = "Potongan ".$biayadesc['Description'];
                        
                    }
                    return $detail;
                }
            ],
            [
                'label'=>'Jumlah',
                'value' => 'Amount'
            ],
            [
                'label'=>'Remark',
                'value' => 'Remark'
            ],
            [
                'label'=>'Aksi',
                'format' => 'raw',
                'value' => function($data){
                   return Html::a('Edit','./index.php?r=operational/s-o-h/upd&id='.$data['CostcalDID'],['class'=>'ed']);
                }
//                'method' => 'post',
            ]
            //
        ],
    ]);
        
    } ?>
    <p>
        <?= Html::a('Add','./index.php?r=operational/s-o-h/addcc&id='.$_GET['id'], ['class' => 'btn btn-success','id'=>'addbtn']) ?>
    </p>
    
</div>
