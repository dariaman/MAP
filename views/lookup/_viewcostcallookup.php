<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\icons\Icon;

$this->title = 'Costcal';
?>
<h1><center><?= Html::encode($this->title) ?></center></h1>

<div class="offering-d-form">
    <?php $form = ActiveForm::begin(); ?>
    <table class="table table-striped table-bordered">
        <tr>
            <td style="width:200px;">OfferingDID</td>
            <td>: <label><?= $OFID ?> </label></td>
        </tr>
        <tr>
            <td style="width:200px;">OfferingIDH</td>
            <td>: <label><?= $OFIH ?> </label></td>
        </tr>
    </table>
    <?php
    $sql = new \yii\db\Query;
    $sql->select('mb.Description,cc.Amount,cc.Remark,cc.Time,cc.IsManagementFee,cc.TipeTagihan,')
            ->from(['cc' => app\operational\models\CosCalc::tableName()])
            ->leftJoin(['mb' => \app\master\models\MasterBiaya::tableName()], 'cc.BiayaID = mb.BiayaID')
            ->where('cc.OfferingDID=\'' . $OFID . '\'and cc.OfferingIDH=\'' . $OFIH . '\'')
            ->orderBy('mb.SeqNo');

    $dataProvider = new \yii\data\ActiveDataProvider(['query' => $sql]);
    $dataProvider->pagination->pageSize = 50;

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}",
        'pjax' => false,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'width: 30px;'],
            ],
            [
                'contentOptions' => ['style' => 'width: 200px;'],
                'label' => 'Biaya Name',
                'attribute' => 'Description',
            ],
            [
                'contentOptions' => ['style' => 'width: 160px;', 'style' => 'text-align:right'],
                'headerOptions' => ['style' => 'text-align:center'],
                'header' => 'Jumlah Amount',
                'attribute' => 'Amount',
                'format' => 'Currency',
            ],
            [
                'contentOptions' => ['style' => 'width: 120px;'],
                'label' => 'Remark',
                'attribute' => 'Remark',
            ],
            [
                'contentOptions' => ['style' => 'width: 120px;'],
                'label' => 'Time',
                'attribute' => 'Time',
            ],
            [
                'format' => 'raw',
                'attribute' => 'IsManagementFee',
                'vAlign' => 'middle',
                'value' => function($data) {
                    if ($data['IsManagementFee'] == TRUE) {
                        return Icon::show('check', [], Icon::BSG);
                    } else {
                        return '-';
                    }
                },
            ],
            [
                'label' => 'TipeTagihan',
                'value' => function($data) {
                    if ($data['TipeTagihan'] == 'B') {
                        return 'Bulanan';
                    } else {
                        return 'Tahunan';
                    }
                },
            ],
        ],
    ]);
    ?>
    <div class="form-group">
        <?= Html::a('Back', '', ['class' => 'btn btn-success', 'onclick' => "window.history.back(); "]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>