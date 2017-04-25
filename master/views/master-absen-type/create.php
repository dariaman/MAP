<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterAbsenType */

$this->title = 'Insert Master Absen Type';
//$this->params['breadcrumbs'][] = ['label' => 'Master Absen Types', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-absen-type-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
