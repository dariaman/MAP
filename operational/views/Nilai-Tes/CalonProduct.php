<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax; 

/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterCalonProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Calon Product';
//$this->params['breadcrumbs'][] = $this->title;
$script = <<<SKRIPT
        function getp()
   {
        var id =$("[name=ID]:checked").val().split('|');
         $('#cp').attr('value',id[0])
        $('#cpa').attr('value',id[0])
        $('#cpn').attr('value',id[1])
        $('#modal').modal('hide')
   }
        
$('#getpo').click( getp );
       
//$('.p').click(function(){
//      var id=$(this).val();
//       $('#cp').val(id);
//        $('#cpa').val(id);
       
//        $.get('index.php?r=operational/s-o/getval',{id:id},function())
//        var id=$(this).val();
        
       
      
      
      
       
        
$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
});

SKRIPT;

$this->registerJs($script);


?>
<div class="master-calon-product-index">

    <h1><?= Html::encode($this->title) ?></h1>
  
    <?php  echo $this->render('_SearchCalonProduct', ['model' => $searchModell]); ?>
        <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
   
<div class="output" style="height: 500px; overflow: auto;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
             [
                    'label'=>'Select',
                    'format'=>'raw',
                    'value'=>function ($data) {
                       return Html::radio('ID', false,['class'=>'p','value'=>$data[ 'CalonProductID'].'|'.$data[ 'Nama']]);
                       
                    },
             ],

           
            [
                'label'=> 'CalonProduct',
                'value'=> 'CalonProductID',
            ],
           
            [
                'label'=> 'Nama Product',
                'value'=> 'Nama',
            ],
           
            [
                'label'=> 'JobDesc',
                'value'=> 'IDJobDesc',
            ],
                              [
                'label'=> 'Gender',
                'value'=> 'Gender',
            ],
                              [
                'label'=> 'KTP',
                'value'=> 'KTP',
            ],
         
           [
               'label'=>'StatusNikah',
                'value'=>'IDstatusnikah',
                
            ],
            [
                'label'=>  'Address',
                'value'=>  'Address',
            ],
             [
                'label'=> 'RefferensiDesc',
                'value'=> 'RefferensiDesc',
            ],
            [
                'label'=> 'City',
                'value'=> 'City',
            ],
          
           
             //'usercrt',
             //'datecrt',
            

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
      <p>
        <?= Html::a('Select', NULL, ['class' => 'btn btn-success','id'=>'getpo']) ?>
    </p>
  <?php Pjax::end(); ?>
  

</div>
