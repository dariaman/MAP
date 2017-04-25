<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\general\models\ListFormulaAmount */

$this->title = 'Create List Formula Amount';
$this->params['breadcrumbs'][] = ['label' => 'List Formula Amounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-formula-amount-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
