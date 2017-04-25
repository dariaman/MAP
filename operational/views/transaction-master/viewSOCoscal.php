<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = 'Approval Sales Order';
$edit=0;
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
                    <?= $this->render('/s-o-d/_index', ['SD' => $model->TransID,'edit' => $edit ]);?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?php
                    echo Html::a('Approve', ['approve-change-cc', 'transid' => $model->TransID, 'action'=> 'A'], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'method' => 'post',
                        ],
                    ]);

                    echo Html::a('Correction', ['correction-change-sod','transid'=>$model->TransID],['class' => 'btn btn-success']);
                    echo Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]);
                ?>
            </div>
        </div>
    </div>
</div>