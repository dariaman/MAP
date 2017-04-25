<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\operational\models\AllocationProductD */

$this->title = 'Go Live Detail';
?>
<div class="allocation-product-d-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
