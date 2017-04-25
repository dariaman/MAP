<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\finance\models\FakturPajakD */

$this->title = 'Update Faktur Pajak D: ' . $model->NoFakturPajak;
$this->params['breadcrumbs'][] = ['label' => 'Faktur Pajak Ds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NoFakturPajak, 'url' => ['view', 'id' => $model->NoFakturPajak]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="faktur-pajak-d-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
