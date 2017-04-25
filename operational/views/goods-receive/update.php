<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\operational\models\GoodsReceive */

$this->title = 'Update Goods Receive: ' . ' ' . $model->GRID;
$this->params['breadcrumbs'][] = ['label' => 'Goods Receives', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->GRID, 'url' => ['view', 'id' => $model->GRID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="goods-receive-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
