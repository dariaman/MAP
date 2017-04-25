<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\payroll\models\AbsensiGSSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Absensi Gs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="absensi-gs-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Absensi Gs', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ProductID',
            'tgl',
            'UserCrt',
            'DateCrt',
            'UserUpdate',
            // 'DateUpdate',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
