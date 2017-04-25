<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\payroll\models\AbsensiGS */

$this->title = 'Create Absensi Gs';
$this->params['breadcrumbs'][] = ['label' => 'Absensi Gs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="absensi-gs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
