<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;


$this->title = 'Master Job Description';

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;
$this->registerJs($script);
?>
<div class="master-job-desc-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?php Pjax::begin(['id'=>'PtlCommentsPjax']); ?>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,       
                        'layout'=>'{items}',
                        'columns' => [
                            [
                                'contentOptions'=>['style'=>'width: 200px;'],
                                'label' => 'ID Job Description',
                                'format' => 'raw',
                                'value' => 'IDJobDesc'
                            ],
                            [
                                'format' => 'raw',
                                'label' => 'Job Description',
                                'value' => 'Description'
                            ],
                            [
                                'contentOptions'=>['style'=>'width: 150px;'],
                                'format' => 'raw',
                                'label' => 'Code',
                                'value' => 'Code'
                            ],
                            [
//                                'class'=>'kartik\grid\BooleanColumn',
                                'header' => 'Status',
                                'format' => 'raw',
                                'value'=>function($data)
                                {
                                    if($data['IsActive'] == 1)
                                    {
                                        return '<span class="label label-success">Active</span>';
                                    } else {
                                        return '<span class="label label-danger">Not Active</span>';
                                    }
                                }
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

<?php

$script = <<<SKRIPT

$(document).ready(function($){
    $("#Search").on('click', function(event){
         event.preventDefault();
         $("#searchmasterjobdesc").submit();
    });
})
SKRIPT;

$this->registerJs($script);

?> 
