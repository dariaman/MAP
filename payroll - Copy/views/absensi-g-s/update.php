<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\AbsensiGS */

$this->title = 'Update Absensi Gs: ' . ' ' . $model->ProductID;
$this->params['breadcrumbs'][] = ['label' => 'Absensi Gs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProductID, 'url' => ['view', 'ProductID' => $model->ProductID, 'tgl' => $model->tgl]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="absensi-gs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
