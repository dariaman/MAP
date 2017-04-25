<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\SOSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Offering';
$script = <<<SKRIPT
        
function SetValueSO() 
    {
        var idsoo = $("[name=OfferingIDH]:checked").val();
        //alert(idsoo);
        
        if (window.opener != null && !window.opener.closed) {
            $('#ofh',opener.document).val(idsoo);
            $('#ofhr',opener.document).val(idsoo);
 
        }
                window.close();

    }
$('#getSOid').click( SetValueSO );
        
$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
});

SKRIPT;

$this->registerJs($script);


$this->title = 'Offering';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // print_r('fgh');
//        die(); // echo $this->render('_search', ['model' => $searchModel]); ?>
      <?php Pjax::begin(['id'=>'PtlCommentsPjax']); 
        echo $this->render('_searchofh', ['model' => $searchModel]);
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
                       return Html::radio('OfferingIDH', false,['value'=>$data['OfferingIDH']]);
                       
                    },
             ],
            [
                'label' => 'Offering ',
                'value' => 'OfferingIDH'
            ],
            [
                'label'=>'Offering Date',
                'value'=>'OfferingDate'
            ],
            [
                'label'=>'Job Desc',
                'value'=>'iDJobDesc.Description'
            ],
            [
                'label'=>'Nomor Surat',
                'value'=>'NoSurat'
            ],
            [
                'label'=>'Tipe Bayar',
                'value'=>function($data)
                {
                    if($data['TipeBayar'] == 'ADV')
                    {
                        return "Advance";
                    } else {
                        return "Arrear";
                    }
                }
            ],
            [
                'label'=>'Cara Bayar',
                'value'=>'CaraBayar'
            ],
            [
                'label'=>'Tahun',
                'value'=>function($data)
                {
                    if($data['ThnRemunerasi'] == NULL)
                    {
                        return " ";
                    } else {
                        return $data['ThnRemunerasi'];
                    }
                }
            ],
            [
                'label'=>'Is Active',
                'value'=> function($data)
                {
                    if($data['IsActive'] == 1)
                    {
                        return "Yes";
                    } else {
                        return "No";
                    }
                }
            ],
            [
                'label'=>'Is Print',
                'value'=>function($data)
                {
                    if($data['IsPrint'] == 1)
                    {
                        return "Yes";
                    } else {
                        return "No";
                    }
                }
            ],
            [
                'label'=>'Approved By',
                'value'=> function($data)
                {
                    if($data['ApproveBy'] == NULL)
                    {
                        return " ";
                    }
                    
                }
            ],
            [
                'label'=>'Approved Date',
                'value'=> function($data)
                {
                    if($data['ApproveDate'] == NULL)
                    {
                        return " ";
                    }
                    
                }
            ],
            [
                'label'=>'Status',
//                'value'=> function($data)
//                {
//                    if($data['Status'] == 'D')
//                    {
//                        return "Draft";
//                    }
//                }
                'value' => 'Status'
            ]
        ],
    ] 
)
 ;
    ?>
    <p>
          <?= Html::a('Select',NULL, ['class' => 'btn btn-success','id'=>'getSOid']) ?>
      </p>
     <?php Pjax::end(); ?> 
<!--     Html::a('select', ['index'], ['class' => 'btn btn-primary']); ?>-->
        
</div>
