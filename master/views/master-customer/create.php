<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterCustomer */

$this->title = 'Input Master Customer';
//$this->params['breadcrumbs'][] = ['label' => 'Master Customers', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-customer-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
