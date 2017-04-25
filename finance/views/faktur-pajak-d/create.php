<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\finance\models\FakturPajakD */

$this->title = 'Create Faktur Pajak D';
$this->params['breadcrumbs'][] = ['label' => 'Faktur Pajak Ds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faktur-pajak-d-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
