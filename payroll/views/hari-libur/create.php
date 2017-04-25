<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\payroll\models\HariLibur */

$this->title = 'Input Hari Libur';
//$this->params['breadcrumbs'][] = ['label' => 'Hari Liburs', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hari-libur-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
