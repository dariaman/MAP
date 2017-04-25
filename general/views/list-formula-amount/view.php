<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\general\models\ListFormulaAmount */

$this->title = $model->JenisFormulaAmount;
$this->params['breadcrumbs'][] = ['label' => 'List Formula Amounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-formula-amount-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'JenisFormulaAmount',
            'Description:ntext',
            'UserCrt',
            'DateCrt',
            'UserUpdate',
            'DateUpdate',
        ],
    ]) ?>

</div>
