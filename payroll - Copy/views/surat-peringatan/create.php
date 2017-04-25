<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\payroll\models\SuratPeringatan */

$this->title = 'Input Surat Peringatan';
//$this->params['breadcrumbs'][] = ['label' => 'Surat Peringatans', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-peringatan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
