<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\general\models\ListFormulaAmount */

$this->title = 'Update List Formula Amount: ' . ' ' . $model->JenisFormulaAmount;
$this->params['breadcrumbs'][] = ['label' => 'List Formula Amounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->JenisFormulaAmount, 'url' => ['view', 'id' => $model->JenisFormulaAmount]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="list-formula-amount-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
