<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\eprocess\models\JadwalAbsensiStatusDSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$cus = app\master\models\MasterCustomer::findOne(['CustomerID'=>$_GET['cusID']]);

$this->title = 'Edit Jadwal Absensi Customer ';
//$this->params['breadcrumbs'][] = $this->title;
$tahun = $_GET['tahun'];
$bulan = $_GET['bulan'];
$idabs = $_GET['id'];
$areaid = $_GET['areaID'];
$cusid = $_GET['cusID'];
$script = <<<SKRIPT
        
$("#close").on('click',function(){
        
        var value = $("[name=selection_all]:checked");
        var arrayval = [];
        var loading = $('#loadingDiv');
        var tahun = $tahun;
        var bulan = '$bulan';
        var idabs = '$idabs';
        var areaid = $areaid;
        var cusid = '$cusid'
        var tipe = $("[name=typeSearch]").val();
        var text = $("[name=textsearch]").val();
        
        if(value.val() == 1)
        {
            
            $(document)
                .ajaxStart(function () {
                loading.show();
            })
        
            $.get('index.php?r=eprocess/jadwal-absensi-status-d/close-all',
                { idthn : tahun,idbln : bulan,idabs : idabs, idarea : areaid ,idcus : cusid, idtipe : tipe, idtext : text});
        
            $(document).ajaxStop(function () {
                loading.hide();
                window.location.reload();
            });
            
            //alert(tahun+","+bulan+","+tipe+","+text);
        
        } else {
        
            $("input:checkbox:checked").each(function(){
                arrayval.push($(this).val());
            });
        
            //alert(array);
        
            var jsonString = JSON.stringify(arrayval);
        
            $(document)
            .ajaxStart(function () {
              loading.show();
            })
        
            $.get('index.php?r=eprocess/jadwal-absensi-status-d/close-partial',
                { idarr : jsonString , idabs : idabs } );
        
            $(document).ajaxStop(function () {
                loading.hide();
                window.location.reload();
            });
        }   
});
        
$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax1')
})

$('.edbutton').on('click',function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
});
SKRIPT;

$this->registerJs($script);
?>
<div class="jadwal-absensi-status-d-index">

    <h1><?= Html::encode($this->title)  ?></h1>
    <h3><?= $cus['CustomerName'] ?></h3>
    <?=  $this->render('_searchProd',['model'=> $searchModel]); ?>
    <?php Pjax::begin(['id' => 'PtlCommentsPjax1']);?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model['ProductID']];
                }
            ],
            [
                'label'=>'Product ID',
                'value'=>'ProductID'
            ],
            [
                'label'=>'Product Name',
                'value'=>'Nama'
            ],
            [
                'label'=>'Status',
                'value'=> function($data)
                {
                    $pr = \app\eprocess\models\JadwalAbsensiStatusD::find()
                            ->select('jad.IsCloseJadwal')
                            ->from('JadwalAbsensiStatusD jad')
                            ->innerJoin('JadwalAbsensiStatusH jas','jas.IDJadwalAbsensiStatusH = jad.IDJadwalAbsensiStatusH')
                            ->where(['jad.ProductID' => $data['ProductID'], 'jas.CustomerID' => $_GET['cusID']])->one();
                    
                    if($pr['IsCloseJadwal'] == 1)
                    {
                        return "Closed";
                    } else {
                        return "-";
                    }
                }
            ],
            [
                'label'=>'Action',
                'format' => 'raw',
                'value' => function($data){
                   $pr = \app\eprocess\models\JadwalAbsensiStatusD::find()
                           ->where(['ProductID' => $data['ProductID']])->one();
                   
                   if($pr['IsCloseJadwal'] != 1)
                   {
                        return Html::a('Edit','./index.php?r=eprocess/jadwal-absensi-status-d/product&pid='.$data['ProductID'].'&idh='.$_GET['id']."&areaid=".$_GET['areaID']."&cusid=".$_GET['cusID']."&tahun=".$_GET['tahun']."&bulan=".$_GET['bulan'],['class'=>'edbutton']); 
                   } else {
                        return " "; 
                   }
                   
                 
                },
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
    <p style="float:left; margin:1%;">
        <?= Html::button('Close Selection',['class' => 'btn btn-success','id'=>'close']) ?>
    </p>
    <p style="float:right; margin-top:1%;">
        <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
    </p>

</div>
