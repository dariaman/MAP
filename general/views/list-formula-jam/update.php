<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\general\models\ListFormulaJam */

$this->title = 'Update List Formula Jam: ' . ' ' . $model->JenisFormulaJam;
$this->params['breadcrumbs'][] = ['label' => 'List Formula Jams', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->JenisFormulaJam, 'url' => ['view', 'id' => $model->JenisFormulaJam]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="list-formula-jam-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
