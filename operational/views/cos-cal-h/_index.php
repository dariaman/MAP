<?php

use kartik\grid\GridView;

?>

<div class="cos-cal-d-index">
    <br>
    <?php 
    $model = new app\operational\models\CosCalD();
    $query = $model::find()
            ->select('cd.CostcalDID,cd.CostcalIDH,mb.Tipe as Type,cd.BiayaID,mb.Description,cd.Amount,cd.Remark,cd.IsManagementFee')
            ->from(['cd' => app\operational\models\CosCalD::tableName()])
            ->leftJoin(['mb' => app\master\models\MasterBiaya::tableName()],'mb.BiayaID=cd.BiayaID')
            ->where('cd.CostcalIDH=\''.$CDH.'\'' )
            ->orderBy('mb.Tipe,cd.CostcalDID');
        
        $dataProvider = new \yii\data\ActiveDataProvider ([
            'query' => $query
        ]);
        
    $dataProvider->pagination->pageSize=100;

    $modelcch = app\operational\models\CosCalH::find()->where(['CostcalIDH'=> $CDH])->one();

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=>"{items}",
        'pjax' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\CheckboxColumn',
                'header' => 'MFee',
                'checkboxOptions' => function ($model)  {
                    if($model->BiayaID == 'M1000001' OR $model->BiayaID == 'M5000001') {
                        return ['value' => $model->CostcalDID,'checked' => false,'disabled' =>true];
                    } else  if($model->IsManagementFee == 0) {
                        return ['value' => $model->CostcalDID,'checked' => false];
                    } else {
                        return ['value' => $model->CostcalDID,'checked' => true];
                    }
                }
            ],
            [
                'label'=>'ID Coscal Detail',
                'value' => 'CostcalDID'
            ],            
            [
                'label'=>'Tipe Biaya',
                'value' => function($data){
                    if($data['Type'] == '1FX'){             return 'Fix';
                    } else if($data['Type'] == '2TMB'){     return 'Tambahan';
                    } else if($data['Type'] == '3NFIX'){    return 'Non Fix';
                    } else if($data['Type'] == 'LMB'){      return 'Non Fix';
                    }else if($data['Type'] == 'MGM1'){      return 'Fix';
                    }else if($data['Type'] == 'MGM2'){      return 'Non Fix';
                    }
                },
            ],
            [
                'label'=>'Description',
                'value' => 'Description',
            ],
            [
                'attribute'=>'Amount',
                'format'=>'Currency',
            ],
            [
                'label'=>'Description',
                'attribute'=>'Remark',
            ],
        ],
    ]);
    ?>
    
</div>
