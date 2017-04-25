<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\eprocess\models\JadwalAbsensiStatusD */

$this->title = $model->IDJadwalAbsensiStatusH;
$this->params['breadcrumbs'][] = ['label' => 'Jadwal Absensi Status Ds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jadwal-absensi-status-d-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'IDJadwalAbsensiStatusH' => $model->IDJadwalAbsensiStatusH, 'ProductID' => $model->ProductID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'IDJadwalAbsensiStatusH' => $model->IDJadwalAbsensiStatusH, 'ProductID' => $model->ProductID], [
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
            'IDJadwalAbsensiStatusH',
            'ProductID',
            'CloseJadwalStatus',
            'CloseJadwalDate',
            'CloseAbsenStatus',
            'CloseAbsenDate',
            'CloseOTStatus',
            'CloseOTDate',
            'IsActive',
            'UserCrt',
            'DateCrt',
        ],
    ]) ?>

</div>
