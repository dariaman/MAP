<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterVendorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'allocation product';
//$this->params['breadcrumbs'][] = $this->title;
$script = <<<SKRIPT
         function getp()
   {
        var id =$("[name=ID]:checked").val().split('|');
        $('#a').attr('value',id[0])
        $('#aa').attr('value',id[0])
        $('#b').attr('value',id[1])
        $('#bb').attr('value',id[1])
        $('#c').attr('value',id[2])
        $('#cc').attr('value',id[2])
        $('#d').attr('value',id[3])
        $('#dd').attr('value',id[3])
        $('#e').attr('value',id[4])
        $('#ee').attr('value',id[4])
        $('#f').attr('value',id[5])
        $('#ff').attr('value',id[5])
        $('#g').attr('value',id[6])
        $('#gg').attr('value',id[6])
       $('#modal').modal('hide')
   }
        
$('#get').click( getp );

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);

?>
<div class="master-vendor-index">

    <h1><?= Html::encode($this->title) ?></h1>
      <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
      <?php echo $this->render('searchall', ['model' => $searchModell]);?>
    <div class="output" style="height: 500px; overflow: auto;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
              [
                    'label'=>'Select',
                    'format'=>'raw',
                    'value'=>function ($data) {
                       return Html::radio('ID', false,['class'=>'p','value'=>$data[ 'AllocationProductDID'].'|'.$data[ 'SODID'].'|'.$data['RefID'].'|'.$data['JobDescID'].'|'.$data['AreaID'].'|'.$data['ProductID'].'|'.$data['ToProductID']]);
                       
                    },
             ],
            
            'AllocationProductDID',
            'SODID',
            'RefID',
            'JobDescID',
            'AreaID',
            'ProductID',
            'ToProductID',
            'AreaDetailDesc',
            'LicensePlate',
            'TglTugas',

            //['class' => 'yii\grid\ActionColumn'],
            
        ],
    ]); ?>
    <p>
        <?= Html::a('Select', NULL, ['class' => 'btn btn-success','id'=>'get']) ?>
    </p>
      <?php Pjax::end(); ?>
  
</div>
