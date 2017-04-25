<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\payroll\models\PayrollInsentive */

$this->title = 'Add Payroll Insentive';
$this->params['breadcrumbs'][] = ['label' => 'Payroll Insentives', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-insentive-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
