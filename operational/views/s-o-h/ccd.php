<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\operational\models\CosCalH;
/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\SOSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Cost Calc';
$script = <<<SKRIPT
        
function SetValueSO() 
    {
        var idsoo = $("[name=CostcalIDH]:checked").val().split("|");
        //alert(idsoo);
        var areaid = idsoo[2];
        var classid = idsoo[3];
        
        if (window.opener != null && !window.opener.closed) {
            $('#ccid',opener.document).val(idsoo[0]);
            $('#ccidhid',opener.document).val(idsoo[0]);
            $('#areaidhid',opener.document).val(idsoo[1]);
 
        }
        
            $.get('index.php?r=operational/s-o-h/get-area',{ idarea : areaid}, function(data){
                //alert(data);
                var data = $.parseJSON(data);
                $('#areaid',opener.document).attr("value",data.Description);
                window.close();
            });
    }
$('#getSOid').click( SetValueSO );
        
$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
});

SKRIPT;

$this->registerJs($script);


$this->title = 'Cost Calc';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // print_r('fgh');
//        die(); // echo $this->render('_search', ['model' => $searchModel]); ?>
      <?php Pjax::begin(['id'=>'PtlCommentsPjax']); 
        echo $this->render('_searchccd', ['model' => $searchModel]);
        
        $subquery = (new \yii\db\Query)
                ->select("CostcalIDH")
                ->from("SOCostCalc soc")
                ->groupBy("CostcalIDH")->all();
                
        $query = CosCalH::find()
                ->select('ch.CostcalIDH,ch.AreaID,ch.JobDescID,mg.Amount')
                ->from('CosCalH ch')
                ->join("inner join","MasterGajiPokok mg",'mg.AreaID = ch.AreaID and mg.IDJobDesc = ch.JobDescID')
                ->where("ch.Tipe = '".$_GET['tipe']."'")
                ->andwhere(['not in','CostcalIDH',$subquery])
                
        ;
      
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
                       return Html::radio('CostcalIDH', false,['class'=>'of','value'=>$data['CostcalIDH']."|".$data['AreaID']."|".$data['JobDescID']]);
                       
                    },
             ],
            [
                'label'=>'Cost Calc',
                'value'=>'CostcalIDH'
            ],
            [
                'label'=>'Gaji Pokok',
                'value'=>'Amount'
            ],                
            [
                'label'=>'Area',
                'value'=>'area.Description'
            ],
            [
                'label'=>'Job Desc',
                'value'=>'jobDesc.Description'
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
