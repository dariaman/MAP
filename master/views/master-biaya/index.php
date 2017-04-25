<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Master Biaya';

$script = <<<SKRIPT
        
$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
});

SKRIPT;

$this->registerJs($script);
?>

<div class="master-Biaya-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search', ['model' => $searchModel]) ?>
    <?php Pjax::begin(['id' => 'PtlCommentsPjax']); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'contentOptions' => ['style' => 'width: 200px;'],
                'label' => 'SeqNo',
                'format' => 'raw',
                'value' => 'SeqNo'
            ],
            [
                'contentOptions' => ['style' => 'width: 200px;'],
                'label' => 'BiayaID',
                'format' => 'raw',
                'value' => 'BiayaID'
            ],
            [
                'label' => 'Biaya Description',
                'format' => 'raw',
                'value' => 'Description'
            ],
            [
                'contentOptions' => ['style' => 'width: 200px;'],
                'label' => 'Tipe Biaya',
                'format' => 'raw',
                'value' => function($data) {
            if ($data['TipeBiaya'] == '1FX') {
                return 'FIX';
            } else if ($data['TipeBiaya'] == '2TMB') {
                return 'Tambahan';
            } else if ($data['TipeBiaya'] == '3NFIX') {
                return 'Non FIX';
            } else {
                return $data['TipeBiaya'];
            }
        }
            ],
        ],
    ]);
    ?>
<?php Pjax::end(); ?>
<?= Html::a('add', ['create'], ['class' => 'btn btn-success']); ?>

</div>

