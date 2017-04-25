<?php

use yii\helpers\Html;
use app\operational\models\GoLiveProductHistory;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$sodid = Yii::$app->request->get('sodid');
$seqid = Yii::$app->request->get('seqid');

$this->title = 'History of Sequence Product';
                        
?>

<div class="sod-form">
   <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <p style="text-align:center">Sequence Product : <?= Html::encode($seqid) ?></p>
                    <?php
                        $sql = new \yii\db\Query;
                        $sql->select('gh.ProductID,mp.Nama,gh.PeriodFrom,gh.PeriodTo,gh.Status as status, mp.Status as StatusProduct')
                                ->from(['gh' => app\operational\models\GoLiveProductHistory::tableName()])
                                ->leftJoin(['mp' => app\master\models\MasterProduct::tableName()], 'mp.ProductID = gh.ProductID')
                                ->where('gh.SODID=\'' . $sodid . '\' and gh.SeqProduct = ' . $seqid . '')
                                ->orderBy('gh.PeriodTo ASC ');
                        
                        $dataProvider = new \yii\data\ActiveDataProvider(['query' => $sql]);
                        $dataProvider->pagination->pageSize = 50;
                       echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'Nama',
                                'PeriodFrom',
                                'PeriodTo',
                                [
                                    'header' => 'Status Golive',
                                    'format' => 'raw',
                                    'value' => function($data)
                                    {
                                        if($data['status'] == 'A')
                                        {
                                            return '<span class="label label-success">Approved</span>';
                                        } 
                                            else if ($data['status'] == 'RFA')
                                        {
                                            return '<span class="label label-primary">Pending</span>';
                                        }
                                            else if ($data['status'] == 'EC')
                                        {
                                            return '<span class="label label-default">END CONTRACT</span>';
                                        }
                                            else if ($data['status'] == 'REC')
                                        {
                                            return '<span class="label label-warning">REQUEST END CONTRACT</span>';
                                        }
                                            else if ($data['status'] == 'ET')
                                        {
                                            return '<span class="label label-danger">Terminated</span>';
                                        }else {
                                            return $data['status'];
                                        }
                                    }
                                ],
                                [
                                    'header' => 'Status Product',
                                    'format' => 'raw',
                                    'value' => function($data)
                                    {
                                        if($data['StatusProduct'] == 'FIX')
                                        {
                                            return '<span class="label label-success">FIX</span>';
                                        } else if ($data['StatusProduct'] == 'GS')
                                        {
                                            return '<span class="label label-danger">GS</span>';
                                        }else {
                                            return $data['StatusProduct'];
                                        }
                                    }
                                ],
                            ],
                     ]); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
            <?= Html::a('Back', '', ['class' => 'btn btn-success', 'onclick' => "window.history.back(); "]) ?>
            </div>
        </div>
    </div>
    
</div>
