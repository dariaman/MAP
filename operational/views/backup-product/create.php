<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\operational\models\BackupProduct */

$this->title = 'Create Backup Product';
$this->params['breadcrumbs'][] = ['label' => 'Backup Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="backup-product-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
