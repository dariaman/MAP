<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\SOSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$script = <<<SKRIPT
        

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
});
        

function SetValueSO() {
        var idsoo = $("[name=ProductID]:checked").val().split("|");
        //alert(idsoo);
        
        if (window.opener != null && !window.opener.closed) {
            $('#allocationproductdoutstanding-productid',opener.document).val(idsoo[1]);
            $('#prodhid',opener.document).val(idsoo[0]);
        }
        window.close();
}
        $('#getSOid').click( SetValueSO );
        
SKRIPT;

$this->registerJs($script);


$this->title = 'Product Detail';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // print_r('fgh');
//        die(); // echo $this->render('_search', ['model' => $searchModel]); ?>
      <?php Pjax::begin(['id'=>'PtlCommentsPjax']); 
        echo $this->render('_searchprod', ['model' => $searchModel]);
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
                       return Html::radio('ProductID', false,['class'=>'of','value'=>$data['ProductID']."|".$data['Nama']]);
                       
                    },
             ],
            'NIK',
            'Nama',
            [
                'label'=>'JobDesc',
                'value'=>'MJDesc',
            ],
           
            'Gender',
             'KTP',
            [
                'label'=>'KTP Expired Date',
                'value'=> 'KTPExpiredDate',
                'format'=>['DateTime','php:d-m-Y'],
            ],
             'SIM',
            [
                'label'=>'Sim Expired Date',
                'value'=> 'SIMExpiredDate',
                'format'=>['DateTime','php:d-m-Y'],
            ],
            [
                'label'=>'StatusNikah',
                'value'=>'MSD',
            ],
             'Address',
             'City',
             'Zip',
             'Phone',
             'Mobile1',
             'Mobile2',
              [
                'label'=>'Bank',
                'value'=>'BankName',
            ],
             'BankAccNumber',
             'NPWP',
             'Status',
            [
                'label'=>'Class',
                'value'=>'Class',
            ],
            'IsActive',               
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
