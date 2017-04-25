<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\BackupProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Backup Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="backup-product-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?php Pjax::begin(['id' => 'PtlCommentsPjax']); ?>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
                <div class="box-body">
                    <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                [
                                    'label' => 'ID Produk GS',
                                    'value' => 'ProductIDGS',
                                ],
                                [
                                    'label' => 'Nama Produk GS',
                                    'value' => 'NamaGs',
                                ],
                                'SODID',
                                [
                                    'label' => 'Seq Product',
                                    'value' => 'SeqProduct',
                                ],
                                [
                                    'label' => 'ID Produk FIX',
                                    'value' => 'ProductIDFix',
                                ],
                                [
                                    'label' => 'Nama Produk FIX',
                                    'value' => 'NamaFix',
                                ],
                                [
                                    'label' => 'Tanggal Tugas',
                                    'value' => 'TglTugas',
                                ],
                                [
                                    'label' => 'Period To',
                                    'value' => 'PeriodTo',
                                ],
                                [
                                    'label' => 'Status Absen',
                                    'format' => 'raw',
                                    'value' => function($data)
                                    {
                                        if($data['StatusAbsen'] == 'S')
                                        {
                                            return '<span class="label label-warning">Sakit</span>';
                                        } else if ($data['StatusAbsen'] == 'A')
                                        {
                                            return '<span class="label label-danger">Alpha</span>';
                                        } else if ($data['StatusAbsen'] == 'C')
                                        {
                                            return '<span class="label label-primary">Cuti</span>';
                                        } else {
                                            return $data['StatusAbsen'];
                                        }
                                    },
                                ],
                                [
                                    'label' => 'Reason',
                                    'value' => 'Reason',
                                ],
                    //            
                            ],
                        ]);
                        ?>
                </div>
                <?php Pjax::end(); ?>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::a('Add Backup Product', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>
