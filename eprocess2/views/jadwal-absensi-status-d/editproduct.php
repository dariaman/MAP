<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;

$this->title = 'Edit Product Absensi';

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

$('.edbutton').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
});
SKRIPT;

$this->registerJs($script);

?>
<div class="jadwal-kerja-index">

    <h1><?= Html::encode($this->title) ?></h1>
        
    <?= 
    
        DetailView::widget([
        'model' => $model,
        'attributes' => [
           
            'ProductID:raw:Product ID',
            'Nama:raw:Product Name',

        ],
    ]) ?>
 
    <?php
    
//    $query = app\master\models\MasterJadwalKerja::find()
//            ->select('*')
//            ->from('MasterJadwalKerja mj')
//            ->leftJoin('JadwalAbsensiStatusH jas','jas.CustomerID = mj.CustomerID')
//            ->leftJoin('MasterCustomer mc','mc.CustomerID = mj.CustomerID')
//            ->leftJoin('MasterAbsenType mat','mat.ID = mc.IDAbsenType')
//            ->where(['mj.ProductID'=>$_GET['pid'],'jas.Thn'=>$_GET['tahun'],'jas.Bln'=>$_GET['bulan'],'mj.CustomerID'=>$_GET['cusid']])
//            ->orderBy(['Tgl'=>SORT_ASC]);
    
            $getStartEnd = Yii::$app->db->createCommand("
                
            select  tglStartAbsen=case when at.StartAbsen='01' then jh.Thn + '-' + jh.Bln + '-' + at.StartAbsen
                                        else convert(varchar(10),DATEADD(MONTH,-1, jh.Thn + jh.Bln + at.StartAbsen),121)
                                        end,
                    tglEndAbsen=case when at.StartAbsen='01' then jh.Thn + '-' + jh.Bln + '-' + cast(DATEPART(DAY,EOMONTH(jh.Thn + jh.Bln + at.StartAbsen) ) as char(2))
                                        else jh.Thn + '-' + jh.Bln + '-' + at.EndAbsen end,
            jd.ProductID 
            from JadwalAbsensiStatusD jd
            left join JadwalAbsensiStatush jh on jh.IDJadwalAbsensiStatusH=jd.IDJadwalAbsensiStatusH
            left join MasterCustomer mc on mc.CustomerID=jh.CustomerID
            left join MasterAbsenType at on at.ID=mc.IDAbsenType
            where jd.ProductID='".$_GET['pid']."' and jh.Bln='".$_GET['bulan']."' and jh.Thn ='".$_GET['tahun']."' and jh.CustomerID = '".$_GET['cusid']."'")->queryOne();
        
            $query = \app\master\models\MasterJadwalKerja::find()
                    ->where("ProductID ='".$_GET['pid']."' and Tgl >= '".$getStartEnd['tglStartAbsen']."' and Tgl <= '".$getStartEnd['tglEndAbsen']."'");
            
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);
        
        $count = \app\master\models\MasterJadwalKerja::find()
                ->select(['COUNT(*) AS ProductID'])
                ->from('MasterJadwalKerja')
                ->where("ProductID ='".$_GET['pid']."' and Tgl >= '".$getStartEnd['tglStartAbsen']."' and Tgl <= '".$getStartEnd['tglEndAbsen']."'")
                ->one();

        $dataProvider->pagination->pageSize=$count['ProductID'];
    ?>
                    
                <?php
//                print_r($dataProvider);
//                die(); 
                ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [           
            [
                'label'=>'Tgl',
                'value'=> function($data)
                {
                    $totime = strtotime($data['Tgl']);
                    $newdate = date('d',$totime);
                    return $newdate;
                }
            ],
            [
                'label'=>'Jam Masuk',
                'value'=>'JadwalMasuk'
            ],
            [
                'label'=>'Jam Keluar',
                'value'=>'JadwalKeluar'
            ],
           
            [
                'label'=>'Action',
                'format' => 'raw',
                'value' => function($data){
                   return Html::a('Edit','./index.php?r=eprocess/jadwal-absensi-status-d/editp&pid='.$data['ProductID'].'&tgl='.$data['Tgl'].'&cusid='.$data['CustomerID'].'&tahun='.$_GET['tahun'].'&bulan='.$_GET['bulan'],['class'=>'edbutton']);
                 
                },
            ],
            //
        ],
    ]); ?>
    
    
</div>
