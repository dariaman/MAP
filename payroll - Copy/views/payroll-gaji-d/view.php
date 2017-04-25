<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PayrollGajiD */

$this->title = $model->ItemID;
$this->params['breadcrumbs'][] = ['label' => 'Payroll Gaji Ds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-gaji-d-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ItemID' => $model->ItemID, 'PayrollGajiIDH' => $model->PayrollGajiIDH], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ItemID' => $model->ItemID, 'PayrollGajiIDH' => $model->PayrollGajiIDH], [
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
            'ItemID',
            'Amount',
            'UserCrt',
            'DateCrt',
            'UserUpdate',
            'DateUpdate',
        ],
    ]) ?>

</div>
