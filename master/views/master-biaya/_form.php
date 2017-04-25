<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="master-Biaya-form">

 <?php $form = ActiveForm::begin() ?>
         
     <table class="table table-striped table-bordered">
          <tr>
                <td> ID </td>
                <td>[Auto Generate]</td>
          </tr>
          <tr>
                <td> Tipe Biaya </td>
                <td>
                <?=$form->field($model, 'TipeBiaya')->radioList(array('1FX'=>'FIX','2TMB'=>'TMB','3NFIX'=>'NFIX',),['class' => $model->TipeBiaya ? 'btn-group' : 'btn btn-default'],['id'=>'radioButtons'] ) ?>
                </td>
          </tr>       
          <tr>    
                <td style="padding-right:20px; padding-top:10px;"> Description</td>
                <td><?=$form->field($model, 'Description')->textInput(['maxlength' => 100,'style'=> 'width:400px;','rows'=>3]) ?> </td>
          </tr>
          
   <?php
     if (! $model->isNewRecord )
    {
        echo '<tr><td style="padding-right:20px;padding-bottom:20px;">Status</td>';
        echo '<td style="padding-right:20px;padding-bottom:5px;">';
       echo $form->field($model, 'IsActive')->checkbox() ;
       echo '</td></tr>';
    }
  
    echo '</table>';
    ?>
    <?= Html::submitButton('Save', ['class' =>'btn btn-success']) ?>
    <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>     
  <?php ActiveForm::end() ?>

</div>

</div>
