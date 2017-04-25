<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use kartik\widgets\Select2;

$idCP = Yii::$app->request->get('id', 'xxx');
$tesabsen = app\master\models\JenisTes::find()
                ->select('count(nt.IDJenisTes)')
                ->from('JenisTes jt')
                ->Join('LEFT JOIN', 'NilaiTes nt', "nt.IDJenisTes=jt.IDJenisTes and nt.CalonProductID='$idCP'")
                ->where('nt.CalonProductID is null')->all();
?>
<?php
        $form = ActiveForm::begin();

        $masterjob = \app\master\models\MasterJobDesc::find()->select('IDJobDesc,Description')->all();
        $masterarea = \app\master\models\MasterArea::find()->select('AreaID,Description')->all();
        $masterstatusnikah = app\master\models\MasterStatuspernikahan::find()->select('IDStatusPernikahan,Description')->all();
        $masterbank = \app\master\models\MasterBankGroup::find()->select('BankGroupID,BankGroupName')->all();
?>
<div class="master-calon-product-form">
    <div class="row">
        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= 'Add Calon Product' ?></h1>
                </div>
                <div class="box-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td>Calon Product ID</td>
                        <td>
                            <?php
                            if (!$model->isNewRecord) {
                                echo $form->field($model, 'CalonProductID')->textInput(['maxlength' => 20,'disabled' => true,'pluginOptions' => ['width' => '20%']]);
                            } else {
                                echo 'Auto Generate';
                            }
                            ?>         
                        </td>
                    </tr> 
                    <tr>
                        <td style="width: 200px"> Nama Calon Product</td>
                        <td> 
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'Nama')->textInput(['maxlength' => 100,'style' => 'width:35%;'])->label(false);
                            } else {
                                echo $form->field($model, 'Nama')->textInput(['maxlength' => 50, 'style' => 'width:35%;', 'disabled' => true]);
                            }
                            ?>                   
                        </td>
                    </tr>
                    <tr>
                        <td> Job Description</td>
                        <td>
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'IDJobDesc')->widget(Select2::classname(),['data' => ArrayHelper::map($masterjob, 'IDJobDesc', 'Description'),'options' => ['prompt' => 'Select Job Desc'],'pluginOptions' => ['width' => '25%']])->label(false);
                            } else {
                                echo $form->field($model, 'IDJobDesc')->textInput(['maxlength' => 50, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> Area</td>
                        <td>
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'AreaID')->widget(Select2::classname(),['data' => ArrayHelper::map($masterarea, 'AreaID', 'Description'),'options' => ['prompt' => 'Select Area'],'pluginOptions' => ['width' => '25%']])->label(false);
                            } else {
                                echo $form->field($model, 'AreaID')->textInput(['maxlength' => 50, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td>Gender </td>
                        <td>    
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'Gender')->widget(Select2::classname(),['data' => ['L' => 'Laki-laki', 'P' => 'Perempuan'],'hideSearch' => true,'options'=> ['prompt' => 'Select Gender'],'pluginOptions' => ['width' => '25%']])->label(false);
                            } else {
                                echo $form->field($model, 'Gender')->textInput(['maxlength' => 20, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> No KK </td>
                        <td>
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'NoKK')->textInput(['maxlength' => 50, 'style' => 'width:180px;'])->label(false);
                            } else {
                                echo $form->field($model, 'NoKK')->textInput(['maxlength' => 20, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> KTP </td>
                        <td>
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'KTP')->textInput(['maxlength' => 50, 'style' => 'width:180px;'])->label(false);
                            } else {
                                echo $form->field($model, 'KTP')->textInput(['maxlength' => 20, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                     <td>KTP Expired date</td>
                     <td>
                         <?php
                         if ($model->isNewRecord) {
                             echo DatePicker::widget([
                                 'model' => $model,
                                 'attribute' => 'KTPExpireddate',
                                 'options' => ['placeholder' => 'Enter Date...', 'style' => 'width:160px'],
                                 'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']]);
                         } else {
                             echo $form->field($model, 'KTPExpireddate')->textInput(['maxlength' => 20, 'style' => 'width:180px;', 'disabled' => true]);
                         }
                         ?>
                     </td>
                    </tr> 
                    <tr>
                        <td> SIM </td>
                        <td>
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'SIM')->textInput(['maxlength' => 50, 'style' => 'width:180px;'])->label(false)   ;
                            } else {
                                echo $form->field($model, 'SIM')->textInput(['maxlength' => 20, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> SIM Expire Date </td>
                        <td>
                            <?php
                            if ($model->isNewRecord) {
                                echo DatePicker::widget([
                                    'model' => $model,
                                    'attribute' => 'SIMExpireDate',
                                    'options' => ['placeholder' => 'Enter Date...', 'style' => 'width:160px'],
                                    'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']]);
                            } else {
                                echo $form->field($model, 'SIMExpireDate')->textInput(['maxlength' => 20, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Status Nikah </td>
                        <td>
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'IDstatusnikah')->widget(select2::classname(),['data' => ArrayHelper::map($masterstatusnikah, 'IDStatusPernikahan', 'IDStatusPernikahan'),'hideSearch' => true,'options' => ['prompt' => 'Select status nikah'],'pluginOptions' => ['width' => '25%']])->label(false);
                            } else {
                                echo $form->field($model, 'IDstatusnikah')->textInput(['maxlength' => 20, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> Address </td>
                        <td>
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'Address')->textarea(['maxlength' => 255, 'style' => 'width:400px;', 'rows' => 2])->label(false);
                            } else {
                                echo $form->field($model, 'Address')->textarea(['maxlength' => 20, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?>                 
                        </td>
                    </tr>
                    <tr>
                        <td> Refferensi Desc </td>
                        <td>
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'RefferensiDesc')->textarea(['maxlength' => 255, 'style' => 'width:400px;', 'rows' => 2])->label(false);
                            } else {
                                echo $form->field($model, 'RefferensiDesc')->textarea(['maxlength' => 20, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?>                   
                        </td>
                    </tr>
                    <tr>
                        <td> City </td>
                        <td>
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'City')->textInput(['maxlength' => 50, 'style' => 'width:180px;'])->label(false);
                            } else {
                                echo $form->field($model, 'City')->textInput(['maxlength' => 20, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> Zip </td>
                        <td>
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'Zip')->textInput(['maxlength' => 5, 'style' => 'width:180px;'])->label(false);
                            } else {
                                echo $form->field($model, 'Zip')->textInput(['maxlength' => 5, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> Phone</td>
                        <td>
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'Phone')->textInput(['maxlength' => 50, 'style' => 'width:180px;'])->label(false);
                            } else {
                                echo $form->field($model, 'Phone')->textInput(['maxlength' => 20, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td>Mobile 1</td>
                        <td>
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'Mobile1')->textInput(['maxlength' => 50, 'style' => 'width:180px;'])->label(false);
                            } else {
                                echo $form->field($model, 'Mobile1')->textInput(['maxlength' => 20, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> Mobile 2</td>
                        <td>
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'Mobile2')->textInput(['maxlength' => 50, 'style' => 'width:180px;'])->label(false);
                            } else {
                                echo $form->field($model, 'Mobile2')->textInput(['maxlength' => 20, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> Bank Nama</td>
                        <td>
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'BankID')->widget(Select2::className(),['data' => ArrayHelper::map($masterbank, 'BankGroupID', 'BankGroupName'),'hideSearch' => true,'options' => ['prompt' => 'Select bank name'],'pluginOptions' => ['width' => '25%']])->label(false);
                            } else {
                                echo $form->field($model, 'BankID')->textInput(['maxlength' => 20, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?>                 
                        </td>
                    </tr>
                    <tr>
                        <td>Bank Acc Number </td>
                        <td>
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'BankAccNumber')->textInput(['maxlength' => 50, 'style' => 'width:180px;'])->label(false);
                            } else {
                                echo $form->field($model, 'BankAccNumber')->textInput(['maxlength' => 20, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> NPWP </td>
                        <td> 
                            <?php
                            if ($model->isNewRecord) {
                                echo $form->field($model, 'NPWP')->textInput(['maxlength' => 50, 'style' => 'width:180px;'])->label(false);
                            } else {
                                echo $form->field($model, 'NPWP')->textInput(['maxlength' => 20, 'style' => 'width:180px;', 'disabled' => true]);
                            }
                            ?> 
                        </td>
                    </tr>
                    <?php
                    if (!$model->isNewRecord) {
                        echo '<tr>';
                        echo '<td> IsActive </td>';
                        echo '<td>';
                        echo $form->field($model, 'IsActive')->checkbox();
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>  
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="box-body">
                <table >
                    <tr>
                        <td style="width: 50px">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                        </td>
                        <td style="width: 50px">
                            <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
                        </td>
                        <td style="width: 50px">
                            <?php
                            if (!$model->isNewRecord) {
                                echo Html::a('Tambah Nilai', ['nilai-tes/create/', 'CalonProductID' => $idCP], ['class' => 'btn btn-warning', 'style' => 'width:110px;']);
                            } else {

                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <?php
    ActiveForm::end();
    if (Yii::$app->controller->action->id === 'update') {
        $query = app\operational\models\NilaiTes::find()
                ->select('*')
                ->from('NilaiTes nt')
                ->Join('JOIN', 'JenisTes jt', 'nt.IDJenisTes = jt.IDJenisTes')
                ->where(['CalonProductID' => $idCP]);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'pjax' => FALSE,
            'columns' => [
                ['label' => 'Jenis Tes',
                    'value' => 'Description'],
                ['label' => ' Nilai Tes',
                    'value' => 'Nilai'],
                ['label' => ' Tanggal Tes',
                    'value' => 'TglTes'],
            ],
        ]);
    }
    ?>
</div>
