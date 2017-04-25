<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\operational\models\BPJSRegistrasi */

$this->title = 'Registrasi BPJS';
$this->params['breadcrumbs'][] = ['label' => 'Bpjsregistrasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProductID, 'url' => ['view', 'id' => $model->ProductID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bpjsregistrasi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
