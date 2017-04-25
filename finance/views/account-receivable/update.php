<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\finance\models\AccountReceivable */

$this->title = 'Update Account Receivable: ' . ' ' . $model->ARNo;
$this->params['breadcrumbs'][] = ['label' => 'Account Receivables', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ARNo, 'url' => ['view', 'id' => $model->ARNo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="account-receivable-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
