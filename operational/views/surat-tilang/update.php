<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\operational\models\SuratTilang */

$this->title = 'Update Surat Tilang: ' . ' ' . $model->ProductID;


?>
<div class="surat-tilang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
