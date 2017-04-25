<?php
    use yii\helpers\Html;
    $this->title = 'Master Area';
?>
<div class="master-area-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
