<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\operational\models\OfferingH */

$this->title = $model->OfferingIDH;
$this->params['breadcrumbs'][] = ['label' => 'Offering Hs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offering-h-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->OfferingIDH], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->OfferingIDH], [
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
            'OfferingIDH',
            'OfferingDate',
            'IDJobDesc',
            'NoSurat',
            'TipeBayar',
            'CaraBayar',
            'ThnRemunerasi',
            'IsActive',
            'IsPrint',
            'ApproveBy',
            'ApproveDate',
            'Status',
            'UserCrt',
            'DateCrt',
        ],
    ]) ?>

</div>
