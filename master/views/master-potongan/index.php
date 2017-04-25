<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Master Potongan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-potongan-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
                <div class="box-body">
                <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'contentOptions'=>['style'=>'width: 150px;'],
                                'label' => 'ID Potongan',
                                'format' => 'raw',
                                'value' => 'IDPotongan'
                            ],
                            'Description',
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
                <?php Pjax::end();?>
            </div>
        </div>
        <div class="col-xs-12">
            <p>
                <?= Html::a('add', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    </div>
</div>
