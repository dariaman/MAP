<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PaymentSalary */

$this->title = 'Update Payment Salary: ' . ' ' . $model->APNO;
$this->params['breadcrumbs'][] = ['label' => 'Payment Salaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->APNO, 'url' => ['view', 'id' => $model->APNO]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payment-salary-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
