<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Product';
//$this->params['breadcrumbs'][] = $this->title;
$script = <<<SKRIPT
          function getp()
   {
        var id =$("[name=ID]:checked").val().split('|');
         $('#a').attr('value',id[0])
        $('#b').attr('value',id[0])
        $('#c').attr('value',id[1])
        $('#modal').modal('hide')
   }
        $('#getpo').click( getp );

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);
?>
<div class="masterproduct-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
     <?php  echo $this->render('_searchproduct', ['model' => $searchModelll]); ?>
    <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
              [
                    'label'=>'Select',
                    'format'=>'raw',
                    'value'=>function ($data) {
                       return Html::radio('ID', false,['class'=>'p','value'=>$data[ 'ProductID'].'|'.$data[ 'Nama']]);
                       
                    },
             ],
           
             [
                'label'=>'Product',
                'value'=>'ProductID',
            ],
            'NIK',
            'Nama',
           
            'Gender',
             'KTP',
            [
                'label'=>'KTP Expired Date',
                'value'=> 'KTPExpiredDate',
                'format'=>['DateTime','php:d-m-Y'],
            ],
            // 'KTPExpireddate',
//             'SIM',
//            [
//                 'label'=>'Sim Expired Date',
//                'value'=> 'SIMExpiredDate',
//                'format'=>['DateTime','php:d-m-Y'],
//            ],
            // 'simexpireddate',
            
             'Address',
             'Phone',
//             'Mobile1',
//             'Mobile2',
              [
                'label'=>'Bank',
                'value'=>'BankID',
                'label'=>'Class',
                //'value'=>'class.ClassDesc',
                'value'=>'ClassID',
            ],
//             'usercrt',
//             'datecrt',
//             'userUpdate',
//             'dateUpdate',

//            ['class' => 'yii\grid\ActionColumn',
//                 'template' => "{update}",],
        ],
    ]); ?>
     <p>
        <?= Html::a('Select', NULL, ['class' => 'btn btn-success','id'=>'getpo']) ?>
    </p>
  <?php Pjax::end(); ?>
    
</div>
