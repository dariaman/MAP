<?php

use yii\helpers\Html;

$this->title = 'Cost Calculation';
?>
<div class="cos-cal-h-create">

    <h1><center><?= Html::encode($this->title) ?></center></h1>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
