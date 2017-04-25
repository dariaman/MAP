<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PaymentSalary */

$this->title = $model->APNO;
$this->params['breadcrumbs'][] = ['label' => 'Payment Salaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-salary-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->APNO], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->APNO], [
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
            'APNO',
            'APDate',
            'PayrollGajiIDH',
            'AmountPayment',
            'BiayaAdmin',
            'IDBankMAP',
            'BankGroupProduct',
            'RekBankProduct',
            'UserCrt',
            'DateCrt',
            'UserUpdate',
            'DateUpdate',
        ],
    ]) ?>

</div>
