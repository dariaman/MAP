<?php

use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\payroll\models\PPH21ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pph21 Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pph21-product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'panel'=>[
                            'type'=>'primary',
                            'heading'=>'Products'
                        ],
                        'toolbar'=>[
                            '{export}',
                            '{toggleData}'
                        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'ProductID',
            [
                'label' => 'Gaji Pokok',
                'value' => 'Gapok',
                'format' => ['decimal', 2],
                'contentOptions' => ['Align' => 'right'],
                'headerOptions' => ['style' => 'text-align:center']
            ],
            [
                'label' => 'Tunjangan',
                'value' => 'Tunjangan',
                'format' => ['decimal', 2],
                'contentOptions' => ['Align' => 'right'],
                'headerOptions' => ['style' => 'text-align:center']
            ],
            [
                'label' => 'Potongan',
                'value' => 'Potongan',
                'format' => ['decimal', 2],
                'contentOptions' => ['Align' => 'right'],
                'headerOptions' => ['style' => 'text-align:center']
            ],
            [
                'label' => 'Biaya Jabatan',
                'value' => 'BiayaJabatan',
                'format' => ['decimal', 2],
                'contentOptions' => ['Align' => 'right'],
                'headerOptions' => ['style' => 'text-align:center']
            ],
            [
                'label' => 'PTKP',
                'value' => 'PTKP',
                'format' => ['decimal', 2],
                'contentOptions' => ['Align' => 'right'],
                'headerOptions' => ['style' => 'text-align:center']
            ],
            [
                'label' => 'PKP di Setahunkan',
                'value' => 'PKPTahun',
                'format' => ['decimal', 2],
                'contentOptions' => ['Align' => 'right'],
                'headerOptions' => ['style' => 'text-align:center']
            ],
            [
                'label' => 'PPH21 Amount',
                'value' => 'PPH21Amount',
                'format' => ['decimal', 2],
                'contentOptions' => ['Align' => 'right'],
                'headerOptions' => ['style' => 'text-align:center']
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
