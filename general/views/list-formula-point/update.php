<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\general\models\ListFormulaPoint */

$this->title = 'Update List Formula Point: ' . ' ' . $model->JenisFormulaPoint;
$this->params['breadcrumbs'][] = ['label' => 'List Formula Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->JenisFormulaPoint, 'url' => ['view', 'id' => $model->JenisFormulaPoint]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="list-formula-point-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
