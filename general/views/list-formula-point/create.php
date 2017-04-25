<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\general\models\ListFormulaPoint */

$this->title = 'Create List Formula Point';
$this->params['breadcrumbs'][] = ['label' => 'List Formula Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-formula-point-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
