<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\operational\models\AllocationProductD */

$this->title = $model->AllocationProductDID;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Product Ds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-product-d-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->AllocationProductDID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->AllocationProductDID], [
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
            'AllocationProductDID',
            'AllocationProductIDH',
            'SODID',
            'ProductID',
            'AreaDetailDesc',
            'LicensePlate',
            'TglTugas',
            'IsActive',
            'IsShift',
            'HariKerja',
            'NoPKWT',
            'UserCrt',
            'DateCrt',
        ],
    ]) ?>

</div>
