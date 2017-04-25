<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$script = <<<SKRIPT

$("#close").on('click',function(){
        
        var arrayval = [];
        var loading = $('#loadingDiv');

        $("input:checkbox:checked").each(function(){
            arrayval.push($(this).val());
        });

//      alert(arrayval);

        var jsonString = JSON.stringify(arrayval);
        
        $(document)
        .ajaxStart(function () {
          loading.show();
        })

        $.get('index.php?r=operational/cos-cal-d/management-fee',
            { idarr : jsonString  , idcch : '$CDH' }, 
                function(data)
                    {

                    }
             );

        $(document).ajaxStop(function () {
            loading.hide();
            window.location.reload();
        });
           
});
SKRIPT;

$this->registerJs($script);
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
                'header' => 'M Fee',
                'checkboxOptions' => function ($model) use ($dataProvider) {
                    if($model->BiayaID == 'M1000001' OR $model->BiayaID == 'M5000001') {
                        return ['value' => $model->CostcalDID,'checked' => false,'disabled' =>true];
                    } else  if($model->IsManagementFee == 0) {
                        return ['value' => $model->CostcalDID,'checked' => false];
                    } else {
                        return ['value' => $model->CostcalDID,'checked' => true];
                    }
                }
            ],
//            [
//                'label'=>'ID Coscal Detail',
//                'value' => 'CostcalDID'
//            ],            
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
                'class' => 'kartik\grid\EditableColumn',
                'attribute'=>'Amount',
                'readonly' =>function() use($SODID){
                    if($SODID==''){ return false;}
                    else{ return true; }
                },
                'editableOptions'=> function () {
                    return [
                        'formOptions' => ['action' => ['cos-cal-d/change-amount-coscald']],
                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    ];
                },
                'hAlign'=>'right', 
                'vAlign'=>'middle',
                'width'=>'100px',
                'format'=>['decimal', 2],
            ],
            [
                'label'=>'Description',
                'attribute'=>'Remark',
            ],
            [
                'label'=>'Delete',
                'format' => 'raw',
                'contentOptions'=>['style'=>'text-align:center'],
                'value' => function($data) use ($modelcch){
                    if($modelcch->SODID == '') {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                        ['delcon','did' => $data['CostcalDID'],'idh' => $data['CostcalIDH']],
                        ['onclick'=>'return confirm("Apakah CosCal Detail dengan ID = \"'.$data['CostcalDID'].'\" akan dihapus ?")'
                            ]);
                    } else { return '-'; }
                },
            ],
        ],
    ]);
    ?>
    
    <?php
    
        $findCCH = app\operational\models\CosCalH::find()->where(['CostcalIDH' => $CDH])->one();
        $findccd = app\operational\models\CosCalD::find()->where(['BiayaID' => 'M1000001','CostcalIDH' => $CDH])->one();
        
        if($findCCH['SODID'] == NULL AND $dataProvider->getTotalCount() != 0 AND count($findccd) != 0) {
            echo Html::button('Calculate Management Fee',['class' => 'btn btn-success','id'=>'close']);
        } ?>
    
</div>
