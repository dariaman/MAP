<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterCalonProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Calon Product';
$script = <<<SKRIPT
        
$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})
        
$(function () { 
$("[data-toggle='tooltip']").tooltip(); 
});;
$(function () { 
$("[data-toggle='popover']").popover(); 
});
SKRIPT;

$this->registerJs($script);
?>
<div class="master-calon-product-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?= $this->render('_search', ['model' => $searchModel]);?>
                <div class="box-body">

                <?php Pjax::begin(['id' => 'PtlCommentsPjax']); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'contentOptions' => ['style' => 'width: 120px;'],
                            'label' => 'ID Calon Produk',
                            'format' => 'raw',
                            'value' => function($data) {
                        return Html::a($data['CalonProductID'], ['master-calon-product/view',
                                    'id' => $data['CalonProductID']], ['data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Check Calon Product Detail']);}
                        ],
                        [
                            'label' => 'Nama Product',
                            'value' => 'Nama',
                        ],
                        [
                            'label' => 'JobDesc',
                            'value' => 'mjes',
                        ],
                        [
                            'label' => 'Area',
                            'value' => 'AreaName'
                        ],        
                        [
                            'header' => 'Gender',
                            'value' => function($data) {
                                if ($data['Gender'] == 'P') {
                                    return 'Perempuan';
                                } else {
                                    return 'Laki-Laki';
                                }
                            }
                        ],
                        'NoKK',
                        'KTP',
//                        [
//                            'label' => 'KTP Expire Date',
//                            'value' => 'KTPExpireddate',
//                            'format' => ['DateTime', 'php:d-m-Y']
//                        ],
                        [
                            'label' => 'SIM',
                            'value' => 'SIM',
                        ],
                        [
                            'label' => 'SIM Expired Date',
                            'value' => 'SIMExpireDate',
                            'format' => ['DateTime', 'php:d-m-Y']
                        ],
                        [
                            'label' => 'StatusNikah',
                            'value' => 'IDNikah',
                        ],
                        'Address',
                        'RefferensiDesc',
                        'City',
                        [
                            'header' => 'Bank',
                            'value' => 'BankName',
                        ],
                        'BankAccNumber',
                        'NPWP',
                        [
                            'label' => 'Rata Rata Nilai',
                            'contentOptions' => ['style' => 'width: 50px;', 'Align' => 'middle'],
                            'format' => 'raw',
                            'value' => function($data) {
                                if ($data['Nilai'] == NULL) {
                                    return '<span class="badge bg-red">0</span>';
                                } else {
                                    if($data['Nilai'] <= 30)
                                    {
                                        return '<span class="badge bg-red">'.$data['Nilai'].'</span>';
                                    } else if ($data['Nilai'] <= 50)
                                    {
                                        return '<span class="badge bg-light-blue">'.$data['Nilai'].'</span>';
                                    } else if ($data['Nilai'] <= 70)
                                    {
                                        return '<span class="badge bg-yellow">'.$data['Nilai'].'</span>';
                                    } else {
                                        return '<span class="badge bg-green">'.$data['Nilai'].'</span>';
                                    }
                                    
                                }
                            }
                        ],
                        [
                                'header' => 'Status',
                                'format' => 'raw',
                                'value' => function($data)
                                {
                                    if($data['IsActive'] == 1)
                                    {
                                        return '<span class="label label-success">Active</span>';
                                    } else if ($data['IsActive'] == 0)
                                    {
                                        return '<span class="label label-warning">Not Active</span>';
                                    }else {
                                        return $data['IsActive'];
                                    }
                                }
                        ],
                        [
                            'label' => 'Recruitment',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width: 50px;', 'Align' => 'middle'],
                            'value' => function ($data) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['master-calon-product/recruitment',
                                    'mcpid' => $data['CalonProductID'],
                                        ], [
                                    'title' => Yii::t('app', 'Recruitment'),
                                    'data-confirm' => 'Are you sure you want to recruit this Product ?',
                                        ]
                        );
                    },
                        ]
                    ],
            ]);
            ?>
            <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <p>
            <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        
    </div>
</div>
