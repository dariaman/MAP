<?php

use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\payroll\models\OverTimeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Over Time';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="over-time-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'SODID',
            'SeqProduct',
            'ProductID',
            'tgl',
            'StatusKerja',
            'Periode',
            'JamMasuk',
            'JamKeluar',
            'JadwalMasuk',
            'JadwalKeluar',
            'OTJamPagi',            
            
            'OTPointPagi',
            'OTPointPagi1',
            'OTPointPagi2',
            'OTPointPagi3',
            'OTPointPagi4',

            'OTJamMalam',
            'OTPointMalam',
            'OTPointMalam1',
            'OTPointMalam2',
            'OTPointMalam3',
            'OTPointMalam4',

            'TotalPoint',
            'TotalAmount',
            'InsRayaAmount',
            'spdAmount',
            'inapAmount',

        ],
    ]); ?>
<?php Pjax::end(); ?></div>
