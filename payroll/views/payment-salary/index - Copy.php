<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
// use yii\widgets\ActiveForm;

$this->title = 'Payment Salary';

?>


<div class="payment-salary-index">
    <div class="se-pre-con" style="display:none;" id="loadingDiv">
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?= $this->render('_search', ['model' => $searchModel]); ?>

                <div class="box-body">

                <?php $form = ActiveForm::begin(['action' => ['payment-salary/print-slip']]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'showPageSummary'=>true,
                        'hover'=>true,
                        'panel'=>[
                            'type'=>'primary',
                            'heading'=>'Products'
                        ],
                        'toolbar'=>[
                            '{export}',
                            '{toggleData}'
                        ],
                        'columns' => [
                            [
                               'class' => 'kartik\grid\CheckboxColumn',
                               'contentOptions' => ['style' => 'width: 25px;'],
                               'checkboxOptions' => function ($model) {
                                    return ['value' => $model->PayroolIDH];
                                }
                            ],
                            [
                                'class' => 'kartik\grid\SerialColumn',
                                'contentOptions' => ['style' => 'width: 25px;'],
                                'header'=> 'No'
                            ],
                            [
                                'header'=>'Product ID',
                                'value' =>'ProductID',
                                'headerOptions' => ['style' => 'text-align:center'],
                            ],
                            [
                                'header'=>'Nama',
                                'value' =>'Nama',
                                'headerOptions' => ['style' => 'text-align:center'],
                            ],
                            [
                                'header'=>'Job Description',
                                'value' =>'NamaJob',
                                'headerOptions' => ['style' => 'text-align:center']
                            ],
                            [
                                'label' => 'FixAmount',
                                'value' => 'FixAmount',
                                'format' => ['decimal', 2],
                                'contentOptions' => ['Align' => 'right','style' => 'width: 130px;'],
                                'headerOptions' => ['style' => 'text-align:center']
                            ],
                            [
                                'label' => 'PotonganAmount',
                                'value' => 'PotonganAmount',
                                'format' => ['decimal', 2],
                                'contentOptions' => ['Align' => 'right','style' => 'width: 130px;'],
                                'headerOptions' => ['style' => 'text-align:center']
                            ],
                            [
                                'label' => 'PPH21',
                                'value' => 'PPH21',
                                'format' => ['decimal', 2],
                                'contentOptions' => ['Align' => 'right','style' => 'width: 130px;'],
                                'headerOptions' => ['style' => 'text-align:center']
                            ],
                            [
                                'label' => 'Total',
                                'value' => 'Total',
                                'format' => ['decimal', 2],
                                'contentOptions' => ['Align' => 'right','style' => 'width: 130px;'],
                                'headerOptions' => ['style' => 'text-align:center']
                            ],
                        ],
                    ]); ?>
                    <?= Html::submitButton('Print Slip Gaji', ['class' => 'btn btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
        
                <?= Html::a('Print Slip Gaji',['payment-salary/print-slip'],['class' => 'btn btn-success','id'=>'close','style' => 'margin-top:10px;']) ?>
            </div>
        </div>
    </div>
</div>
