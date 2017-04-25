<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\operational\models\ProductPKWT */

$this->title = 'Update Product Pkwt: ' . $model->ProductID;
$this->params['breadcrumbs'][] = ['label' => 'Product Pkwts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProductID, 'url' => ['view', 'id' => $model->ProductID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-pkwt-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
