<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$idOFH = Yii::$app->request->get('OIDH', 'xxx');
?>
<div class="cos-cal-d-index">
    <br>
    <?php
    $sql = new \yii\db\Query;
    $sql->select('od.OfferingDID,
                od.OfferingIDH,
                od.Class,
                ma.Description AreaName')
            ->from(['od' => app\operational\models\OfferingD::tableName()])
            ->leftJoin(['ma' => app\master\models\MasterArea::tableName()], 'ma.AreaID=od.AreaID ')
            ->where('od.OfferingIDH=\'' . $ODH . '\'')
            ->orderBy('od.Class');

    $dataProvider = new \yii\data\ActiveDataProvider(['query' => $sql]);
    $dataProvider->pagination->pageSize = 50;

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}",
        'pjax' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'contentOptions' => ['style' => 'width: 120px;'],
                'label' => 'ID OfferingD',
                'attribute' => 'OfferingDID',
            ],
            'Class',
            'AreaName',
            [
                'header' => 'View Cost Calc',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'value' => function($data) {
            return Html::a('<span class="glyphicon glyphicon-file"></span>', ['offering-d/view-coscal',
                        'OFIH' => Yii::$app->request->get('OIDH', 'xxx'),
                        'OFID' => $data['OfferingDID'],
                        'area' => $data['AreaName'],
                        'class' => $data['Class']
                            ], ['title' => 'View Cost Calc']);
        },
            ],
//            [
//                'header' => 'Edit',
//                'format' => 'raw',
//                'headerOptions' => ['style' => 'text-align:center'],
//                'contentOptions' => ['style' => 'text-align:center'],
//                'value' => function($data) {
//            return Html::a('<span class="glyphicon glyphicon-check"></span>', ['offering-d/edit-coscal',
//                        'OFIH' => Yii::$app->request->get('OIDH', 'xxx'),
//                        'OFID' => $data['OfferingDID']]);
//        },
//            ],
            [
                'header' => 'Edit Cost Calc',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'value' => function($data) use ($SOIDH) {

            if ($SOIDH != NULL) {
                return '-';
            } else {
                return Html::a('<span class="glyphicon glyphicon-check"></span>', ['offering-d/edit-coscal',
                            'OFIH' => Yii::$app->request->get('OIDH', 'xxx'),
                            'OFID' => $data['OfferingDID']], ['title' => 'Edit Cost Calc']);
            }
        },
            ],
            [
                'header' => 'Delete Cost Calc',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'value' => function($data) use ($SOIDH) {

            if ($SOIDH != NULL) {
                return '-';
            } else {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['offering-d/delete-coscal',
                            'IdOfferingH' => Yii::$app->request->get('OIDH', 'xxx'),
                            'IdOfferingD' => $data['OfferingDID']], [
                            'title' => Yii::t('app', 'Delete Cost Calc'),
                            'data-confirm' => 'Are you sure you want to delete this Cost Calc ?',
                                ]
                );
//                return Html::a('<span class="glyphicon glyphicon-check"></span>', ['offering-d/edit-coscal',
//                            'OFIH' => Yii::$app->request->get('OIDH', 'xxx'),
//                            'OFID' => $data['OfferingDID']], ['title' => 'Edit Cost Calc']);
            }
        },
            ],
            [
                'label' => 'Print Cost Calc MAP',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'value' => function($data) {
                    return Html::a('<span class="glyphicon glyphicon-print"></span>', ['exportccmap', 'ofd' => $data['OfferingDID']]);
                },
            ],
            [
                'label' => 'Print Cost Calc SS',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'value' => function($data) {
                    return Html::a('<span class="glyphicon glyphicon-print"></span>', ['exportccss', 'ofd' => $data['OfferingDID']]);
                },
            ],
        ],
    ]);
    ?>
</div>
