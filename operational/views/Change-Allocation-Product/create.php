<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\operational\models\ChangeAllocationProduct */

$this->title = 'Change Go Live Product';
//$this->params['breadcrumbs'][] = ['label' => 'Change Allocation Products', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="change-allocation-product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
