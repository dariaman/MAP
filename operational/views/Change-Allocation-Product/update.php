<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\operational\models\ChangeAllocationProduct */

$this->title = 'Update Change Allocation Product: ' . ' ' . $model->ChangeAllocationProductID;
$this->params['breadcrumbs'][] = ['label' => 'Change Allocation Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ChangeAllocationProductID, 'url' => ['view', 'id' => $model->ChangeAllocationProductID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="change-allocation-product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
