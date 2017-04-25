<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Approval Sales Order';
$edit=0;
?>
<div class="transaction-master-view">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>    
                </div>
                <div class="box-body">
                <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:200px;">Transaction ID</td>
                            <td>: <?= $model->TransID  ?></td>
                        </tr>
                        <tr><td>Trans Type </td><td>: <?= $model->Transtype ?></td></tr>
                        <tr><td>PIC</td><td>: <?= $model->PIC ?></td></tr>
                        <tr><td>Status </td><td>: <?= $model->Status ?></td></tr>
                        <tr><td>Reason </td><td>: <?= Html::textarea('Reason', NULL, ['class' => 'form-control']) ?></td></tr>

                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode('List Item') ?></h1>    
                </div>
                <div class="box-body">
                    <?= $this->render('/s-o-d/_indexso', ['SD' => $model->TransID,'edit' => $edit ]) ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?php
                    echo Html::a('Approve', ['approve-sod', 'transid' => $model->TransID, 'action'=> 'A'], [
                            'class' => 'btn btn-success',
                            'data' => [
                                'method' => 'post',
                            ],
                        ]);
                    echo Html::a('Reject', ['correction-sod','transid'=>$model->TransID],['class' => 'btn btn-success','data' => ['method' => 'post']]);
                    echo Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]);

                ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>