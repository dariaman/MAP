<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\finance\models\BillingD */

$this->title = 'Update Billing D: ' . ' ' . $model->BillingNo;
$this->params['breadcrumbs'][] = ['label' => 'Billing Ds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->BillingNo, 'url' => ['view', 'id' => $model->BillingNo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="billing-d-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
