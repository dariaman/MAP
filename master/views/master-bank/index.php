<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Master Bank';
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);
?>

<div class="master-bank-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?php Pjax::begin(['id'=>'PtlCommentsPjax']);?> 
                <?= $this->render('_search', ['model' => $searchModel]);?>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            'BankID',
                            'BankName',
                            'BankGroupName',            
                            [
                                'class'=>'kartik\grid\BooleanColumn',
                                'attribute'=>'IsActive', 
                                'vAlign'=>'middle'
                            ],
                            [
                                'class'=>'kartik\grid\ActionColumn',
                                'template'=>'{update}',
                                'dropdownOptions'=>['class'=>'pull-right'],
                                'updateOptions'=>['title'=>'Edit', 'data-toggle'=>'tooltip'],
                            ],
                        ],
                    ]); ?>
                </div>
                <?php Pjax::end(); ?> 
            </div>
        </div>
        <div class="col-xs-12">
            <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>
