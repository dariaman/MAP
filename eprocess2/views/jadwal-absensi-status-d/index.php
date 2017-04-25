<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\eprocess\models\JadwalAbsensiStatusDSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jadwal Absensi Status Ds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jadwal-absensi-status-d-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Jadwal Absensi Status D', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'IDJadwalAbsensiStatusH',
            'ProductID',
            'CloseJadwalStatus',
            'CloseJadwalDate',
            'CloseAbsenStatus',
            // 'CloseAbsenDate',
            // 'CloseOTStatus',
            // 'CloseOTDate',
            // 'IsActive',
            // 'UserCrt',
            // 'DateCrt',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
