<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\master\models\MasterBankGroup;
use app\master\models\MasterJobDesc;
use app\master\models\MasterStatusPernikahan;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\master\models\Masterproduct */
/* @var $form yii\widgets\ActiveForm */
$script = <<<SKRIPT
        function val()
        {
            var j =document.getElementById("job").options[document.getElementById("job").selectedIndex].text;
            if( j == 'DRIVER')
                {
                    $( "#cimd" ).show("slow");
                    $( "#cim" ).show("slow");
                    $( "#simc" ).show("slow");
                    $( "#simb" ).show("slow");
                }
            else
                {
                  $( "#cimd" ).hide("slow");
                  $( "#cim" ).hide("slow");
                  $( "#simc" ).hide( "slow" );
                  $( "#simb" ).hide( "slow" );
                }
        }
    $( "#job" ).change( val);
         function cek()
        {
             var j =document.getElementById("job").options[document.getElementById("job").selectedIndex].text;
             var b=document.getElementById("simc").value;
             var c=document.getElementById("simb").value;
             var ktpdate=document.getElementById("tglktp").value;
        if(j == 'DRIVER'&& b=='')
        {
                alert('Tolong di isi SIM dan SIM ExpiredDate karena Product'+ j);
                return false;
        }
        else if(j == 'DRIVER'&& c=='')
        {
                alert('Tolong di isi SIM dan SIM ExpiredDate karena Product'+ j);
                return false;
        }
          else if(ktpdate=='')
        {
                alert('Tolong di isi KtpExpiredDate');
                return false;
        }
        }
        $( "#btn" ).click( cek );
SKRIPT;
$this->registerJs($script);

$masterjob = MasterJobDesc::find()->select('IDJobDesc,Description')->all();
$masterarea = app\master\models\MasterArea::find()->select('AreaID,Description')->all();
$masterstatusnikah = MasterStatusPernikahan::find()->select('IDStatusPernikahan,Description')->all();
$masterbank = MasterBankGroup::find()->select('mbg.BankGroupID,mbg.BankGroupName')
        ->from('MasterBankGroup mbg')
        ->all();

?>

<div class="masterproduct-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td>
                                ID Product
                            </td>
                            <td><b><?=(!$model->isNewRecord) ? $model->ProductID :'Auto Generate' ?></b></td>
                        </tr> 
                        <tr>
                            <td style="width: 200px;"> 
                                Nama 
                            </td>
                            <td>
                                <?php
                                echo $form->field($model, 'Nama')->textInput(['maxlength' => 100, 'style' => 'width:180px;'])->label(false);
                                ?>
                        </tr>
                        <tr>
                            <td> Job Desc  </td>
                            <td>
                                <?php
                                echo $form->field($model, 'IDJobDesc')->widget(Select2::className(),
                                        ['data' => ArrayHelper::map($masterjob, 'IDJobDesc', 'Description'),'hideSearch' =>  true,
                                            'options' => ['prompt' => 'Select Job Desc', 'style' => 'width:200px;', 'id' => 'job']])
                                        ->label(false);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Area  </td>
                            <td>
                                <?php
                                echo $form->field($model, 'AreaID')->widget(Select2::className(),
                                        ['data' => ArrayHelper::map($masterarea, 'AreaID', 'Description'),
                                            'options' => ['prompt' => 'Select Area', 'style' => 'width:200px;']])
                                        ->label(false);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Gender </td>
                            <td>
                                <?php
                                echo $form->field($model, 'Gender')->widget(Select2::className(),
                                    ['data' => ['L' => 'Laki-laki', 'P' => 'Perempuan'],'hideSearch' =>  true,
                                        'options' => ['prompt' => 'Select Gender', 'style' => 'width: 80px']])
                                        ->label(false);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> No KK </td>
                            <td>
                                <?php
                                echo $form->field($model, 'NoKK')->textInput(['maxlength' => 50, 'style' => 'width:180px;'])->label(false);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> KTP </td>
                            <td>
                                <?php
                                echo $form->field($model, 'KTP')->textInput(['maxlength' => 50, 'style' => 'width:180px;'])->label(false);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> KTP Expired date </td>
                            <td>
                                <?php
                                echo DatePicker::widget([
                                    'model' => $model,
                                    'attribute' => 'KTPExpiredDate',
                                    'options' => ['placeholder' => 'Enter Date...', 'style' => 'width:160px', 'id' => 'tglktp'],
                                    'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td id="cim"> SIM  </td>
                            <td>
                                <?php
                                echo $form->field($model, 'SIM')->textInput(['maxlength' => 50, 'style' => 'width:400px;', 'id' => 'simc'])->label(false);
                                ?>
                            </td>
                        </tr>
                        <tr id="cimd">
                            <td> SIM Expired date </td>
                            <td>
                                <?=
                                DatePicker::widget([
                                    'model' => $model,
                                    'attribute' => 'SIMExpiredDate',
                                    'options' => ['placeholder' => 'Enter Date...', 'style' => 'width:160px', 'id' => 'simb'],
                                    'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Status Nikah</td>
                            <td>
                                <?= $form->field($model, 'IDStatusNikah')->widget(Select2::className(),['data' => ArrayHelper::map($masterstatusnikah, 'IDStatusPernikahan', 'IDStatusPernikahan'),'options' => ['prompt' => 'Select nikah', 'style' => 'width:200px;']])->label(FALSE); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Address </td>
                            <td>
                                <?= $form->field($model, 'Address')->textarea(['maxlength' => 255, 'style' => 'width:400px;', "rows" => 2])->label('Address')->label(false) ?>
                            </td>
                        </tr>
                        <tr>
                            <td> City </td>
                            <td>
                                <?= $form->field($model, 'City')->textInput(['maxlength' => 100, 'style' => 'width:400px;'])->label(false)?>
                            </td>
                        </tr>
                        <tr>
                            <td> Zip</td>
                            <td>
                                <?= $form->field($model, 'Zip')->textInput(['maxlength' => 5, 'style' => 'width:100px;'])->label(false) ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Phone </td>
                            <td>
                                <?= $form->field($model, 'Phone')->textInput(['maxlength' => 15, 'style' => 'width:400px;'])->label(false) ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Mobile1 </td>
                            <td>
                                <?= $form->field($model, 'Mobile1')->textInput(['maxlength' => 15, 'style' => 'width:400px;'])->label(false) ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Mobile2</td>
                            <td>
                                <?= $form->field($model, 'Mobile2')->textInput(['maxlength' => 15, 'style' => 'width:400px;'])->label(false) ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Bank Name</td>
                            <td>
                                <?=
                                $form->field($model, 'BankID')->widget(Select2::classname(), ['data' => ArrayHelper::map($masterbank, 'BankGroupID', 'BankGroupName'),
                                    'options' => ['placeholder' => 'Select BankName ...', 'style' => 'width:200px;'],])->label(false);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> BankAccNumber </td>
                            <td>
                                <?= $form->field($model, 'BankAccNumber')->textInput(['maxlength' => 20, 'style' => 'width:400px;'])->label(false) ?>
                            </td>
                        </tr>
                        <tr>
                            <td> NPWP </td>
                            <td>
                                <?php
                                echo $form->field($model, 'NPWP')->textInput(['maxlength' => 20, 'style' => 'width:180px;'])->label(false)  ;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Class </td>
                            <td>
                                <?= $form->field($model, 'Class')->widget(Select2::className(),['data' => ['A' => 'A', 'B' => 'B'],'hideSearch' => true,'options' => ['prompt' => 'Select Class']])->label('Class')->label(false); ?>
                            </td>
                        </tr>
                        <?php
                        if (!$model->isNewRecord) {
                            echo '<tr><td style="padding-right:20px;padding-bottom:20px;">Status</td>';
                            echo '<td style="padding-right:20px;padding-bottom:5px;">';
                            echo $form->field($model, 'IsActive')->checkbox();
                            echo '</td></tr>';
                        }
                        echo '</table>';
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', ['master-product/index'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    
    
    
    
</div>
