<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\finance\models\Invoice */

$this->title = 'Update Invoice: ' . ' ' . $model->InvoiceNo;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->InvoiceNo, 'url' => ['view', 'id' => $model->InvoiceNo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="invoice-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
