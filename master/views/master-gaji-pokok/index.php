<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Master UMP';

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);
?>
<div class="master-gaji-pokok-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>    
                </div>
                <?php Pjax::begin(['id' => 'PtlCommentsPjax']); ?>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
                <div class="box-body">
                <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
//                            [
//                                'contentOptions' => ['style' => 'width: 150px;'],
//                                'label' => 'ID GAPOK',
//                                'format' => 'raw',
//                                'value' => 'GapokID'
//                            ],
//                            ['label' => 'Seq ID', 'value' => 'SeqID', 'contentOptions' => ['style' => 'width:50px;']],
                            ['label' => 'Job Desc', 'value' => 'JobDesc'],
                            ['label' => 'Area', 'value' => 'AreaName'],
                            [
                                'label' => 'UMP (per Bulan)',
                                'value' => 'UMP',
                                'format' => ['decimal', 2],
                                'contentOptions' => ['style' => 'width: 150px;']
                            ],
                            [
                                'label' => 'GSFee (per hari)',
                                'value' => 'GSFee',
                                'format' => ['decimal', 2],
                                'contentOptions' => ['style' => 'width: 150px;']
                            ],
                            [
                                'label' => 'Update',
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width: 50px;', 'Align' => 'middle'],
                                'value' => function ($data) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['master-gaji-pokok/update', 'gapokid' => $data['GapokID'], 'seqID' => $data['SeqID']]);
                        },
                            ],
                        ],
                    ]);
                    ?>    
                </div>
                <?php Pjax::end(); ?>
            </div>
        </div>
        <div class="col-xs-12">
            <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>
