<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\operational\models\TransactionMaster */

$this->title = 'Update Transaction Master: ' . ' ' . $model->TransID;
$this->params['breadcrumbs'][] = ['label' => 'Transaction Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TransID, 'url' => ['view', 'id' => $model->TransID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transaction-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
