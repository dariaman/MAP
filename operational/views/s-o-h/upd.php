<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\OfferingHdrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Edit Cost Calc Detail';
//$this->params['breadcrumbs'][] = $this->title;

$script = <<<SKRIPT
        window.onunload = refreshParent;
        function refreshParent() {
            window.close();
            window.opener.location.reload();
        }
SKRIPT;

$this->registerJs($script);

?>
<div class="offering-hdr-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    
        if($model->TipeBiaya[0] == "F")
        {
            $model->TipeBiaya = 'Fix';
        } else if ($model->TipeBiaya[0] == "T")
        {
            $model->TipeBiaya = "Tambahan";
        } else {
            $model->TipeBiaya = 'Non Fix';
        }
        
        if($model->BiayaID[0] == 'T')
        {
            $inis = 'Tunjangan';
        } else  if ($model->BiayaID[0] == 'P')
        {
            $inis = 'Potongan';
        } else {
            $inis = 'Asuransi';
        }
        
        $desc = \app\master\models\MasterBiaya::find()
                ->where(['BiayaID' => $model->BiayaID])
                ->one();
        
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label'=>'Tipe Biaya',
                'value'=> $model->TipeBiaya 
            ],
            [
                'label'=>'Jenis Biaya',
                'value'=> $inis." ".$desc['Description']
            ],
            'Amount:raw:Amount',
            'Remark:raw:Remark',
        ],
    ])?>
    <div class="offering-hdr-form">
        
        
        <?php $form = ActiveForm::begin(['action'=>'./index.php?r=operational/s-o-h/updcc&idcc='.$_GET['id'],'method' => 'post']); 
       
        ?>
        <input type="hidden" name="ccdid" value="<?= $_GET['id'];?>">
        <input type="hidden" name="ccidh" value="<?= $model->CostcalIDH;?>">
        <table class="table table-striped table-bordered">
           <tr>
                <td>Tipe Biaya</td>
                <td><?php echo Html::dropDownList('TipeBiaya', NULL, ['FIX'=> 'Fix','NFX'=>'Non Fix','TMB' => 'Tambahan'], ['prompt' => 'Select Tipe Biaya','class'=>'form-control', 'id'=>'searchdrop1']) ?></td>
            </tr>
            <tr>
                <td>Jenis Biaya</td>
                <td><?= Html::dropDownList('selecttype',NULL, ['P'=>'Potongan','T'=>'Tunjangan','A'=>'Asuransi'],['class'=>'form-control','id'=>'searchdrop1','prompt' => 'Select Jenis','onchange'=>'
                    $.post("index.php?r=operational/cos-cal-h/lists&id="+$(this).val(), function( data ) {
                      $( "select#searchdrop3" ).html( data );
                    });
                '])?>
                    <?= Html::dropDownList('jenis', NULL, [''], ['prompt' => '-','class'=>'form-control', 'id'=>'searchdrop3']) ?></td>
            </tr>
            <tr>
                <td>Amount</td>
                <td><?php
                     echo Html::textInput('Amount','',['id'=>'amount','class'=>'form-control']);
                ?>
                </td>
            </tr>
            <tr>
                <td>Is Percentage</td>
                <td><?php
                     echo Html::checkbox('percent',false,['id'=>'check']);
                ?></td>
            </tr>
            <tr>
                <td>Remark</td>
                <td><?php
                     echo Html::textInput('Remark','',['id'=>'remark','class'=>'form-control']);
                ?>
                </td>
            </tr>
        </table>
        <?php //print_r($model); die(); ?>
        <div class="form-group" style="margin-left:45%;">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
             <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
