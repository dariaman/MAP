<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\operational\models\BackupProduct */

$this->title = $model->PeriodTo;
$this->params['breadcrumbs'][] = ['label' => 'Backup Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="backup-product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'PeriodTo' => $model->PeriodTo, 'ProductIDGS' => $model->ProductIDGS, 'TglTugas' => $model->TglTugas], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'PeriodTo' => $model->PeriodTo, 'ProductIDGS' => $model->ProductIDGS, 'TglTugas' => $model->TglTugas], [
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
            'ProductIDGS',
            'SOD',
            'SeqProductID',
            'ProductIDFix',
            'TglTugas',
            'StatusAbsen',
            'Reason',
            'PeriodTo',
            'UserCrt',
            'DateCrt',
            'UserUpdate',
            'DateUpdate',
        ],
    ]) ?>

</div>
