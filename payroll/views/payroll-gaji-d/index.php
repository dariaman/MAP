<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\payroll\models\PayrollGajiDSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payroll Gaji Ds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-gaji-d-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'PayrollGajiIDH',
            'ItemID',
            'Amount',
            // 'UserUpdate',
            // 'DateUpdate',

        ],
    ]); ?>
    
    <p>
        <?= Html::a('Create Payroll Gaji D', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
