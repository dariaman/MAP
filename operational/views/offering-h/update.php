<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\operational\models\OfferingH */

$this->title = 'Update Offering H: ' . ' ' . $model->OfferingIDH;
$this->params['breadcrumbs'][] = ['label' => 'Offering Hs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->OfferingIDH, 'url' => ['view', 'id' => $model->OfferingIDH]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="offering-h-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
