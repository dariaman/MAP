<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$customer = Yii::$app->request->get('cusid','xxx');
$conversi = new \app\controllers\GlobalFunction();

$mc = \app\master\models\MasterCustomer::find()->where(['CustomerID' => $customer])->one();

$this->title = 'Billing UnCollection';


?>
<div class="absensi-customer-index">
    <div class="se-pre-con" style="display:none;" id="loadingDiv">
    </div>
    <?=Html::beginForm(['billing-outstanding/create-invoice'],'post');?>
    <?=Html::hiddenInput('customerID', $customer); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">Customer ID</td>
                            <td>: <label id="SOIDH"><?= $mc->CustomerID ?> </label></td>
                        </tr>
                        <tr>
                            <td style="width:200px;">Customer Name</td>
                            <td>: <label id="SODID"><?= $mc->CustomerName ?> </label></td>
                        </tr>
                        <tr>
                           <td style="width:200px;">Address</td>
                           <td>: <label id="CusID"><?= $mc->Address ?> </label></td>
                        </tr>
                        <tr>
                           <td style="width:200px;">City</td>
                           <td>: <label id="AreaID"><?= $mc->City ?> </label></td>
                        </tr>
                        <tr>
                           <td style="width:200px;">Zip</td>
                           <td>: <label id="ProductID"><?= $mc->Zip ?> </label></td>
                        </tr>
                        <tr>
                           <td style="width:200px;">Phone</td>
                           <td>: <label id="ProductID"><?= $mc->Phone ?> </label></td>
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
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'pjax'=>false,
                        'columns' => [
                            [
                                'class' => 'kartik\grid\CheckboxColumn',
                                'rowSelectedClass' => GridView::TYPE_DANGER,
                                'checkboxOptions' => function ($model){
                                    return ['value' => $model['TipeBilling']."|".$model['AreaID']."|".$model['Periode']];
                                }
                            ],
                            [
                                'header' => 'Tipe Billing',
                                'value' => 'TipeBilling',
                                'contentOptions'=>['style'=>'width:70px'],
                            ],    
                            [
                                'header' => 'SO Detail',
                                'width'=>'150px',
                                'value' => 'SODID'
                            ],
                            [
                                'header' => 'Area ID',
                                'value' => 'AreaID',
                                'contentOptions'=>['style'=>'width:100px'],
                            ],
                            [
                                'header' => 'Area Name',
                                'value' => 'AreaName'
                            ],                    
                            [
                                'header' => 'Periode',
                                'width'=>'120px',
                                'hAlign'=>'right',
                                'value' => function($data) use($conversi){
                                    return $conversi->PeriodeToPeriodeString($data['Periode']);
                                }
                            ],
                            [
                                'header'=>'Detail',
                                'format' => 'raw',
                                'headerOptions' => ['style'=>'text-align:center'],
                                'contentOptions'=>['style'=>'text-align:center;width:100px;'],
                                'value' => function($data){
                                return Html::a('<span class="glyphicon glyphicon-file"></span>',
                                    ['billing-outstanding/outstanding-detail-by-area',
                                        'cusid' => $data['CustomerID'],
                                        'area' => $data['AreaID'],
                                        'period' => $data['Periode'],
                                        'tipe'=>$data['TipeBilling']]);
                                },
                            ],
                        ],
                    ]);
                    ?>
                </div>
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
                <?= Html::a('Back', ['index'], ['class' =>'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?= Html::endForm();?>
</div>