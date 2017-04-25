<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Product PKWT';
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);
?>
<div class="product-pkwt-index">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <?= $this->render('_search', ['model' => $searchModel]);   ?>
                <div class="box-body">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                'ProductID',
                                [
                                    'label' => 'Nama Produk PKWT',
                                    'value' => 'Nama',
                                ],
                                'PeriodFrom',
                                'PeriodTo',
                                'GajiPokok',
                            ],
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>

