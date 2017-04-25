<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\payroll\models\PayrollGajiH */

$this->title = 'Create Payroll Gaji H';
$this->params['breadcrumbs'][] = ['label' => 'Payroll Gaji Hs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-gaji-h-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
