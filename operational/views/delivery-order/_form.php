<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model app\operational\models\DeliveryOrder */
/* @var $form yii\widgets\ActiveForm */
$script = <<<SKRIPT
        $('#btnlookupsod').click(function(){
        $('#modalsodlookup').modal('show')
            .find('#modalsodcontent')
            .load($(this).attr('value'));        
        });
            
        $('#btnlookupgr').click(function(){
        $('#modalgridlookup').modal('show')
            .find('#modalgridcontent')
            .load($(this).attr('value'));        
        });
SKRIPT;

$this->registerJs($script);       
?>

<div class="delivery-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <table class="table table-striped table-bordered">
        <tr>
            <td style="width:150px;">Delivery Order ID</td>
            <td>: Auto Generate</td>
        </tr>
        <tr>
            <td>SO Detail</td>
            <td>: <?= $form->field($model, 'SODID')->textInput(['readonly' => true]) ?>
            <?= Html::button('',
                                ['value'=> Url::to('?r=lookup/lookupmodalsoddo'),
                                    'class'=>'glyphicon glyphicon-search',
                                    'id'=>'btnlookupsod']);
                        Modal::begin([
                                'header'=>'SO Detail',
                                'id' => 'modalsodlookup',
                                'size'=>'modal-lg'
                            ]);
                        echo "<div id=modalsodcontent></div>";
                        Modal::end();
                    ?></td>
        </tr>
        <tr>
            <td>Customer Name</td>
            <td>: <?= Html::textInput('CusName',NULL,['readonly' => true, 'class' => 'form-control medbox']); ?></td>
        </tr>
        <tr>
            <td>Qty</td>
            <td>: <?= $form->field($model, 'Qty')->textInput() ?></td>
        </tr>
        <tr>
            <td>Delivery Order Date</td>
            <td><?= $form->field($model, 'DODate')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Enter Date ...'],
                    'pluginOptions' => ['autoclose'=>true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true]
                ]); ?></td>
        </tr>
        <tr>
            <td>Goods Receive ID</td>
            <td>: <?= $form->field($model, 'GRID')->textInput(['readonly' => true]) ?>
            <?= Html::button('',
                                ['value'=> Url::to('?r=lookup/lookupmodalgrid'),
                                    'class'=>'glyphicon glyphicon-search',
                                    'id'=>'btnlookupgr']);
                        Modal::begin([
                                'header'=>'Goods Receive ID',
                                'id' => 'modalgridlookup',
                                'size'=>'modal-lg'
                            ]);
                        echo "<div id=modalgridcontent></div>";
                        Modal::end();
                    ?></td>
        </tr>
    </table>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
