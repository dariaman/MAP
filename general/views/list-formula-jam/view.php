<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\general\models\ListFormulaJam */

$this->title = $model->JenisFormulaJam;
$this->params['breadcrumbs'][] = ['label' => 'List Formula Jams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-formula-jam-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'JenisFormulaJam',
            'Description:ntext',
            'UserCrt',
            'DateCrt',
            'UserUpdate',
            'DateUpdate',
        ],
    ]) ?>

</div>
