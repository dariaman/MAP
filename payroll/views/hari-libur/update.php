<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\HariLibur */

$this->title = 'Update Hari Libur: ' . ' ' . $model->Tgl;
//$this->params['breadcrumbs'][] = ['label' => 'Hari Liburs', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->Tgl, 'url' => ['view', 'id' => $model->Tgl]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="hari-libur-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    
</div>
