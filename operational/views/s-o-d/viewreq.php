<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;

$this->title = 'View Changed CostCal';


?>

<h1><?= Html::encode($this->title) ?></h1>
<div class="change-allocation-product-form">
    <?php $form = ActiveForm::begin();         
        $sql = new yii\db\Query();
            $sql->select('sc.BiayaID,mb.Description as biayadesc,sc.Amount,sc.Remark,sc.Time,sc.IsManagementFee,sc.TipeTagihan,mb.TipeBiaya')
            ->from(['sc' => app\operational\models\CostCalcOutstanding::tableName()])
            //app\operational\models\SOCostCalc::tableName()])
            ->leftJoin(['mb' => \app\master\models\MasterBiaya::tableName()], 'sc.BiayaID = mb.BiayaID')
            ->where("sc.OfferingDID='$ofd'")
            ->orderBy('mb.SeqNo');
                
        $exec = $sql->all();
        
        foreach($exec as $index => $value) {
            echo Html::hiddenInput('biayaid[]',$value['BiayaID']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $sql,
            'sort' => false
        ]);
        $dataProvider->pagination->pageSize=100;
        
        $modelccd = \app\operational\models\CostCalcOutstanding::find()->where(['OfferingDID' => $ofd])->all();
    ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=>'{items}',
        'columns' => [
            [
               'class' => 'yii\grid\CheckboxColumn',
               'header' => 'M Fee',
               'headerOptions' => ['style'=>'text-align:center; width:15px;'],
               'contentOptions'=>['style'=>'text-align:center'],
               'checkboxOptions' => function ($modelccd, $key, $index, $column) {
                    
                    if($modelccd['IsManagementFee'] == 0)
                    {
                        return ['value' => $modelccd['BiayaID'],'checked' => false,'disabled' => true];
                    } else {
                        return ['value' => $modelccd['BiayaID'],'checked' => true,'disabled' => true];
                    }
                }
            ],
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style'=>'text-align:center; width:10px;'],
                'contentOptions'=>['style'=>'text-align:center']
            ],
            [
                'headerOptions' => ['style'=>'text-align:center; width:200px;'],
                'attribute' => 'biayadesc',
                'contentOptions'=>['style'=>'text-align:left'],
            ],
            [
                'headerOptions' => ['style'=>'text-align:center; width:200px;'],
                'contentOptions'=>['style'=>'text-align:center'],
                'attribute' => 'Value',
                'format' => 'raw',
                'value' => function($data){
                    return Html::textInput('Amount[]',$data['Amount'],['readonly' => true,'class'=>'form-control medbox display-block','style'=>'text-align:right']);
                }
            ],
        ],
    ]); ?>
 
    <?php ActiveForm::end(); ?>
     <?= Html::a('Back', ['s-o-d/create','soidh' => $idsoh], ['class' => 'btn btn-success']) ?>
</div>
