<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\operational\models\AllocationProductH */

$this->title = 'Update Allocation Product H: ' . ' ' . $model->AllocationProductIDH;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Product Hs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->AllocationProductIDH, 'url' => ['view', 'id' => $model->AllocationProductIDH]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-product-h-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
