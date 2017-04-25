<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Master Product';
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);
?>
<div class="masterproduct-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
                <div class="box-body">
                    <?php Pjax::begin(['id' => 'PtlCommentsPjax']); ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                [
                                    'contentOptions' => ['style' => 'width: 120px;'],
                                    'label' => 'Produk',
                                    'format' => 'raw',
                                    'value' => function($data) {
                                return Html::a($data['ProductID'], ['master-product/view',
                                            'id' => $data['ProductID']], ['data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Check Detail']);
                                }
                                ],
                                [
                                    'header' => 'Nama Product',
                                    'value' => 'Nama',
                                    'contentOptions' => ['style' => 'max-width: 1000px;']
                                ],
                                [
                                    'label' => 'JobDesc',
                                    'value' => 'MJDesc',
                                ],
                                [
                                    'label' => 'AreaName',
                                    'value' => 'AreaName',
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
                                [
                                    'label' => 'No KK',
                                    'value' => 'NoKK',
                                ],
                                [
                                    'label' => 'KTP',
                                    'value' => 'KTP',
                                ],
//                                [
//                                    'label' => 'KTP Expired Date',
//                                    'value' => 'KTPExpiredDate',
//                                    'format' => ['DateTime', 'php:d-m-Y'],
//                                ],
                                [
                                    'label' => 'SIM',
                                    'value' => 'SIM',
                                ],
                                [
                                    'label' => 'SIM Expired Date',
                                    'value' => 'SIMExpiredDate',
                                    'format' => ['DateTime', 'php:d-m-Y'],
                                ],
                                [
                                    'label' => 'StatusNikah',
                                    'value' => 'IDNikah',
                                ],
                                'Address',
                                'City',
                                'Zip',
                                'Phone',
                                'Mobile1',
                                'Mobile2',
                                [
                                    'label' => 'Bank Name',
                                    'value' => 'BankName',
                                ],
                                'BankAccNumber',
                                [
                                    'label' => 'NPWP',
                                    'value' => 'NPWP',
                                ],
                                [
                                    'label' => 'Class',
                                    'format' => 'raw',
                                    'value' => function($data)
                                    {
                                        if($data['Class'] == 'A')
                                        {
                                           return "<span class='label label-danger'>A</span>"; 
                                        } else if($data['Class'] == 'B') 
                                        {
                                           return "<span class='label label-primary'>B</span>";  
                                        } else {
                                            return '';
                                        }
                                    }
                                ],
                                [
                                    'header' => 'Status<br>Product',
                                    'format' => 'raw',
                                    'value' => function($data)
                                    {
                                        if ($data['Status'] == 'GS') {
                                            return "<span class='label label-warning'>GS</span>";
                                        } else if($data['Status'] == 'FIX'){
                                            return "<span class='label label-success'>FIX</span>";
                                        } else {
                                            return '';
                                        }
                                    }
                                ],
                                [
                                    'label' => 'Status',
                                    'format' => 'raw',
                                    'value' => function($data) {
                                        if ($data['IsActive'] == 1) {
                                            return "<span class='label label-success'>Active</span>";
                                        } else {
                                            return "<span class='label label-danger'>Not Active</span>";
                                        }
                                    }
                                ],
                                ['class' => 'yii\grid\ActionColumn',
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
            </div>
        </div>
    </div>
    
</div>
