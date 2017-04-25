<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\operational\models\TransactionMaster */

$this->title = 'Create Transaction Master';
$this->params['breadcrumbs'][] = ['label' => 'Transaction Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-master-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
