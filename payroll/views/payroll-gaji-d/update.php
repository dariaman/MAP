<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PayrollGajiD */

$this->title = 'Update Payroll Gaji D: ' . ' ' . $model->ItemID;
$this->params['breadcrumbs'][] = ['label' => 'Payroll Gaji Ds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ItemID, 'url' => ['view', 'ItemID' => $model->ItemID, 'PayrollGajiIDH' => $model->PayrollGajiIDH]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payroll-gaji-d-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
