<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\operational\models\BackupProduct */

$this->title = 'Update Backup Product: ' . ' ' . $model->PeriodTo;
$this->params['breadcrumbs'][] = ['label' => 'Backup Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PeriodTo, 'url' => ['view', 'PeriodTo' => $model->PeriodTo, 'ProductIDGS' => $model->ProductIDGS, 'TglTugas' => $model->TglTugas]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="backup-product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
