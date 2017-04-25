<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\eprocess\models\JadwalAbsensiStatusH */

$this->title = 'Update Jadwal Absensi Status H: ' . ' ' . $model->AreaID;
$this->params['breadcrumbs'][] = ['label' => 'Jadwal Absensi Status Hs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->AreaID, 'url' => ['view', 'AreaID' => $model->AreaID, 'Bln' => $model->Bln, 'CustomerID' => $model->CustomerID, 'Thn' => $model->Thn]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jadwal-absensi-status-h-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
