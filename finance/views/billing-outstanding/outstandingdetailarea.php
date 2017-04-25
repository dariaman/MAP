<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$customer = Yii::$app->request->get('cusid','xxx');
$area = Yii::$app->request->get('area','xxx');
$tipe = Yii::$app->request->get('tipe','xxx');
$periode = Yii::$app->request->get('period','xxx');

$mc = \app\master\models\MasterCustomer::find()->where(['CustomerID' => $customer])->one();
$ma = \app\master\models\MasterArea::find()->where(['AreaID' => $area])->one();
$globalFungsi = new \app\controllers\GlobalFunction();

$this->title = 'Billing UnCollection';

?>
<div class="absensi-customer-index">
    <div class="se-pre-con" style="display:none;" id="loadingDiv">
    </div>
    <?=Html::beginForm(['billing-outstanding/create-invoice-product','cust' => $customer,'tipe' => $tipe,'area' => $area,'periode' => $periode],'post');?>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:150px;">Customer ID</td>
                            <td>: <?= $mc->CustomerID ?></td>
                        </tr>
                        <tr>
                            <td>Customer Name</td>
                            <td>: <?= $mc->CustomerName ?></td>
                        </tr>
                        <tr>
                           <td>Tipe Billing</td>
                           <td>: <?= $tipe ?></td>
                        </tr>
                        <tr>
                           <td>AreaID</td>
                           <td>: <?= $ma->AreaID ?></td>
                        </tr>
                        <tr>
                           <td>Area Name</td>
                           <td>: <?= $ma->Description ?></td>
                        </tr>
                        <tr>
                           <td>Periode</td>
                           <td>: <?= $globalFungsi->PeriodeToPeriodeString($periode) ?></td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode('List Billing') ?></h1>
                </div>
                <?php Pjax::begin(['id' => 'PtlCommentsPjax2']);?>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'pjax'=>false,
                        'columns' => [
                            [
                                'class' => 'kartik\grid\CheckboxColumn',
                                'rowSelectedClass' => GridView::TYPE_DANGER,
                                'checkboxOptions' => function ($model){
                                    return ['value' => $model['BillingNo']];
                                }
                            ],
                            [
                                'header' => 'Billing No',
                                'value' => 'BillingNo'
                            ],
                            [
                                'header' => 'Product Name',
                                'value' => 'Nama'
                            ],
                            [
                                'header' => 'DPP',
                                'value' => 'DPP',
                                'contentOptions'=>['style'=>'text-align:right;'],
                                'format' => 'Currency'
                            ],
                            [
                                'header' => 'Management Fee',
                                'value' => 'MgmFee',
                                'contentOptions'=>['style'=>'text-align:right;'],
                                'format' => 'Currency'
                            ],
                            [
                                'header' => 'PPN',
                                'value' => 'PPN',
                                'contentOptions'=>['style'=>'text-align:right;'],
                                'format' => 'Currency'
                            ],
                            [
                                'header' => 'PPH23',
                                'value' => 'PPH23',
                                'contentOptions'=>['style'=>'text-align:right;'],
                                'format' => 'Currency'
                            ],
                            [
                                'header' => 'Total',
                                'value' => 'TotalInvoice',
                                'contentOptions'=>['style'=>'text-align:right;'],
                                'format' => 'Currency'
                            ]
                        ],
                    ]);
                    ?>
                </div>
                <?php Pjax::end(); ?>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::submitButton('Create Invoice', ['class' =>'btn btn-success',
                                    'onclick'=>"
                                            var keys = $('#w0.grid-view').yiiGridView('getSelectedRows');
                                            if(keys==''){ 
                                                alert('Tidak ada data yang dipilih');
                                                return false;
                                            }
                                    "]) ?>
                <?= Html::a('Back', ['billing-outstanding/outstanding-detail-by-customer','cusid' => $customer], ['class' =>'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?= Html::endForm();?>
    <?php //$this->render('_searchProd',['model'=> $searchModel]); ?>
</div>