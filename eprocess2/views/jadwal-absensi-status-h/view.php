<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\eprocess\models\JadwalAbsensiStatusH */

$this->title = $model->AreaID;
$this->params['breadcrumbs'][] = ['label' => 'Jadwal Absensi Status Hs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jadwal-absensi-status-h-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'AreaID' => $model->AreaID, 'Bln' => $model->Bln, 'CustomerID' => $model->CustomerID, 'Thn' => $model->Thn], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'AreaID' => $model->AreaID, 'Bln' => $model->Bln, 'CustomerID' => $model->CustomerID, 'Thn' => $model->Thn], [
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
            'CustomerID',
            'AreaID',
            'Thn',
            'Bln',
            'MaxAbsensi',
            'IsActive',
            'UserCrt',
            'DateCrt',
        ],
    ]) ?>

</div>
