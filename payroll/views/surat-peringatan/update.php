<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\SuratPeringatan */

$this->title = 'Update Surat Peringatan: ' . ' ' . $model->SpNo;
$this->params['breadcrumbs'][] = ['label' => 'Surat Peringatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SpNo, 'url' => ['view', 'id' => $model->SpNo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="surat-peringatan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
