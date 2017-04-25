<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\SOSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'SO';
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
});

$('#getSOid').click(function(){
    var row = $("#idgridsod input[name=SODID]:checked").closest('tr');
        
    $('#deliveryorder-sodid').val(row.find("td:nth-child(2)").text());
//    $('#start').val(row.find("td:nth-child(8)").text());
//    $('#end').val(row.find("td:nth-child(9)").text());
//    $('#ofd').val(row.find("td:nth-child(4)").text());
//    $('#area').val(row.find("td:nth-child(5)").text());
    $('#deliveryorder-qty').val(row.find("td:nth-child(7)").text());
//    $('#allocationproductd-periodto').val(row.find("td:nth-child(9)").text());
    
//    $('#start').trigger('change');
    
//    $.get('index.php?r=operational/allocation-product-d/get-period',{sod:row.find("td:nth-child(2)").text()},function(data)
//        {
//           $("#tgl").html(data); 
//        });   
        
    $('#modalsodlookup').modal('hide');
});
        
        
SKRIPT;

$this->registerJs($script);


$this->title = 'SO';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="se-pre-con" style="display:none;" id="loadingDiv">
   
</div>
<div class="so-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // print_r('fgh');
//        die(); // echo $this->render('_search', ['model' => $searchModel]); ?>
      <?php Pjax::begin(['id'=>'PtlCommentsPjax']); 
        echo $this->render('_searchsod', ['model' => $searchModel]);
        $sql = new yii\db\Query();
        
        $sql->select ('ma.Description as AreaDesc,mj.Description as JobDesc,SOD.Status as Stats,*')
                ->from('SOD')
                ->join('JOIN','OfferingD od','od.OfferingDID = SOD.OfferingDID')
                ->join('JOIN','OfferingH oh','oh.OfferingIDH = od.OfferingIDH')
                ->join('JOIN','MasterJobDesc mj','mj.IDJobDesc = oh.IDJobDesc')
                ->join('JOIN','MasterArea ma','ma.AreaID = od.AreaID')
//            ->where("SOD.SOIDH = '".$_GET['soh']."'")
            ->orderBy(['SOD.SODID'=>SORT_ASC]);

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
                       return Html::radio('SODID', false,['class'=>'of','value'=>$data['SODID']]);
                       
                    },
             ],
            [
                'label'=>'SO ID Detail',
                'format' => 'raw',
                'value' => 'SODID'
//                'value'=>function($data)
//                {
//                    return Html::a($data['SODID'],'./index.php?r=operational/allocation-product-h/detailsod&id='.$data['SODID'],['class'=>'sodbutton','id'=>'sodid']);
//                }
            ],
            [
                'label' => 'SO ID Header',
                'value' => 'SOIDH'
            ],
            [
                'label' => 'Offering Detail',
                'value' => 'OfferingDID'
            ],
            [
                'label' => 'Area',
                'value' => 'AreaDesc'
            ],
            [
                'label' => 'Job Desc',
                'value' => 'JobDesc'
            ],
            [
                'label' => 'Quantity',
                'value' => 'Qty'
            ],
            [
                'label' => 'Period From',
                'value' => 'PeriodFrom'
            ],
            [
                'label' => 'Period To',
                'value' => 'PeriodTo'
            ],
            [
                'label' => 'Status',
                'value' => 'Stats'
            ]
            

//       ['class' => 'yii\grid\ActionColumn'],
        ],
    ] 
)
 ;
    ?>
    <p>
        <?= Html::a('Select',NULL, ['class' => 'btn btn-success','id'=>'getSOid']) ?>
    </p>
       <?php // print_r($dataProvider);
//    die();
    ?>
     <?php Pjax::end(); ?> 
<!--     Html::a('select', ['index'], ['class' => 'btn btn-primary']); ?>-->

</div>
</div>