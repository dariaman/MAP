<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\operational\models\NilaiTes */

$this->title = 'Input Nilai Tes';
//$this->params['breadcrumbs'][] = ['label' => 'Nilai Tes', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nilai-tes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
