<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\AbsensiGS */

$this->title = $model->ProductID;
$this->params['breadcrumbs'][] = ['label' => 'Absensi Gs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="absensi-gs-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ProductID' => $model->ProductID, 'tgl' => $model->tgl], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ProductID' => $model->ProductID, 'tgl' => $model->tgl], [
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
            'ProductID',
            'tgl',
            'UserCrt',
            'DateCrt',
            'UserUpdate',
            'DateUpdate',
        ],
    ]) ?>

</div>
