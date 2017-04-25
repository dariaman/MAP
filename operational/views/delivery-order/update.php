<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\operational\models\DeliveryOrder */

$this->title = 'Update Delivery Order: ' . ' ' . $model->DONo;
$this->params['breadcrumbs'][] = ['label' => 'Delivery Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DONo, 'url' => ['view', 'id' => $model->DONo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="delivery-order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
