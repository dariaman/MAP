<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="master-product-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['lookupproductpayroll'],
                'options' => ['data-pjax' => true],
    ]);
    ?>
    <?php
    $type = Yii::$app->request->post('typeSearch');
    $text = Yii::$app->request->post('textsearch');

    echo Html::dropDownList('typeSearch', $type, ['mp.ProductID'=>'ProductID', 'mp.IDJobDesc'=>'Job Description','mp.Nama'=>'Nama']
            , ['prompt' => 'ALL', 'class' => 'form-control', 'id' => 'searchdrop']);
    echo Html::textInput('textsearch', $text, ['class' => 'form-control', 'id' => 'searchbox']);
    ?>
    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>