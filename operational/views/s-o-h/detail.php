<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
//use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\OfferingHdrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tambah SO Detail';
//$this->params['breadcrumbs'][] = $this->title;

$script = <<<SKRIPT

$('.of').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
});
        
$('.cc').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
});
        
$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

$('#ofbutton').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
});
        
$('#ccbutton').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "_blank", "width=800,height=600,scrollbars=yes,location=no");
});
    
    
SKRIPT;

$this->registerJs($script);

?>
<div class="offering-hdr-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php //Pjax::begin(['id' => 'PtlCommentsPjax']);
    
    $model = app\operational\models\SOH::find()->where("SOIDH ='".$_GET['id']."'")->one();
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'SOIDH:raw:SO ID Header',
            'Tipe:raw:Tipe',
            'PONo:raw:PO Number',
            'customer.CustomerName:raw:Customer',
            [
                'label'=>'Offering Date',
                'value'=> date("j-F-o ",  strtotime($model->SODate)),
                      
            ]
        ],
    ])
            
            
            ?>

    
    <div class="offering-hdr-form">

        <?php $form = ActiveForm::begin(['action'=>'./index.php?r=operational/s-o-h/add','method' => 'post']); 
        if($model->Tipe == 'LT')
        {
            $lt = 'display:in-line';
        } else {
            $lt = 'display:none';
        }
        
        if($model->Tipe == 'ST')
        {
            $st = 'display:in-line';
        }else {
            $st = 'display:none';
        }
        
        ?>

        <input type="hidden" name="idcchdr" value="<?php echo $_GET['id'];?>">
        <input type="hidden" name="ofdhid" id="ofdhid" value="">
        <input type="hidden" name="ccidhid" id="ccidhid" value="">
        <input type="hidden" name="areaidhid" id="areaidhid" value="">
        <input type="hidden" name="tipe" value="<?php echo $model->Tipe; ?>">
        <table class="table table-striped table-bordered">
            <tr style="<?= $lt?>">
                <td>Offering ID</td>
                <td>
                <?php echo Html::textInput('ofd',NULL,['disabled'=>true,'class'=>'form-control medbox','id'=>'ofd','style'=>$lt])?>
                <?php echo Html::a('...',"index.php?r=operational/s-o-h/ofd&soid=".$model->SOIDH."&tipe=".$model->Tipe, ['class' => 'btn btn-success','id'=>'ofbutton','style'=>$lt])?>
                </td>
            </tr>
            <tr >
                <td>Cost Calc</td>
                <td>
                <?php echo Html::textInput('ccid',NULL,['disabled'=>true,'class'=>'form-control medbox','id'=>'ccid'])?>
                <?php echo Html::a('...',"index.php?r=operational/s-o-h/ccd&tipe=".$model->Tipe, ['class' => 'btn btn-success','id'=>'ccbutton','style'=>$st])?>
                </td>
            </tr>
            <tr>
                <td>Area</td>
                <td>
                    <?php echo Html::textInput('areaid',NULL,['disabled'=>true,'class'=>'form-control medbox','id'=>'areaid'])?>    
                </td>
            </tr>
            <tr>
                <td>Qty</td>
                <td>
                    <?php echo Html::textInput('qty',NULL,['disabled'=>false,'class'=>'form-control medbox','id'=>'qty'])?>    
                </td>
            </tr>
            <tr>
                <td>Period From</td>
                <td>
                    <?php // /Html::textInput('from',NULL,['disabled'=>false,'class'=>'form-control medbox','id'=>'from'])?>
                    <?= DatePicker::widget([
                        'name' => 'PeriodFrom',
                        'options' => ['placeholder' => 'Enter Date...','style'=>'width:160px','id'=>'periodfrom'],
                        'pluginOptions' => ['autoclose'=>true,'format' => 'yyyy-mm-dd']]);

                    ?>
                </td>
            </tr>
            <tr>
                <td>Period To</td>
                <td>
                    <?php //Html::textInput('to',NULL,['disabled'=>false,'class'=>'form-control medbox','id'=>'to'])?>
                    <?= DatePicker::widget([
                                'name' => 'PeriodTo',
                                'options' => ['placeholder' => 'Enter Date...','style'=>'width:160px','id'=>'periodto'],
                                'pluginOptions' => ['autoclose'=>true,'format' => 'yyyy-mm-dd']]);

                    ?>
                </td>
            </tr>
        </table>
        <?php //print_r($model); die(); ?>
        <div class="form-group" style="margin-left:45%;">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
             <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    
    
    <?php
    
    $query = app\operational\models\SOD::find()
            ->where("SOIDH = '".$_GET['id']."'")
            ->orderBy(['SODID'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);
    
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label'=>'SO Detail',
                'value' => 'SODID'
            ],
            [
                'label'=>'SO ID Header',
                'value' => 'SOIDH'
            ],
            [
                'label'=>'Offering ID',
                'format'=>'raw',
                'value'=>function($data)
                {
                    return Html::a($data['OfferingDID'],'./index.php?r=operational/s-o-h/detaild&id='.$data['OfferingDID'].'&type=of',['class'=>'of']);
                }
            ],
            [
                'label'=>'Costcalc ID',
                'format'=>'raw',
                'value'=>function($data)
                {
                    return Html::a($data['CostcalIDH'],'./index.php?r=operational/s-o-h/detaild&id='.$data['CostcalIDH'].'&type=cc',['class'=>'cc']);
                }
            ],
            [
                'label'=>'Area',
                'value' => 'area.Description'
            ], 
            [
                'label'=>'Jumlah',
                'value' => 'Qty'
            ],
            [
                'label'=>'Periode From',
                'value' => 'PeriodFrom'
            ],
            [
                'label'=>'Periode To',
                'value' => 'PeriodTo'
            ],
            [
                'label'=>'Status',
                'value' => function($data)
                {
                    if ($data['Status'] == 'NM')
                    {
                        return 'Normal';
                    } else {
                        return '-';
                    }
                }
            ],
            [
                'label'=>'Aksi',
                'format' => 'raw',
                'value' => function($data){
                   return Html::a('Hapus','./index.php?r=operational/s-o-h/del&idt='.$data['SODID'].'&id='.$data['SOIDH']);
                }
//                'method' => 'post',
            ],
            //
        ],
    ]); ?>
    
    
</div>
