<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\operational\models\NilaiTes */

//$this->title = 'Update Nilai Tes: ' . ' ' . $model->CalonProductID;
//$this->params['breadcrumbs'][] = ['label' => 'Nilai Tes', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->CalonProductID, 'url' => ['view', 'id' => $model->CalonProductID]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nilai-tes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
