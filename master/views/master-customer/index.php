<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Master Customer';

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);
?>
<div class="data-pjax">
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
                                'contentOptions' => ['style' => 'width: 120px;'],
                                'label' => 'CustomerID',
                                'format' => 'raw',
                                'value' => function($data) {
                            return Html::a($data['CustomerID'], ['master-customer/view',
                                        'id' => $data['CustomerID']], ['data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Check Detail']);
                        }
                            ],
                            [
                                'contentOptions' => ['style' => 'width: 500px;'],
                                'label' => 'Nama Customer',
                                'value' => 'CustomerName'
                            ],
                            [
                                //'class' => 'kartik\grid\BooleanColumn',
                                'header' => 'Tipe',
                                'format' => 'raw',
//                                'vAlign' => 'middle'
                                'value' => function($data)
                                {
                                    if($data['IsCompany'] == 1)
                                    {
                                        return '<span class="label label-success">Company</span>';
                                    } else if  ($data['IsCompany'] == 0)
                                    {
                                       return '<span class="label label-primary">Personal</span>'; 
                                    } else {
                                        return '';
                                    }
                                }
                            ],
                            [
                                'label' => 'Address',
                                'value' => 'Address'
                            ],
                            [
                                'label' => 'City',
                                'value' => 'City'
                            ],
                            [
                                'label' => 'Zip',
                                'value' => 'Zip'
                            ],
                            [
                                'label' => 'Phone',
                                'value' => 'Phone'
                            ],
                            [
                                'label' => 'Fax',
                                'value' => 'Fax'
                            ],
                            [
                                'label' => 'Contact Name',
                                'value' => 'ContactName'
                            ],
                            [
                                'label' => 'Contact Phone',
                                'value' => 'ContactPhone'
                            ],
                            [
                                'label' => 'Contact Email',
                                'value' => 'ContactEmail'
                            ],
                            [
                                'label' => 'NPWP',
                                'value' => 'NPWP'
                            ],
                            [
                                'label' => 'Start-End Absen',
                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                'value' => function ($data) {
                                    return $data->StartAbsen . '-' . $data->EndAbsen; // $data['name'] for array data, e.g. using SqlDataProvider.
                                },
                            ],
                            [
                                'label' => 'IDFormulaOT',
                                'value' => 'IDFormulaOT'
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
                            ['class' => 'yii\grid\ActionColumn', 'template' => "{update}"],
                        ],
                    ]);
                    ?>
                </div>
                <?php Pjax::end(); ?> 
            </div>
        </div>
        <div class="col-xs-12">
            <p>
                <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    </div>
    
    
    
    
    

</div>
