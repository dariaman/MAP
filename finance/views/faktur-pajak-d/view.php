<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\finance\models\FakturPajakD */

$this->title = $model->NoFakturPajak;
$this->params['breadcrumbs'][] = ['label' => 'Faktur Pajak Ds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faktur-pajak-d-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->NoFakturPajak], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->NoFakturPajak], [
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
            'NoFakturPajak',
            'KodeFaktur',
            'TRNo',
            'InvoiceNo',
            'InvoiceDate',
            'IsCancel',
            'InvoiceCancel',
            'CancelDate',
            'CancelReason',
            'UserCrt',
            'DateCrt',
            'UserUpdate',
            'DateUpdate',
        ],
    ]) ?>

</div>
