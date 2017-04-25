<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\eprocess\models\JadwalAbsensiStatusD */

$this->title = 'Create Jadwal Absensi Status D';
$this->params['breadcrumbs'][] = ['label' => 'Jadwal Absensi Status Ds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jadwal-absensi-status-d-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
