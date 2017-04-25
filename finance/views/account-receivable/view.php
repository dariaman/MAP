<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\finance\models\AccountReceivable */

$this->title = $model->ARNo;
$this->params['breadcrumbs'][] = ['label' => 'Account Receivables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-receivable-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ARNo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ARNo], [
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
            'ARNo',
            'InvoiceNo',
            'RefNo',
            'PaymentDate',
            'UserCrt',
            'DateCrt',
        ],
    ]) ?>

</div>
