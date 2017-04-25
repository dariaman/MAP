<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $model app\operational\models\AllocationProductH */

$this->title = $_GET['id'];

if (isset($_GET['id'])){
        $idApH = preg_replace('/[^A-Za-z0-9\-]/', '', $_GET['id']);
    }
    else {
        $idApH ='xxx';
    }
    
    $modelAPH = app\operational\models\AllocationProductH::find()
            ->select('*,aph.Status as StatusAPH')
            ->from('AllocationProductH aph')
            ->leftJoin('SOH','SOH.SOIDH = aph.SOIDH')
            ->leftJoin('MasterCustomer mc','mc.CustomerID = SOH.CustomerID')
            ->where("aph.AllocationProductIDH ='".$idApH."'")
            ->one();
    
$script = <<<SKRIPT


$('.viewChange').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", 'width='+screen.availWidth-10+',height='+screen.availHeight-55+',scrollbars=yes,location=no');
});

        
SKRIPT;

$this->registerJs($script);
?>
<div class="allocation-product-h-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <table class="table table-striped table-bordered">
        <tr>
            <td style="width:200px;">Customer</td>
            <td>: <label id="SOIDH"><?= $modelAPH->CustomerName ?> </label></td>
        </tr>
        <tr>
            <td style="width:200px;">ID Go Live Header</td>
            <td>: <label id="SOIDH"><?= $idApH ?> </label></td>
        </tr>
        <tr>
            <td style="width:200px;">ID SO Header</td>
            <td>: <label id="SOIDH"><?= $modelAPH->SOIDH ?> </label></td>
        </tr>
        <tr>
            <td>Description</td>
            <td>: <?= $modelAPH->Description ?></td>
        </tr>
        <tr>
            <td>PIC Customer </td>
            <td>: <?= $modelAPH->PicCustomer ?></td>
        </tr>
        <tr>
            <td>Tanggal Surat </td>
            <td>: <?= $modelAPH->TanggalSurat ?></td>
        </tr>
        <tr>
            <td>Status </td>
            <td>: <?php 
                if($modelAPH->StatusAPH == 'A')
                {
                    echo 'Approve';
                } else if($modelAPH->StatusAPH == 'RFA')
                {
                    echo 'Request for Approval';
                } else if($modelAPH->StatusAPH == 'C')
                {
                    echo 'Correction';
                } else {
                    echo 'Draft';
                } ?></td>
        </tr>
    </table>
   <?php
   
        $sql = new yii\db\Query();
        
        $sql->select ('ma.Description as AreaDesc,mj.Description as JobDesc,mp.Nama as Nama,apd.Status as sta,*')
                ->from('AllocationProductD apd')
                ->leftJoin('SOD','SOD.SODID = apd.SODID')
                ->leftJoin('SOH','SOH.SOIDH = SOD.SOIDH')
                ->leftJoin('OfferingD od','od.OfferingDID = SOD.OfferingDID')
                ->leftJoin('OfferingH oh','oh.OfferingIDH = od.OfferingIDH')
                ->leftJoin('MasterProduct mp','mp.ProductID = apd.ProductID')
                ->leftJoin('MasterJobDesc mj','mj.IDJobDesc = oh.IDJobDesc')
                ->leftJoin('MasterArea ma','ma.AreaID = od.AreaID')
            ->where("apd.AllocationProductIDH = '".$_GET['id']."'")
            ->orderBy(['apd.AllocationProductIDH'=>SORT_ASC]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $sql,
            'sort' => false
        ]);
    
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax'=>false,
        'columns' => [
            [
                'label'=>'Go Live ID Detail',
                'value' => 'AllocationProductDID'
            ],
            [
                'label'=>'SO ID Detail',
                'value' => 'SODID'
            ],
            [
                'label'=>'Offering ID Detail',
                'value' => 'OfferingDID'
            ],
            [
                'label'=>'Area',
                'value' => 'AreaDesc'
            ], 
            [
                'label'=>'Job Desc',
                'value' => 'JobDesc'
            ],
            [
                'label'=>'Product',
                'value' => 'Nama'
            ],
            [
                'label'=>'Area Detail',
                'value' => 'AreaDetailDesc'
            ],
              [
                'label'=>'Pending Product',
                'value' => 'PendingProduct'
            ],
            [
                'label'=>'Status',
                'value' => 'sta'
            ],
            [
                'label'=>'License Plate',
                'value' => 'LicensePlate'
            ],
            [
                'label'=>'Tgl Tugas',
                'value' => 'TglTugas'
            ],
//            [
//                'label'=>'Action',
//                'format' => 'raw',
//                'value' => function($data){
//                
//                    $checkrfa = app\operational\models\AllocationProductH::find()
//                            ->where(['AllocationProductIDH' => $data['AllocationProductIDH']])
//                            ->one();
//
//                    if($checkrfa['Status'] == 'RFA')
//                    {
//                        return '-';
//                    } else {
//                       return Html::a('Delete','./index.php?r=operational/allocation-product-d/del&idh='.$data['AllocationProductIDH'].'&sodid='.$data['SODID'].'&prid='.$data['ProductID']);
//                    }
//                },
//            ],
            [
                'header'=>'Change',
                'format' => 'raw',
                'headerOptions' => ['style'=>'text-align:center','width:50px;'],
                'contentOptions'=>['style'=>'text-align:center'],
                'value' => function($data){
                    
                        $checkrfa = app\operational\models\AllocationProductH::find()
                                ->where(['AllocationProductIDH' => $data['AllocationProductIDH']])
                                ->one();
                        
                        if($checkrfa['Status'] == 'A')
                        {
                            return Html::a('<span class="glyphicon glyphicon-user"></span>',
                            ['allocation-product-d/change-product','id' => $data['AllocationProductDID'],'idaph' => $data['AllocationProductIDH']]); 
                            
                        } else {
                           return '-';
                        }
                },
            ] 
        ],
    ]); ?>
    <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
</div>
