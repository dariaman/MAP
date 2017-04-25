<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\operational\models\CosCalH;
/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\SOSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Offering';
$script = <<<SKRIPT
    
$('.dtccbutton').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
});

function SetValueSO() 
    {
        var idsoo = $("[name=CostcalIDH]:checked").val().split("|");
        //alert(idsoo);
        var areaid = idsoo[1];
        
        if (window.opener != null && !window.opener.closed) {
            $('#ccid',opener.document).val(idsoo[0]);
            $('#idcchid',opener.document).val(idsoo[0]);

        }
            $.get('index.php?r=operational/offering-h/get-area',{ idarea : areaid}, function(data){
                //alert(data);
                var data = $.parseJSON(data);
                $('#areaid',opener.document).attr("value",data.Description);
                $('#areaidhid',opener.document).attr("value",data.AreaID);   
               
            });
        
            $.get('index.php?r=operational/offering-h/get-gapok',{ idcch : idsoo[0]}, function(data){
//                alert(data);
                var data = $.parseJSON(data);
                $('#gpid',opener.document).attr("value",data.Amount);
                $('#gpidhid',opener.document).attr("value",data.GapokID);
                $('#gpseqidhid',opener.document).attr("value",data.SeqID); 
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


$this->title = 'Cost Calc';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-index">
    <div class="se-pre-con" style="display:none;" id="loadingDiv">
   
    </div>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // print_r('fgh');
//        die(); // echo $this->render('_search', ['model' => $searchModel]); ?>
      <?php Pjax::begin(['id'=>'PtlCommentsPjax']); 
        //echo $this->render('_searchcus', ['model' => $searchModel]);
        $subquery = (new \yii\db\Query)
                ->select("od.CostcalIDH")
                ->from("OfferingD od")
                ->join("INNER JOIN",'CosCalH ch','ch.CostcalIDH = od.CostcalIDH')
                ->join('inner join','OfferingH oh','oh.IDJobDesc = ch.JobDescID')
                ->where("ch.Tipe = 'LT' and oh.IDJobDesc =".$_GET['job'])
                ->groupBy("od.CostcalIDH")->all();
        
        $query = CosCalH::find()
        ->select('*,mj.Description as mjdesc,ma.Description as madesc')
        ->from('CosCalH ch')
        ->join("INNER JOIN",'OfferingH oh','oh.IDJobDesc = ch.JobDescID')
        ->innerJoin('MasterJobDesc mj','mj.IDJobDesc = oh.IDJobDesc')
        ->innerJoin('MasterArea ma','ma.AreaID = ch.AreaID')
        ->where("oh.IDJobDesc = ".$_GET['job']." and ch.Tipe = 'LT'")
        ->andwhere(['not in','CostcalIDH',$subquery]);
      
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'sort' => false]);
        
        ?>
    
 
<div class="output" style="height: 500px; overflow: auto;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}{summary}{pager}",
         'columns' => [
            [
                    'label'=>'select',
                    'format'=>'raw',
                    'value'=>function ($data) {
                       return Html::radio('CostcalIDH', false,['class'=>'of','value'=>$data['CostcalIDH']."|".$data['AreaID']."|".$data['JobDescID']]);
                       
                    },
             ], 
           [
                'label' => 'Cost Calc ID',
                'format' => 'raw',
                'value'=>function($data)
                {
                    return Html::a($data['CostcalIDH'],'./index.php?r=operational/offering-h/detailcc&id='.$data['CostcalIDH'],['class'=>'dtccbutton']);
                }
            ],
            //'SeqIDCostcal',
            [
                'label' => 'Tanggal Cost Calc',
                'value' => 'CostcalDate'
            ],
            'mjdesc',
            'madesc',

        ],
    ] 
)
 ;
    ?>
      <p>
          <?= Html::a('Select',NULL, ['class' => 'btn btn-success','id'=>'getSOid']) ?>
      </p>
     <?php Pjax::end(); ?> 
        
</div>
</div>
