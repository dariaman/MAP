<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Masterproduct';
//$this->params['breadcrumbs'][] = $this->title;
$script = <<<SKRIPT
        
        
        function getp()
   {
        var id =$("[name=ID]:checked").val().split('|');
    if (window.opener != null && !window.opener.closed){
//      alert(id)
//      $('#cp',).attr('value',id[0]);
//      $('#cu').attr('value',id[0]);
           $('#cp',opener.document).val(id);
           $('#cu',opener.document).val(id);
        
        }
          window.close();
     
   }
        
$('#po').click( getp );

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
});
SKRIPT;

$this->registerJs($script);
?>
<div class="masterproduct-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
     <?php   echo $this->render('searchp', ['model' => $searchModell]); ?>
    <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
     <div class="output" style="height: 500px; overflow: auto;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
//        'pager' => [
//            'firstPageLabel' => 'First',
//            'lastPageLabel' => 'Last',
//        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
                  [
                    'label'=>'Select',
                    'format'=>'raw',
                    'value'=>function ($data) {
                       return Html::radio('ID', false,['value'=>$data['ProductID']]);
                       
                    },
             ],
           
             [
                'label'=>'Product',
                'value'=>'ProductID',
            ],
            'NIK',
            'Nama',
             [
                'label'=>'JobDesc',
                'value'=>'iDJobDesc.Description',
            ],
           
            'Gender',
             'KTP',
          
            // 'KTPExpireddate',
             'SIM',
             'Address',
             'City',
             'Phone',
             'Mobile1',
             
             
//             'usercrt',
//             'datecrt',
//             'userUpdate',
//             'dateUpdate',

          
        ],
    ]); ?>
           <p>
        <?= Html::a('Select', NULL, ['class' => 'btn btn-success','id'=>'po']) ?>
    </p>
            <?php Pjax::end(); ?>
 
