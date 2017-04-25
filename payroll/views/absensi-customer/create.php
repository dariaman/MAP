<?php

use yii\helpers\Html;

$this->title = 'Absensi Verifikasi';
?>
<div class="absensi-customer-create">

    <h1><center><?= Html::encode($this->title) ?></center></h1>
    <?= $this->render('_form', ['model' => $model]) ?>

</div>
