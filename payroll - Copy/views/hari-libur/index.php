<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\payroll\models\HariLiburSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hari Libur';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hari-libur-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?php Pjax::begin(['id'=>'PtlCommentsPjax']) ?>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                //        'filterModel' => $searchModel,
                //        'pager' => [
                //            'firstPageLabel' => 'First',
                //            'lastPageLabel' => 'Last',
                //        ],
                        'columns' => [
                //            ['class' => 'yii\grid\SerialColumn'],

                            'Tgl',
                            'Ket',
                //            'IsActive',
                //            'UserCrt',
                //            'DateCrt',
                            // 'UserUpdate',
                            // 'DateUpdate',

                //            ['class' => 'yii\grid\ActionColumn'],
                              ['class' => 'yii\grid\ActionColumn',
                             'template'=>"{update}" ],
                        ],
                    ]); ?>
                </div>
                <?php Pjax::end(); ?>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>
