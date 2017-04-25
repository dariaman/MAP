<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\operational\models\GoodsReceive */

$this->title = $model->GRID;
$this->params['breadcrumbs'][] = ['label' => 'Goods Receives', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-receive-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->GRID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->GRID], [
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
            'GRID',
            'ItemID',
            'Qty',
            'HargaSatuan',
            'NoPV',
            'ReferenceNo',
            'SupplierName',
            'NoFakturPajak',
            'ReceiveDate',
            'UserCrt',
            'DateCrt',
            'UserUpdate',
            'DateUpdate',
        ],
    ]) ?>

</div>
