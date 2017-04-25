<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\SuratPeringatan */

$this->title = $model->SpNo;
$this->params['breadcrumbs'][] = ['label' => 'Surat Peringatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-peringatan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->SpNo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->SpNo], [
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
            'SpNo',
            'SpDate',
            'ProductID',
            'Remark',
            'ApproveBy',
            'ApproveDate',
            'UserCrt',
            'DateCrt',
        ],
    ]) ?>

</div>
