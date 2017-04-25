<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\finance\models\AccountPayable */

$this->title = 'Update Account Payable: ' . ' ' . $model->APNo;
$this->params['breadcrumbs'][] = ['label' => 'Account Payables', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->APNo, 'url' => ['view', 'id' => $model->APNo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="account-payable-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
