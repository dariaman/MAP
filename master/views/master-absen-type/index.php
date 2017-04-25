<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterAbsenTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Absen Type';

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);

?>
<div class="master-absen-type-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <?php Pjax::begin(['id'=>'PtlCommentsPjax']); 
                echo $this->render('_search', ['model' => $searchModel]); ?>
                <div class="box-body">
                    <?=    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}{summary}{pager}",
                        'columns' => [
                            [
                                'label' => 'Start Absen',
                                'value' => 'StartAbsen'
                            ],
                            [
                                'label' => 'End Absen',
                                'value' => 'EndAbsen'
                            ]
                            //'Description',
                //             [                
                //                'class' => 'yii\grid\ActionColumn',
                //                'template' => "{update}",
                ////                 'label'=>'Atribute',
                //            ],
                //            [
                //                'label'=>'Atribute',
                //                'format' => 'raw',
                //                'value'=>function ($data) {
                //                        return Html::a('EDIT',array('master-potongan/update&id='));
                //                    },
                //            ],
                        ],
                    ]); ?>
                </div>
                <?php Pjax::end(); ?> 
            </div>
        </div>
        <div class="col-xs-12">
            <p>
                <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>

                <?php

                if(!isset($_GET['typeSearch']) == NULL && !isset($_GET['textsearch']) == NULL)
                {

                    echo Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]);
                }

                ?>
            </p>
        </div>
    </div>
    
    

    
   
    
    
</div>
