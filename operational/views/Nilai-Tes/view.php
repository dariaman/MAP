<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\operational\models\NilaiTes */

$this->title = $model->CalonProductID;
$this->params['breadcrumbs'][] = ['label' => 'Nilai Tes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nilai-tes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'CalonProductID' => $model->CalonProductID,'IDJenisTes'=>$model->IDJenisTes], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'CalonProductID' => $model->CalonProductID], [
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
            'CalonProductID',
            'TglTes',
            'IDJenisTes',
            'Nilai',
            'UserCrt',
            'DateCrt',
        ],
    ]) ?>

</div>
