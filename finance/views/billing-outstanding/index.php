<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Billing UnCollection';

?>
<div class="billing-outstanding-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'kartik\grid\SerialColumn',
                                'contentOptions'=>['style'=>'width:100px'],
                                ],            
                            [
                                'header'=>'Customer ID',
                                'format' => 'raw',
                                'contentOptions'=>['style'=>'width:200px'],
                                'value'=>function($data){
                                    return Html::a($data['CustomerID'], ['billing-outstanding/outstanding-detail-by-customer', 'cusid'=>$data['CustomerID']]); 
                                }
                            ],
                            [
                                'header' => 'Customer Name',
                                'value' => 'CustomerName'
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
</div>
