<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\general\models\ListFormulaJam */

$this->title = 'Create List Formula Jam';
$this->params['breadcrumbs'][] = ['label' => 'List Formula Jams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-formula-jam-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
