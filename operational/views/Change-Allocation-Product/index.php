<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\ChangeAllocationProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Change Allocation Product';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="change-allocation-product-index">

    <h1><?= Html::encode($this->title) ?></h1>
       <?php Pjax::begin(['id'=>'PtlCommentsPjax']); ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'ChangeAllocationProductID',
            'AllocationProductID',
            'SOID',
            'RefID',
            'JobDescID',
             'AreaID',
             'ProductID',
             'ToProductID',
             'ProductFreelance',
             'Tipe',
             'Remark',
             'FromDate',
              'ToDate',
            // 'UserCrt',
            // 'DateCrt',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    <p style="float:right">
        <?= Html::a('add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
