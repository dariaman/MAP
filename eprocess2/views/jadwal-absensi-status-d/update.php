<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\eprocess\models\JadwalAbsensiStatusD */

$this->title = 'Update Jadwal Absensi Status D: ' . ' ' . $model->IDJadwalAbsensiStatusH;
$this->params['breadcrumbs'][] = ['label' => 'Jadwal Absensi Status Ds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IDJadwalAbsensiStatusH, 'url' => ['view', 'IDJadwalAbsensiStatusH' => $model->IDJadwalAbsensiStatusH, 'ProductID' => $model->ProductID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jadwal-absensi-status-d-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
