<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\SOSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Goods Receive';
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlComments1Pjax')
});

$('#getgridid').click(function(){
    var row = $("#idgridsod input[name=GRID]:checked").closest('tr');
        
    $('#deliveryorder-grid').val(row.find("td:nth-child(2)").text());
//    $('#start').val(row.find("td:nth-child(8)").text());
//    $('#end').val(row.find("td:nth-child(9)").text());
//    $('#ofd').val(row.find("td:nth-child(4)").text());
//    $('#area').val(row.find("td:nth-child(5)").text());
//    $('#deliveryorder-qty').val(row.find("td:nth-child(7)").text());
//    $('#allocationproductd-periodto').val(row.find("td:nth-child(9)").text());
    
//    $('#start').trigger('change');
    
//    $.get('index.php?r=operational/allocation-product-d/get-period',{sod:row.find("td:nth-child(2)").text()},function(data)
//        {
//           $("#tgl").html(data); 
//        });   
        
    $('#modalgridlookup').modal('hide');
});
        
        
SKRIPT;

$this->registerJs($script);


$this->title = 'Goods Receive';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="se-pre-con" style="display:none;" id="loadingDiv">
   
</div>
<div class="so-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // print_r('fgh');
//        die(); // echo $this->render('_search', ['model' => $searchModel]); ?>
      <?php Pjax::begin(['id'=>'PtlComments1Pjax']); 
        echo $this->render('_searchsod', ['model' => $searchModel]);
        $sql = new yii\db\Query();
        
        $sql->select ('*')
                ->from('GoodsReceive')
//                ->join('JOIN','OfferingD od','od.OfferingDID = SOD.OfferingDID')
//                ->join('JOIN','OfferingH oh','oh.OfferingIDH = od.OfferingIDH')
//                ->join('JOIN','MasterJobDesc mj','mj.IDJobDesc = oh.IDJobDesc')
//                ->join('JOIN','MasterArea ma','ma.AreaID = od.AreaID')
//            ->where("SOD.SOIDH = '".$_GET['soh']."'")
//            ->orderBy(['SOD.SODID'=>SORT_ASC])
                ;

        $dataProvider = new ActiveDataProvider([
            'query' => $sql,
            'sort' => false
        ]);
        
        ?>
    
 
<div class="output" style="height: 500px; overflow: auto;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' =>['id' => 'idgridsod','class'=>'table table-striped table-bordered'],
//        'pager' => [
//            'firstPageLabel' => 'First',
//            'lastPageLabel' => 'Last',
//        ],
         'columns' => [
            [
                    'label'=>'',
                    'format'=>'raw',
                    'value'=>function ($data) {
                       return Html::radio('GRID', false,['class'=>'of','value'=>$data['GRID']]);
                       
                    },
             ],
            [
                'label'=>'Goods Receive ID',
                'format' => 'raw',
                'value' => 'GRID'
//                'value'=>function($data)
//                {
//                    return Html::a($data['SODID'],'./index.php?r=operational/allocation-product-h/detailsod&id='.$data['SODID'],['class'=>'sodbutton','id'=>'sodid']);
//                }
            ],
            [
                'label' => 'Item ID',
                'value' => 'ItemID'
            ],
            [
                'label' => 'Qty',
                'value' => 'Qty'
            ],
            [
                'label' => 'Harga Satuan',
                'value' => 'HargaSatuan'
            ],
            [
                'label' => 'No PV',
                'value' => 'NoPV'
            ],
            [
                'label' => 'Reference No',
                'value' => 'ReferenceNo'
            ],
            [
                'label' => 'Supplier Name',
                'value' => 'SupplierName'
            ],
            [
                'label' => 'Received Date',
                'value' => 'ReceiveDate'
            ]
            

//       ['class' => 'yii\grid\ActionColumn'],
        ],
    ] 
)
 ;
    ?>
    <p>
        <?= Html::a('Select',NULL, ['class' => 'btn btn-success','id'=>'getgridid']) ?>
        
    </p>
       <?php // print_r($dataProvider);
//    die();
    ?>
     <?php Pjax::end(); ?> 
<!--     Html::a('select', ['index'], ['class' => 'btn btn-primary']); ?>-->

</div>
</div>