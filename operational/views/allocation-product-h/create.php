<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\operational\models\AllocationProductH */

$this->title = 'Tambah Go Live Header';

?>
<div class="allocation-product-h-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
