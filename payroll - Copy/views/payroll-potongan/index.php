<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\payroll\models\PayrollPotonganSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payroll Potongan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-potongan-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                //        'filterModel' => $searchModel,
                        'columns' => [
                //            ['class' => 'yii\grid\SerialColumn'],

                            'ProductID',
                            'Amount',
                //            'IsReguler',
                              ['label'=> 'Status',
                              'value'=> function($data)
                                {
                                    if($data['IsReguler'] == 1)
                                    {
                                        return "Reguler";
                                    } else {
                                        return "Non Reguler";
                                    }
                                }],
                           ['label'=> 'Periode Pembayaran',
                              'value'=> function($data)
                                {
                                    $date =  $data['PeriodeBayar'];
                                    $month = substr($date,4);
                                    $year = substr($date,0,-2);
                                    return $month.'-'.$year;


                                }],
                             ['label'=> 'Status Overtime',
                              'value'=> function($data)
                                {
                                   if($data['IsOT'] == 1)
                                   {
                                       return "OverTime";
                                   }
                                   else{
                                       return "Payroll";
                                   }
                                }],
                            'Remark',
                            [
                                'label' => 'Edit',
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width: 50px;', 'Align' => 'middle'],
                                'value' => function ($data) {

                                    if($data['IsSystem'] == 1)
                                    {
                                        return '';
                                    } else if ($data['IsSystem'] == 0 AND $data['IsPayroll'] == 1)
                                    {
                                        return '';
                                    } else {

                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['editpotongan',
                                                'id' => $data['IDKey'],
                                                    ], [
                                                'title' => Yii::t('app', 'Edit Insentif'),
                                                    ]
                                    );
                                    }
                                },
                            ]

                //            ['class' => 'yii\grid\ActionColumn'],
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
