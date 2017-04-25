<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PayrollInsentive */

//$this->title = 'Update Payroll Insentive: ' . ' ' . $model->ProductID;
//$this->params['breadcrumbs'][] = ['label' => 'Payroll Insentives', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->ProductID, 'url' => ['view', 'id' => $model->ProductID]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payroll-insentive-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
