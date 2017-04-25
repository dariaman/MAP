<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\finance\models\AccountPayable */

$this->title = $model->APNo;
$this->params['breadcrumbs'][] = ['label' => 'Account Payables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-payable-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->APNo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->APNo], [
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
            'APNo',
            'APDate',
            'TotalAmount',
            'PPN',
            'PaidNo',
            'PaidDate',
            'PaidRemark',
            'UserCrt',
            'DateCrt',
        ],
    ]) ?>

</div>
