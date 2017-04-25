<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PayrollPotongan */

$this->title = 'Update Payroll Potongan: ' . ' ' . $model->IDPotongan;
$this->params['breadcrumbs'][] = ['label' => 'Payroll Potongans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IDPotongan, 'url' => ['view', 'IDPotongan' => $model->IDPotongan, 'ProductID' => $model->ProductID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payroll-potongan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
