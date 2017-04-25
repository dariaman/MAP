<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Jadwal Kerja';

$idJadwal = Yii::$app->request->get('idJadwal','xx');
$conversi = new \app\controllers\GlobalFunction();

$sql="select jh.CustomerID,mc.CustomerName,jh.AreaID,
    ma.Description AreaName,jh.Thn,jh.Bln,mb.StartAbsen,mb.EndAbsen
    from JadwalAbsensiStatusH jh
    left join MasterCustomer mc on mc.CustomerID=jh.CustomerID
    left join MasterAbsenType mb on mb.ID=mc.IDAbsenType
    left join MasterArea ma on ma.AreaID=jh.AreaID
    where jh.IDJadwalAbsensiStatusH='$idJadwal'";
$cus = Yii::$app->db->createCommand($sql)->queryAll();

if($cus[0]['StartAbsen']=='01'){
    $startabsen = $cus[0]['Thn'].'-'.$cus[0]['Bln'].'-'.$cus[0]['StartAbsen'];
    if($cus[0]['Bln'] != '02')
    {
        $endabsen = date("Y-m-t", strtotime($cus[0]['Thn'] . '-' . $cus[0]['Bln'] . '-' . $cus[0]['EndAbsen']));
    } else {
        $endofmth = date('t',strtotime($cus[0]['Thn'] . '-' . $cus[0]['Bln'] . '-' . $cus[0]['StartAbsen']));
        $endabsen = date("Y-m-t", strtotime($cus[0]['Thn'] . '-' . $cus[0]['Bln'] . '-' . $endofmth));
    }
}else{
    $startabsen = $cus[0]['Thn'].'-'.($cus[0]['Bln']-1).'-'.$cus[0]['StartAbsen'];
    $endabsen = $cus[0]['Thn'].'-'.$cus[0]['Bln'].'-'.$cus[0]['EndAbsen'];
}

?>
<div class="absensi-customer-index">
    <?=Html::beginForm(['jadwal-absensi-status-h/close-per-product'],'post');?>
    <?=Html::hiddenInput('bln',Yii::$app->request->post('tahun',date('m')) ) ?>
    <?=Html::hiddenInput('thn',Yii::$app->request->post('bulan',date('o')) ) ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?= $this->render('_searchProd',['model'=> $searchModel]); ?>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">CustomerID</td>
                            <td>: <?= $cus[0]['CustomerID']?></td>
                        </tr>
                        <tr>
                            <td>Customer Name </td>
                            <td>: <?= $cus[0]['CustomerName']?></td>
                        </tr>
                        <tr>
                            <td>Periode</td>
                            <td>: <?= $conversi->PeriodeToPeriodeString($cus[0]['Thn'].$cus[0]['Bln']) ?></td>
                        </tr>
                        <tr>
                            <td>Start Absen</td>
                            <td>: <?= $startabsen ?></td>
                        </tr>
                        <tr>
                            <td>End Absen</td>
                            <td>: <?= $endabsen ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode("List ManPower") ?></h1>
                </div>
                <div class="box-body">
                    <?php 
                        $sql = new \yii\db\Query;
                            $sql->select('jas.* , jad.SODID , jad.SeqProductID')
                                ->from(['jas' => app\eprocess\models\JadwalAbsensiStatusH::tableName()])                
                                ->leftJoin(['jad' => \app\eprocess\models\JadwalAbsensiStatusD::tableName()],'jad.IDJadwalAbsensiStatusH = jas.IDJadwalAbsensiStatusH')
                                ->where('jas.IDJadwalAbsensiStatusH=\''.$idJadwal.'\'' );

                            $dataProvider = new \yii\data\ActiveDataProvider (['query' => $sql ]);
                            $dataProvider->pagination->pageSize=50;

                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'layout'=>"{items}",
                            'pjax' => false,
                            'columns' => [
                                [
                                   'class' => 'yii\grid\CheckboxColumn',
                                   'checkboxOptions' => function ($model) {
                                        return ['value' => $model['SODID']];
                                    }
                                ],
                                [
                                    'label'=>'SODID',
                                    'value'=>'SODID'
                                ],
                    //            [
                    //                'label'=>'Product Name',
                    //                'value'=>'Nama'
                    //            ],
                                [
                                    'label'=>'SeqProductID',
                                    'value'=>'SeqProductID'
                                ],
                                [
                                    'label'=>'IsClose Jadwal',
                                    'width'=>'100px',
                                    'hAlign'=>'center',
                                    'class'=>'kartik\grid\BooleanColumn',
                                    'attribute'=>'IsCloseJadwal',
                                ],
                                [
                                    'label'=>'CloseJadwal Date',
                                    'value'=>'CloseJadwalDate',
                                    'width'=>'200px',
                                    'format'=>['date', 'php:d M Y  H:i']
                                ],
                                [
                                    'label'=>'Edit',
                                    'format' => 'raw',
                                    'width'=>'100px',
                                    'hAlign'=>'center',
                                    'value' => function($data) use ($startabsen,$endabsen){
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                            ['product',
                                                'idjadwal' => $data['IDJadwalAbsensiStatusH'],
                                                'sodid' => $data['SODID'],
                                                'rqid' => $data['SeqProductID'],
                                                'start'=>$startabsen,
                                                'end'=>$endabsen
                                                ]);
                                    },
                                ],
                                /*            [
                                    'label'=>'Print Cost Calc',
                                    'format' => 'raw',
                                    'headerOptions' => ['style'=>'text-align:center'],
                                    'contentOptions'=>['style'=>'text-align:center'],
                                    'value' => function($data){
                                       return Html::a('<span class="glyphicon glyphicon-print"></span>',
                                                ['exportcc','ccid' => $data['CostcalIDH'],'ofd' => $data['OfferingDID']]);
                                    },
                                ], */
                            ],
                        ]); 
                        ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::submitButton('Close', ['class' =>'btn btn-primary',
                                       'onclick'=>"
                                               var keys = $('#w1.grid-view').yiiGridView('getSelectedRows');
                                               if(keys==''){ 
                                                   alert('Tidak ada data yang dipilih');
                                                   return false;
                                               }
                                       "]) ?>

               <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>   
            </div>
        </div>
    </div>
    <?= Html::endForm();?>
</div>
