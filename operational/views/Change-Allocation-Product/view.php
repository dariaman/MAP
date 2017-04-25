<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\operational\models\ChangeAllocationProduct */

$this->title = $model->ChangeAllocationProductID;
$this->params['breadcrumbs'][] = ['label' => 'Change Allocation Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="change-allocation-product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ChangeAllocationProductID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ChangeAllocationProductID], [
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
            'ChangeAllocationProductID',
            'AllocationProductID',
            'SOID',
            'RefID',
            'JobDescID',
            'AreaID',
            'ProductID',
            'ToProductID',
            'ProductFreelance',
            'Tipe',
            'Remark',
            'FromDate',
            'ToDate',
            'UserCrt',
            'DateCrt',
        ],
    ]) ?>

</div>
