<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\OfferingHdrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cost Calc Detail';
//$this->params['breadcrumbs'][] = $this->title;

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);

?>
<div class="offering-hdr-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    
    $query = app\operational\models\CosCalD::find()
            ->where("CostcalIDH = '".$_GET['id']."'")
            ->orderBy(['BiayaID'=>SORT_ASC,'CostcalDID'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);
    
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
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
            ]
            
            //
        ],
    ]); ?>
    
    
</div>
