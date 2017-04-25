<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = $model->TransID;

?>
<div class="transaction-master-view">

    <h1><?= Html::encode($this->title) ?></h1>    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'TransID',
            'Transtype',
            'PIC',
            'NextPIC',
            'Status',
            'Reason',
            'usercrt',
            'datecrt',
            'LastUpdateBy',
            'LastUpdateOn',
            'ApproveBy',
            'ApproveDate',
        ],
    ]) ?>

</div>