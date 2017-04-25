<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\master\models\NilaiTes */

$this->title = 'Update Nilai Tes';
//$this->params['breadcrumbs'][] = ['label' => 'Nilai Tes', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nilai-tes-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
