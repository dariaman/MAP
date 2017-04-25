<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\operational\models\TransactionMaster;
/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\TransactionMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Pending Request';

$ID = Yii::$app->user->identity->username;

$script = <<<SKRIPT

$('.btnView').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
});
        
SKRIPT;

$this->registerJs($script);

$RFA = TransactionMaster::find()->where(['Status' => 'RFA'])->all();
$RFASO = TransactionMaster::find()->where(['Transtype' => 'SO000001'])->all();
$RFAChangeSO = TransactionMaster::find()->where(['Transtype' => 'SO000002'])->all();
$RFASlot = TransactionMaster::find()->where(['Transtype' => 'SO000003'])->all();
$RFASOH = TransactionMaster::find()->where(['Transtype' => 'SO000004'])->all();
$RFAOff = TransactionMaster::find()->where(['Transtype' => 'OF000001'])->all();
$RFAGolive = TransactionMaster::find()->where(['Transtype' => 'ET000001'])->all();
$RFASOD = TransactionMaster::find()->where(['Transtype' => 'SO000005'])->all();

$countRFA = count($RFA);
$countRFASO = count($RFASO);
$countRFAChangeSO = count($RFAChangeSO);
$countRFAOff = count($RFAOff);
$countRFAGolive = count($RFAGolive);
$countRFASlot = count($RFASlot);
$countRFASOH = count($RFASOH);
$countRFASOD = count($RFASOD);
?>
<div class="transaction-master-index">
    <div class="row">
        <div class="col-md-2">
            <div class="box box-solid">
        <!--      <div class="box-header with-border">
                <h3 class="box-title">Folders</h3> 
               <div class="box-tools">
                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div> 
              </div> -->
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                      <?php if($ID == 'APMK07001'){ ?>
                        <li><a href="./index.php?r=operational/transaction-master/of"><i class="fa fa-inbox"></i> Offering <span class="label label-primary pull-right"><?= $countRFAOff ?></span></a></li>
                      <?php } else if ($ID == 'APMK09001'){ ?>
                        <li><a href="./index.php?r=operational/transaction-master/of"><i class="fa fa-inbox"></i> Offering <span class="label label-primary pull-right"><?= $countRFAOff ?></span></a></li>
                        <li><a href="./index.php?r=operational/transaction-master/so"><i class="fa fa-envelope-o"></i> SO <span class="label label-success pull-right"><?= $countRFASO ?></span></a></li>
                        <li><a href="./index.php?r=operational/transaction-master/cc"><i class="fa fa-money"></i> Change Cost Calc <span class="label label-warning pull-right"><?= $countRFAChangeSO ?></span></a></li>
                        <li><a href="./index.php?r=operational/transaction-master/pr"><i class="fa fa-user"></i> ET Product <span class="label label-danger pull-right"><?= $countRFAGolive ?></span></a></li>
                        <li><a href="./index.php?r=operational/transaction-master/sl"><i class="fa fa-users"></i> Slot Product <span class="label label-info pull-right"><?= $countRFASlot ?></span></a></li>
<!--                        <li><a href="./index.php?r=operational/transaction-master/ec"><i class="glyphicon glyphicon-send"></i> End Contract SOH <span class="label label-default pull-right"><?= $countRFASOH ?></span></a></li>
                        <li><a href="./index.php?r=operational/transaction-master/ecsod"><i class="glyphicon glyphicon-send"></i> End Contract SOD <span class="label label-default pull-right"><?= $countRFASOD ?></span></a></li>-->
                      <?php } else { ?> 
                        <li><a href="./index.php?r=operational/transaction-master/of"><i class="fa fa-inbox"></i> Offering <span class="label label-primary pull-right"><?= $countRFAOff ?></span> </a></li>
                        <li><a href="./index.php?r=operational/transaction-master/so"><i class="fa fa-envelope-o"></i> SO <span class="label label-success pull-right"><?= $countRFASO ?></span></a></li>
                        <li><a href="./index.php?r=operational/transaction-master/cc"><i class="fa fa-money"></i> Change Cost Calc <span class="label label-warning pull-right"><?= $countRFAChangeSO ?></span></a></li>
                        <li><a href="./index.php?r=operational/transaction-master/pr"><i class="fa fa-user"></i> ET Product <span class="label label-danger pull-right"><?= $countRFAGolive ?></span></a></li>
                        <li><a href="./index.php?r=operational/transaction-master/sl"><i class="fa fa-users"></i> Slot Product <span class="label label-info pull-right"><?= $countRFASlot ?></span></a></li>
<!--                        <li><a href="./index.php?r=operational/transaction-master/ec"><i class="glyphicon glyphicon-send"></i> End Contract SOH <span class="label label-default pull-right"><?= $countRFASOH ?></span></a></li>
                        <li><a href="./index.php?r=operational/transaction-master/ecsod"><i class="glyphicon glyphicon-send"></i> End Contract SOD <span class="label label-default pull-right"><?= $countRFASOD ?></span></a></li>-->
                      <?php }?>
<!--                      <li><a href="#"><i class="fa fa-file-text-o"></i> Go Live</a></li>
                      <li><a href="#"><i class="fa fa-filter"></i> Change SO </a></li>-->
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /. box -->
        </div>
        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            'TransID',
                            'Transtype',
                            'PIC',
                            'CustomerName',
                            ['attribute' => 'Job Desc','value' =>  'Description'],
                            //'NextPIC',
                            [
                                'header' => 'Status',
                                'format' => 'raw',
                                'value' => function($data)
                                {
                                    if($data['Status'] == 'RFA')
                                    {
                                        return '<span class="label label-primary">Request for Approval</span>';
                                    } else {
                                        return $data['Status'];
                                    }
                                }
                            ],
                            'Reason',
                            [
                                'label'=>'Action',
                                'format' => 'raw',
                                'headerOptions' => ['style'=>'text-align:center'],
                                'contentOptions'=>['style'=>'text-align:center'],
                                'value' => function($data){
                                   return Html::a('<span class="glyphicon glyphicon-check"></span>',
                                            ['view','Transtype' => $data['Transtype'],'TransID' => $data['TransID']]);
                                },
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
</div>
