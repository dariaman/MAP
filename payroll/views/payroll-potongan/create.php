<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\payroll\models\PayrollPotongan */

$this->title = 'Create Payroll Potongan';
$this->params['breadcrumbs'][] = ['label' => 'Payroll Potongans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-potongan-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
