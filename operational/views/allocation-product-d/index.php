<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\AllocationProductDSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Allocation Product Ds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-product-d-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Allocation Product D', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'AllocationProductDID',
            'AllocationProductIDH',
            'SODID',
            'ProductID',
            'AreaDetailDesc',
            // 'LicensePlate',
            // 'TglTugas',
            // 'IsActive',
            // 'IsShift',
            // 'HariKerja',
            // 'NoPKWT',
            // 'UserCrt',
            // 'DateCrt',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
