<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\Masterproduct */

$this->title = 'Input Master Product';
//$this->params['breadcrumbs'][] = ['label' => 'Masterproducts', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masterproduct-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
