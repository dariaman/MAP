<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PayrollGajiH */

$this->title = $model->PayrollGajiIDH;
$this->params['breadcrumbs'][] = ['label' => 'Payroll Gaji Hs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-gaji-h-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->PayrollGajiIDH], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->PayrollGajiIDH], [
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
            'UserCrt',
            'DateCrt',
            'UserUpdate',
            'DateUpdate',
        ],
    ]) ?>

</div>
