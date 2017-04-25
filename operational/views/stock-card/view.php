<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\operational\models\StockCard */

$this->title = $model->StockID;
$this->params['breadcrumbs'][] = ['label' => 'Stock Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-card-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->StockID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->StockID], [
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
            'StockID',
            'ItemID',
            'Qty',
            'TanggalTransaksi',
            'UserCrt',
            'DateCrt',
        ],
    ]) ?>

</div>