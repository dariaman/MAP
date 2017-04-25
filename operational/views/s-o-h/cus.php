<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\SOSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Customer';
$script = <<<SKRIPT
        
function SetValueSO() 
    {
        var idsoo = $("[name=CustomerID]:checked").val();
        //alert(idsoo);
        
        if (window.opener != null && !window.opener.closed) {
            $('#cus',opener.document).val(idsoo);
            $('#cuss',opener.document).val(idsoo);
 
        }
                window.close();

    }
$('#getSOid').click( SetValueSO );
$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
});

SKRIPT;

$this->registerJs($script);
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // print_r('fgh');
//        die(); // echo $this->render('_search', ['model' => $searchModel]); ?>
      <?php Pjax::begin(['id'=>'PtlCommentsPjax']); 
        echo $this->render('_searchcus', ['model' => $searchModel]);
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
                       return Html::radio('CustomerID', false,['value'=>$data['CustomerID']]);
                       
                    },
             ],
            [
                'label' => 'Customer ID',
                'value' => 'CustomerID'
            ],
            [
                'label' => 'Parent ID',
                'value' => 'ParentID'
            ],
            [
                'label' => 'Customer Name',
                'value' => 'CustomerName'
            ],
            [
                'label' => 'Address',
                'value' => 'Address'
            ],
            [
                'label' => 'City',
                'value' => 'City'
            ],
             [
                'label' => 'Zip',
                'value' => 'Zip'
            ],
             [
                'label' => 'Phone',
                'value' => 'Phone'
            ],
             [
                'label' => 'Fax',
                'value' => 'Fax'
            ],
            [
                'label' => 'Contact Name',
                'value' => 'ContactName'
            ],
             [
                'label' => 'Contact Phone',
                'value' => 'ContactPhone'
            ],
            [
                'label' => 'Contact Email',
                'value' => 'ContactEmail'
            ],
            [
                'label' => 'Absen Type',
                'value' => 'IDAbsenType'
            ],
            [
                'label' => 'TOP',
                'value' => 'TOP'
            ],
            [
                'label' => 'NPWP',
                'value' => 'NPWP'
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
     <?php Pjax::end(); ?> 
<!--     Html::a('select', ['index'], ['class' => 'btn btn-primary']); ?>-->
        
</div>
