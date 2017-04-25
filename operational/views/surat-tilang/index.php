<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\pjax;


/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\SuratTilangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Surat Tilang';
$script = <<<SKRIPT
        
$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
});

SKRIPT;

$this->registerJs($script);
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-tilang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); 
         Pjax::begin(['id'=>'PtlCommentsPjax']);    
         echo $this->render('_search', ['model' => $searchModel]);
         ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label'=>'IDSuratTilang',
                'value'=>'IDSuratTilang',
              
            
            ],
            [
                'label'=>'Tanggal Tilang',
                'value'=>'TglTilang',
              
            
            ],
              
             [
                'label'=>'Product',
                'value'=>'ProductID',
              
            
            ],
            
            
       
             [
                'label'=>'Product Name',
                'value'=>'mpnama',
              
            
            ],
              [
                'label'=> 'Keterangan Tilang',
                'value'=> 'Description',
              
            
            ],
         
           
//            'usercrt',
            // 'datecrt',

            ['class' => 'yii\grid\ActionColumn',
                'template' => "{update}",  ],
        ],
    ]); ?>
<?php Pjax::end(); ?> 
    
      <p style="float:right;">
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
        
        <?php
        
        if(!isset($_GET['typeSearch']) == NULL && !isset($_GET['textsearch']) == NULL)
        {
            
            echo Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]);
        }
        
        ?>
</div>
