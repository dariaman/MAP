<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="box-body">

<?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'options' => ['data-pjax' => true],
    ]);
    
    $type = Yii::$app->request->post('typeSearch');
    $text = Yii::$app->request->post('textsearch');

    echo Html::dropDownList('typeSearch', $type, [
        'sh.SOIDH' => 'SOIDH',
        'sh.SODate' => 'SO Date',
        'sh.OfferingIDH' => 'OfferingID',
        'oh.IDJobDesc' => 'Job Description',
        'oh.CustomerID' => 'Customer Name',
        'sh.PONo' => 'Po Number',
        'sh.POdate' => 'PO Date'], ['prompt' => 'ALL', 'class' => 'form-control', 'id' => 'searchdrop']);
    echo Html::textInput('textsearch', $text, ['class' => 'form-control', 'id' => 'searchbox']);
    ?>
    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
