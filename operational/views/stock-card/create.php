<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\operational\models\StockCard */

$this->title = 'Tambah Stock Baru';
?>
<div class="stock-card-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
