<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\operational\models\DeliveryOrder */

$this->title = 'Buat Delivery Order';
?>
<div class="delivery-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
