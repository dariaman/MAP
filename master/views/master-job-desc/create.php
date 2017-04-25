<?php

use yii\helpers\Html;

$this->title = 'Master Job Description';

?>
<div class="master-job-desc-create">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
