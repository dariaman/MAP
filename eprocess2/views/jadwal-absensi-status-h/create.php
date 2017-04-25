<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\eprocess\models\JadwalAbsensiStatusH */

$this->title = 'Import Jadwal Absensi Customer';

?>
<div class="jadwal-absensi-status-h-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
