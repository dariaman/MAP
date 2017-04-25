<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\master\models\NilaiTesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nilai Tes';

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);
?>
<div class="nilai-tes-index">
 <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
                <?php Pjax::begin(['id'=>'PtlCommentsPjax'])?>
                <div class="box-body">
                <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'contentOptions' => ['style' => 'width: 100px;'],
                                'label' => 'Calon Product ID',
                                'value' => 'CalonProductID'
                            ],
                            [
                                'label' => 'Nama',
                                'value' => 'nama'
                            ],
                            [
                                'label' => 'Jenis Tes',
                                'value' => 'Description'  
                            ],
                            [
                                'label' => 'Nilai',
                                'value' => 'Nilai'
                            ],
                            [
                                 'label' => 'Tanggal Tes',
                                'value' => 'TglTes',
                                'format' => ['DateTime', 'php:d-m-Y'],
                            ],
                            [
                               
                                'label' => 'UserCrt',
                                'value' => 'UserCrt'
                            ],
                            [
                               'class' => 'yii\grid\ActionColumn',
                                    'template' => "{update}",],
                            ],
                        ]);
                        ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?php echo Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
                <?php echo Html::a('Back', ['master-calon-product/index'], ['class' => 'btn btn-success']);?>
            </div>
        </div>
    </div>
    
</div>
