<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $model app\operational\models\AllocationProductH */

$this->title = $_GET['id'];

$script = <<<SKRIPT
        window.onunload = refreshParent;
        function refreshParent() {
            window.close();
            window.opener.location.reload();
        }
SKRIPT;

$this->registerJs($script);

if (isset($_GET['id'])){
        $idApH = preg_replace('/[^A-Za-z0-9\-]/', '', $_GET['id']);
    }
    else {
        $idApH ='xxx';
    }
    
    $modelAPH = app\operational\models\AllocationProductH::find()
            ->select('*')
            ->from('AllocationProductH aph')
            ->where("aph.AllocationProductIDH ='".$idApH."'")
            ->one();
?>
<div class="allocation-product-h-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <table class="table table-striped table-bordered">
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
                if($modelAPH->Status == 'A')
                {
                    echo 'Approve';
                } else if($modelAPH->Status == 'RFA')
                {
                    echo 'Request for Approval';
                } else if($modelAPH->Status == 'C')
                {
                    echo 'Correction';
                } else {
                    echo 'Draft';
                } ?></td>
        </tr>
    </table>
   <?php
   
        $sql = new yii\db\Query();
        
        $sql->select ('ma.Description as AreaDesc,mj.Description as JobDesc,mp.Nama as Nama,*')
                ->from('AllocationProductDOutstanding apdo')
                ->join('JOIN','SOD','SOD.SODID = apdo.SODID')
                ->join('JOIN','SOH','SOH.SOIDH = SOD.SOIDH')
                ->join('JOIN','OfferingD od','od.OfferingDID = SOD.OfferingDID')
                ->join('JOIN','OfferingH oh','oh.OfferingIDH = od.OfferingIDH')
                ->join('JOIN','MasterProduct mp','mp.ProductID = apdo.ProductID')
                ->join('JOIN','MasterJobDesc mj','mj.IDJobDesc = oh.IDJobDesc')
                ->join('JOIN','MasterArea ma','ma.AreaID = od.AreaID')
            ->where("apdo.AllocationProductIDH = '".$_GET['id']."'")
            ->orderBy(['apdo.AllocationProductIDH'=>SORT_ASC]);
        
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
                'label'=>'License Plate',
                'value' => 'LicensePlate'
            ],
            [
                'label'=>'Tgl Tugas',
                'value' => 'TglTugas'
            ]
        ],
    ]); ?>
    
    <div class="form-group">
            <?= Html::a('Approve',['allocation-product-d/approve','id' => $idApH, 'soidh' => $modelAPH->SOIDH ],['class' => 'btn btn-success' ,'id' => 'app']) ?>
            <?= Html::a('Correction',['allocation-product-d/correction','id' => $idApH ], ['class' => 'btn btn-success','id' => 'corr']) ?>
    </div>
</div>
