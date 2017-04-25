<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PayrollPotongan */

$this->title = $model->IDPotongan;
$this->params['breadcrumbs'][] = ['label' => 'Payroll Potongans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-potongan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'IDPotongan' => $model->IDPotongan, 'ProductID' => $model->ProductID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'IDPotongan' => $model->IDPotongan, 'ProductID' => $model->ProductID], [
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
            'ProductID',
            'IDPotongan',
            'Amount',
            'IsReguler',
            'Periode',
            'IsActive',
            'UserCrt',
            'DateCrt',
        ],
    ]) ?>

</div>
