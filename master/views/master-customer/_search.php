<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="box-body">

    <?php
    $form = ActiveForm::begin([
                'method' => 'POST',
//                'action' => ['index'],
                'options' => ['data-pjax' => true],
    ]);
    ?>
    <?php
    $type = Yii::$app->request->post('typeSearch');
    $text = Yii::$app->request->post('textsearch');

    echo Html::dropDownList('typeSearch', $type, ['mc.CustomerID' => 'Customer ID', 'mc.CustomerName' => 'Customer Name'], ['prompt' => 'ALL', 'class' => 'form-control', 'id' => 'searchdrop']);
    echo Html::textInput('textsearch', $text, ['class' => 'form-control', 'id' => 'searchbox']);
    ?>
    <div class="form-group">
    <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']); ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
