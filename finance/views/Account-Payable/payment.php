<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\finance\models\PaymentRequestSalarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Request Salary';
//$this->params['breadcrumbs'][] = $this->title;
$script = <<<SKRIPT
        
$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})
          function value()
     {
           var id =$("[name=ID]:checked").val().split('|');
           if (window.opener != null && !window.opener.closed) {
             $(opener.document.getElementById("prn")).val(id);
             $(opener.document.getElementById("prs")).val(id);
           
        }
        window.close();    
        }
       $('#getitem').click( value );
        

SKRIPT;

$this->registerJs($script);
?>
<div class="payment-request-salary-index">

    <h1><?= Html::encode($this->title) ?></h1>
       <?php Pjax::begin(['id' => 'PtlCommentsPjax']);?>
    <?php //  echo $this->render('_search', ['model' => $searchModelI]); ?>

   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
            'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
                   [
       'label'=>'select',
       'format' => 'raw',
       'value'=>function ($data) {
                 return Html::radio('ID', false,['class'=>'p','value'=>$data['PaymentReqNo']]);
        },
    ],
            'PaymentReqNo',
            'ItemID',
            'ProductID',
            'Year',
            'Month',
             'TotalSalary',
            // 'usercrt',
            // 'datecrt',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <p>
        <?= Html::a('Select',NULL, ['class' => 'btn btn-success','id'=>'getitem']) ?>
    </p>
     <?php Pjax::end(); ?>
</div>
