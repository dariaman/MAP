<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\payroll\models\PayrollGajiHSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payroll Gaji Hs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-gaji-h-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Payroll Gaji H', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'PayrollGajiIDH',
            'ProductID',
            'bln',
            'thn',
            'CustomerID',
             'AreaID',
             'FixAmount',
             'TunjanganAmount',
             'PotonganAmount',
             'PPH21',
             'Total',
             'Status',
        ],
    ]); ?>

</div>
