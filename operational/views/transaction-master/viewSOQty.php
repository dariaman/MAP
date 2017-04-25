<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = 'Approval Sales Order';
$edit=0;

$arr = explode('|',$model['TransID']);

?>
<div class="transaction-master-view">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'TransID',
                            'Transtype',
                            'PIC',
//                            'NextPIC',
                            'Status',
                            'usercrt',
                            'datecrt',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode('List Item') ?></h1>
                </div>
                <div class="box-body">
                    <?= $this->render('/s-o-d/_indexreqqty', ['sodid' => $arr[1],'seqid' => $arr[0]]);?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?php
                    echo Html::a('Approve', ['approve-del-qty', 'transid' => $model->TransID, 'action'=> 'A'], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'method' => 'post',
                        ],
                    ]);

                    echo Html::a('Correction', ['correction-slot-product','transid'=>$model->TransID, 'action'=> 'C'],[
                        'class' => 'btn btn-success',
                        'data' => [
                            'method' => 'post',
                        ],
                    ]);
                    echo Html::a('Back', ['operational/transaction-master'], ['class' =>'btn btn-success']);
                ?>
            </div>
        </div>
    </div>
</div>