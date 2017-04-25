<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url; 
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\finance\models\AccountReceivable */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-receivable-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">AR No</td>
                            <td>: Auto Generate</td>
                        </tr>
                        <tr>
                            <td>Invoice No</td>
                            <td>: <?= $form->field($model, 'InvoiceNo')->textInput(['readonly' => true]) ?>
                                <?php echo Html::button('',
                                        ['value'=> Url::to('?r=lookup/lookupinvno'),
                                            'class'=>'loadMainContent glyphicon glyphicon-search ',
                                            'id'=>'btnlookupinvno']);
                                Modal::begin([
                                        'header'=>'Offering Header',
                                        'id' => 'modalinvnolookup',
                                        'size'=>'modal-lg'
                                    ]);
                                echo "<div id=modalinvnocontent></div>";
                                Modal::end();                
                                ?></td>
                        </tr>
                        <tr>
                            <td>Reference No</td>
                            <td>: <?= $form->field($model, 'RefNo')->textInput() ?></td>
                        </tr>
                        <tr>
                            <td>Payment Date</td>
                            <td><?= $form->field($model, 'PaymentDate')->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'Enter Date ...'],
                                    'pluginOptions' => ['autoclose'=>true,
                                                   'format' => 'yyyy-mm-dd',
                                                               'todayHighlight' => true]
                                    ]); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php

$script = <<<SKRIPT
        
$('#btnlookupinvno').click(function(){
    $('#modalinvnolookup').modal('show')
        .find('#modalinvnocontent')
        .load($(this).attr('value'));        
});        



SKRIPT;

$this->registerJs($script);

?>