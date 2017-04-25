<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\BillingD */

$this->title = $model->BillingNo;
$this->params['breadcrumbs'][] = ['label' => 'Billing Ds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="billing-d-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->BillingNo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->BillingNo], [
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
            'BillingNo',
            'InvoiceNo',
            'TipeBilling',
            'AreaID',
            'SODID',
            'ProductID',
            'Periode',
            'DPP',
            'MgmFee',
            'PPN',
            'PPH23',
            'Total',
            'Usercrt',
            'Datecrt',
        ],
    ]) ?>

</div>
