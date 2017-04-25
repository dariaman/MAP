<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\BillingH */

$this->title = 'Update Billing H: ' . ' ' . $model->InvoiceNo;
$this->params['breadcrumbs'][] = ['label' => 'Billing Hs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->InvoiceNo, 'url' => ['view', 'id' => $model->InvoiceNo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="billing-h-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
