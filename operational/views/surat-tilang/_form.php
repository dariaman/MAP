<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\modal;
use bootui\datetimepicker\Datepicker;
use app\master\models\Masterproduct;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\operational\models\SuratTilang */
/* @var $form yii\widgets\ActiveForm */
?>
<?php Modal::begin([
             'header'=>'<h4>Vlookup</h4>',
             'id'=> 'modal',
             'size'=>'modal-lg',
         ]);
         echo"<div id='modalproduk'></div>";
         modal::end();
         
         ?>
<?php

?>

<div class="surat-tilang-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--<?s $form->field($model, 'ID')->textInput() ?>-->

    <!--<? $form->field($model, 'IDpegawai')->textInput() ?>-->
    <?php
    $p = Masterproduct::find()->where(['ProductID'=>$model->ProductID])->one();
    $nama = $p['Nama'];
    ?>
    <?='<input type=hidden name=idp id=a value= >'; ?>
     <table class="table table-striped table-bordered"> 
         <tr> 
        <td class="medlength"> Product ID </td>
        <td>
      <?= $form->field($model, 'ProductID')->textInput(['disabled'=>true,'name'=>'pe','id'=>'b','class'=>'form-control medbox'])->label('Product') ?>
        </td>
    </tr>
    <tr > 
        <td class="medlength"> Product Name </td>
        <td>
      <?= Html::textInput('Nama',$nama,['disabled'=>true,'name'=>'pe','id'=>'c','class'=>'form-control medbox']) ?>
            <?= Html::button('...', ['value'=>Url::to('index.php?r=operational/surat-tilang/pro'),'class' => 'btn btn-success','id'=>'modalpgw']);?>
            </td>
    </tr>    <tr> 
        <td class="medlength"> Description </td>
        <td>
    <?= $form->field($model, 'Description')->textarea(['style'=>"width:300px","rows"=>2,'maxlength'=>100]) ?>
        </td>
    </tr>

    <?php
//     $amt = Yii::$app->db->createCommand("select Amount from master_gajipokok where ID = ".$idgap."and seqID = ".$idseq)->queryScalar();
     ?>
   
    <tr> 
        <td class="medlength"> Tgl Tilang</td>
        <td>
     <?= Datepicker::widget([
                'name' => 'TglTilang',
                'options' => ['class' => 'form-control','style'=>"width:180px"],
                'addon' => ['prepend' => 'Tanggal Tilang'],
                'format' => 'YYYY-MM-DD',
            ]); ?>
  </td>
    </tr>
     </table>

    <!--<? $form->field($model, 'usercrt')->textInput() ?>-->

    <!--<? $form->field($model, 'datecrt')->textInput() ?>-->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
    $script = <<<SKRIPT

$(function(){
$('#modalpgw').click(function() {
	$('#modal').modal('show')
		.find('#modalproduk')
		.load($(this).attr('value'));

	})
        });

SKRIPT;

$this->registerJs($script);
?>
</div>
