<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\finance\models\Invoice */

$this->title = $model->InvoiceNo;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->InvoiceNo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->InvoiceNo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'InvoiceNo',
            'InvoiceDate',
            'CustomerID',
            'TotalDPP',
            'TotalMFee',
            'TotalPPN',
            'TotalPPH23',
            'TotalInvoice',
            'KodeFaktur',
            'NoFakturPajak',
            'Status',
            'CancelDate',
            'CancelReason',
            'UserCrt',
            'DateCrt',
            'UserUpdate',
            'DateUpdate',
        ],
    ]) ?>

</div>
