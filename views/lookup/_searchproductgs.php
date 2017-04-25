<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
?>

<div class="box-body">

<?php
$form = ActiveForm::begin([
            'action' => ['lookupproductgs', 'idjob' => $_GET['idjob']],
            'options' => ['data-pjax' => true],
]);

$type = Yii::$app->request->post('typeSearch');
$text = Yii::$app->request->post('textsearch');

echo Html::dropDownList('typeSearch', $type, 
					['mp.ProductID' => 'Product ID',
    				'mj.Description' => 'Job Description',
    				'mp.Nama' => 'Nama'],
				['prompt' => 'ALL', 'class' => 'form-control', 'id' => 'searchdrop']);
echo Html::textInput('textsearch', $text, ['class' => 'form-control', 'id' => 'searchbox']);
?>
<div class="form-group">
    <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']); ?>
</div>

<?php ActiveForm::end(); ?>

</div>
