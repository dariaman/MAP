<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\operational\models\SuratTilang */

$this->title = 'Input Surat Tilang';
//$this->params['breadcrumbs'][] = ['label' => 'Surat Tilangs', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-tilang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
