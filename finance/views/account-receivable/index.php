<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\finance\models\AccountReceivableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Receivable Voucher';
?>
<div class="account-receivable-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            'ARNo',
                            'InvoiceNo',
                            'RefNo',
                            'PaymentDate',
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::a('Create Receivable Voucher', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
</div>
