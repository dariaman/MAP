<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\operational\models\OfferingD;
/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\SOSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Offering';
$script = <<<SKRIPT
        
function SetValueSO() 
    {
        var idsoo = $("[name=OfferingDID]:checked").val().split("|");
        //alert(idsoo);
        var areaid = idsoo[2];
        var classid = idsoo[3];
        
        if (window.opener != null && !window.opener.closed) {
            $('#ofd',opener.document).val(idsoo[0]);
            $('#ofdhid',opener.document).val(idsoo[0]);
            $('#ccid',opener.document).val(idsoo[1]);
            $('#ccidhid',opener.document).val(idsoo[1]);
            $('#areaidhid',opener.document).val(idsoo[2]);
 
        }
        
            $.get('index.php?r=operational/s-o-h/get-area',{ idarea : areaid}, function(data){
                //alert(data);
                var data = $.parseJSON(data);
                $('#areaid',opener.document).attr("value",data.Description);
//                window.close();
            });
    }
    var loading = $('#loadingDiv');
    $('#getSOid').click( SetValueSO );
    $(document)
    .ajaxStart(function () {
      loading.show();
    })
    .ajaxStop(function () {
      loading.hide();
      window.close();
    });
        
$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
});

SKRIPT;

$this->registerJs($script);


$this->title = 'Offering';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-index">
    <div class="se-pre-con" style="display:none;" id="loadingDiv">
    </div>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // print_r('fgh');
//        die(); // echo $this->render('_search', ['model' => $searchModel]); ?>
      <?php Pjax::begin(['id'=>'PtlCommentsPjax']); 
        echo $this->render('_searchofd', ['model' => $searchModel]);
        
        $subquery = (new \yii\db\Query)
                ->select("OfferingDID")
                ->from("SOD")
                ->where("SOIDH = '".$_GET['soid']."'")
                ->groupBy("OfferingDID");
        
        $query = OfferingD::find()
                ->from('OfferingD od')
                ->join("inner join",'SOH','SOH.OfferingIDH = od.OfferingIDH')
                ->where("SOH.SOIDH = '".$_GET['soid']."'")
                ->andwhere(['not in','OfferingDID',$subquery]);
            
      
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'sort' => false]);
        
        ?>
    
 
<div class="output" style="height: 500px; overflow: auto;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'columns' => [
           [
                    'label'=>'select',
                    'format'=>'raw',
                    'value'=>function ($data) {
                       return Html::radio('OfferingDID', false,['class'=>'of','value'=>$data['OfferingDID']."|".$data['CostcalIDH']."|".$data['AreaID']."|".$data['ClassID']]);
                       
                    },
             ],
            [
                'label' => 'Offering Detail',
                'value' => 'OfferingDID'
            ],
            [
                'label'=>'Offering Header',
                'value'=>'OfferingIDH'
            ],
            [
                'label'=>'Cost Calc',
                'value'=>'CostcalIDH'
            ],
            [
                'label'=>'Gaji Pokok',
                'value'=>'gP.Amount'
            ],
            [
                'label'=>'Area',
                'value'=>'area.Description'
            ],
            [
                'label'=>'Class',
                'value'=>'class.ClassDesc'
            ]
//       ['class' => 'yii\grid\ActionColumn'],
        ],
    ] 
)
 ;
    ?>
    <?php //print_r($dataProvider); die();?>
        <p>
          <?= Html::a('Select',NULL, ['class' => 'btn btn-success','id'=>'getSOid']) ?>
      </p>
       <?php // print_r($dataProvider);
//    die();
    ?>
     <?php Pjax::end(); ?> 
<!--     Html::a('select', ['index'], ['class' => 'btn btn-primary']); ?>-->
        
</div>
