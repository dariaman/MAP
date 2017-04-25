<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\SOSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'SO';
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
});

$('.sodbutton').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=1024,height=600,scrollbars=yes,location=no");
});          

function SetValueSO() {
        var idsoo = $("[name=SOIDH]:checked").val();
        //alert(idsoo);
        
        if (window.opener != null && !window.opener.closed) {
            $('#allocationproducth-soidh',opener.document).val(idsoo);
        }
        window.close();
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
        
SKRIPT;

$this->registerJs($script);


$this->title = 'SO';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-index">
    <div class="se-pre-con" style="display:none;" id="loadingDiv">
    </div>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // print_r('fgh');
//        die(); // echo $this->render('_search', ['model' => $searchModel]); ?>
      <?php Pjax::begin(['id'=>'PtlCommentsPjax']); 
        echo $this->render('_searchso', ['model' => $searchModel]);
//        print_r('dfg');
//        die();
        ?>
    
 
<div class="output" style="height: 500px; overflow: auto;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
           [
                    'label'=>'select',
                    'format'=>'raw',
                    'value'=>function ($data) {
                       return Html::radio('SOIDH', false,['class'=>'of','value'=>$data['SOIDH']]);
                       
                    },
             ],
            [
                'label'=>'SO ID Header',
                'format' => 'raw',
                'value'=>'SOIDH'
            ],
            [
                'label' => 'SO Date',
                'value' => function($data)
                        {
                            $sodate = strtotime($data['SODate']);
                            return date('j-F-o',$sodate);
                        }
            ],
            [
                'label' => 'Offering Header',
                'value' => 'OfferingIDH'
            ],
            [
                'label' => 'Tipe Bayar',
                'value' => 'TipeBayar'
            ],
            [
                'label' => 'Tipe Kontrak',
                'value' => 'TipeKontrak'
            ],
            [
                'label' => 'PO Number',
                'value' => 'PONo'
            ],
            [
                'label' => 'PO Date',
                'value' => function($data)
                        {
                            $sodate = strtotime($data['POdate']);
                            return date('j-F-o',$sodate);
                        }
            ],
            [
                'label' => 'Customer',
                'value' => 'CustomerName'
            ],
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
