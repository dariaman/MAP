<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\finance\models\AccountReceivable */

$this->title = 'Create Receivable Voucher';
?>
<div class="account-receivable-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
