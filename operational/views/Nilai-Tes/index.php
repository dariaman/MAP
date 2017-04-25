<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\NilaiTesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nilai Tes';
$script = <<<SKRIPT
        
$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
});

SKRIPT;

$this->registerJs($script);
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nilai-tes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  
     <?php Pjax::begin(['id'=>'PtlCommentsPjax']); 
    echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['label'=>'Calon Product',
             'value'=>'CalonProductID'],
             ['label'=>'Calon Product Name',
             'value'=>'calonProduct.Nama'],
              ['label'=>'Tanggal Tes',
             'value'=>'TglTes'],
            ['label'=>'Jenis Tes',
             'value'=>'iDJenisTes.Description'],
             ['label'=>'Nilai Tes',
             'value'=>'Nilai'],
           ['class' => 'yii\grid\ActionColumn',
                'template' => "{update}",],
        ],
    ]);?>
    
    
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
