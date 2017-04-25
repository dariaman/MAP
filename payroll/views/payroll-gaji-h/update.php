<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PayrollGajiH */

$this->title = 'Update Payroll Gaji H: ' . ' ' . $model->PayrollGajiIDH;
$this->params['breadcrumbs'][] = ['label' => 'Payroll Gaji Hs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PayrollGajiIDH, 'url' => ['view', 'id' => $model->PayrollGajiIDH]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payroll-gaji-h-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
