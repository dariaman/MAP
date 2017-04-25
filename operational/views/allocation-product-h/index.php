<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\AllocationProductHSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Go Live Header';

$script = <<<SKRIPT
        
//$('.viewAPH').click(function(event) {
//    event.preventDefault();
//    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
//});        
        
SKRIPT;

$this->registerJs($script);
?>
<div class="allocation-product-h-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label'=>'ID Go Live',
                'format' => 'raw',
                'value'=>function($data)
                {
                    return Html::a($data['AllocationProductIDH'],['allocation-product-h/view','id'=>$data['AllocationProductIDH']],['class' => 'viewAPH']);
                }
//                'value' => 'AllocationProductIDH'
            ],
            [
                'label' => 'SO ID',
                'value' => 'SOIDH'
            ],
            [
                'label' => 'Deskripsi',
                'value' => 'Description'
            ],
            [
                'label' => 'PIC Customer',
                'value' => 'PicCustomer'
            ],
            [
                'label' => 'Tanggal Surat',
                'value' => 'TanggalSurat'
            ],
            [
                'label' => 'Status',
                'value' => function($data)
                {
                    if($data['Status'] == 'A')
                    {
                        return 'Approved';
                    } else if ($data['Status'] == 'C')
                    {
                        return 'Correction';
                    } else if ($data['Status'] == 'RFA')
                    {
                        return 'Request for Approval';
                    } else if ($data['Status'] == 'D')
                    {
                        return 'Draft';
                    }
                }
            ],
            [
                'label' => 'Action',
                'format' => 'raw',
                'value' => function($data){
                
                    if($data['Status'] != 'A' or $data['Status'] == 'C')
                    {
                        return Html::a('Request Detail', ['allocation-product-d/create', 'id'=>$data['AllocationProductIDH']]); 
                    } else {
                        return '-';
                    }
                     
                }
            ],
        ],
    ]); ?>
    
    <p>
        <?= Html::a('Go Live Produk', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
