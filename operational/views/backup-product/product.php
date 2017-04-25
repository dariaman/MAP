<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\AllocationProductDSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Go Live';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-product-d-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(['id' => 'PtlCommentsPjax']); ?>
    <?php echo $this->render('searchpro', ['model' => $searchModell]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'select',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::radio('ProductID', false, ['class' => 'of',
                                'value' =>
                                //$data['ProductID'] . "|" .
                                //$data['Nama'] . "|" .
                                $data['SODID']]);
                },
                    ],
                    //'ProductID',
                    //'Nama',
                    'SOIDH',
                    'SODID',
                    //'SeqProduct',
//                    'AreaDetailDesc',
                // 'LicensePlate',
                // 'TglTugas',
                // 'IsActive',
                // 'IsShift',
                // 'HariKerja',
                // 'NoPKWT',
                // 'UserCrt',
                // 'DateCrt',
//            ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>

            <?php Pjax::end(); ?>
            <p>
                <?= Html::a('Select', NULL, ['class' => 'btn btn-success', 'id' => 'getpo']) ?>
            </p>


        </div>
        <?php
        $script = <<<SKRIPT
   
   function setvalue()
    {
        var pro = $("[name=ProductID]:checked").val().split("|");
                
        var pro1 = pro[0];
        var pro2 = pro[1];                
        var pro3 = pro[2];
        var pro4 = pro[3];
            
        if (window.opener != null && !window.opener.closed) 
                {
                    $('#Topro',opener.document).val(pro);
                
                    $('#proadhi1',opener.document).val(pro[0]);
                    $('#proadhi2',opener.document).val(pro[1]);
                    $('#proadhi3',opener.document).val(pro[2]);
                    $('#proadhi4',opener.document).val(pro[3]);
                 
                }
            window.close();
        }
    $('#getpo').click( setvalue );
       

SKRIPT;

        $this->registerJs($script);
        