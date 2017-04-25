<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = 'Payroll Insentive';

$konversi = new app\controllers\GlobalFunction();

?>
<div class="payroll-insentive-index">
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
                        'columns' => [
                           [
                              'class' => 'yii\grid\SerialColumn',
                              'contentOptions' => ['style' => 'width: 50px;'],
                           ],
                           
                           [
                                'label' => 'ProductID',
                                'value' => 'ProductID',
                                'contentOptions' => ['style' => 'width: 130px;'],
                            ],
                            [
                                'label' => 'Nama',
                                'value' => 'Nama',
                                // 'contentOptions' => ['style' => 'width: 250px;'],
                            ],
                            [
                                'label' => 'Jenis insentif',
                                'value' => 'Description',
                                // 'contentOptions' => ['style' => 'width: 200px;'],
                            ],
                            [
                                'label' => 'Tanggal',
                                'value' => 'tgl',
                                'contentOptions' => ['Align' => 'right','style' => 'width: 100px;'],
                                'headerOptions' => ['style' => 'text-align:center']
                            ],
                            [
                                'label' => 'Amount',
                                'value' => 'Amount',
                                'format' => ['decimal', 2],
                                'contentOptions' => ['Align' => 'right','style' => 'width: 100px;'],
                                'headerOptions' => ['style' => 'text-align:center']
                            ],
                             [
                              'label'=> 'Periode Pembayaran',
                              'contentOptions' => ['Align' => 'center','style' => 'width: 100px;'],
                              'value'=> function($data) use ($konversi) {
                                  return $konversi->PeriodeToPeriodeString($data['PeriodePayroll']);
                                }
                            ],
                            'Remark',
                            [
                                'label'=>'IsActive',
                                'width'=>'100px',
                                'hAlign'=>'center',
                                'class'=>'kartik\grid\BooleanColumn',
                                'attribute'=>'IsActive',
                            ],
                           [
                             'class' => 'yii\grid\ActionColumn',
                             'template'=>"{update}",
                             'buttons' => [
                                 'update' => function ($url, $model) {
                                     $url = Url::to(['payroll-insentive/update', 'ItemID' => $model['ItemID'],'PeriodePayroll' => $model['PeriodePayroll'],'ProductID' => $model['ProductID']]);
                                     return Html::a('<span class="fa fa-pencil"></span>', $url, ['title' => 'update']);
                                 },
                               ],
                            ],
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
<?php

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})
        
SKRIPT;

$this->registerJs($script);


?>
