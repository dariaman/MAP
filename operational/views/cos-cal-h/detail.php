<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
//use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\OfferingHdrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tambah Cost Calc Detail';
//$this->params['breadcrumbs'][] = $this->title;

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);

?>
<div class="offering-hdr-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php //Pjax::begin(['id' => 'PtlCommentsPjax']);
    
    $model = app\operational\models\CosCalH::find()->where("CostcalIDH ='".$_GET['id']."'")->one();
//    $modeld = app\operational\models\CosCalD;
    
    ?>
    <?= DetailView::widget([
            'model' => $model,
            'attributes' => [            
                'jobDesc.Description:raw:Job Desc',
                'area.Description:raw:Area',
                'Tipe:raw:Tipe',
                [
                    'label'=>'Cost Calc Date',
                    'value'=> date("j-F-o ",  strtotime($model->CostcalDate)),
                ]
            ],
        ])
    ?>

    <div class="offering-hdr-form">

        <?php $form = ActiveForm::begin(['action'=>'./index.php?r=operational/cos-cal-h/add','method' => 'post']); 
            $area = \app\master\models\MasterArea::find()
    //                ->select('ma.Description,ma.BiayaID')
                    ->from('MasterArea ma')
                    ->all();
            $arrayhelperarea = ArrayHelper::map($area,'AreaID','Description');
        ?>

        <input type="hidden" name="idcchdr" value="<?php echo $_GET['id'];?>" id="idcchdr"> 
        <table class="table table-striped table-bordered">
            <tr>
                <td style="width:200px">Tipe Biaya</td>
                <td>
                    
                    <?php 
                        echo Html::dropDownList('TipeBiaya', NULL, 
                            ['FIX'=> 'Fix','NFX'=>'Non Fix','TMB' => 'Tambahan'], 
                            ['prompt' => 'Select Tipe Biaya','class'=>'form-control', 'id'=>'searchdrop1']) ;
                    ?>
                </td>
            </tr>
            <tr>
                <td>Jenis Biaya</td>
                <td>
                    
                    
                        <?= Html::dropDownList('selecttype',NULL, 
                        ['P'=>'Potongan','T'=>'Tunjangan'],
                    ['class'=>'form-control','id'=>'searchdrop1','prompt' => 'Select Jenis',
                    'onchange'=>'
                        $.post("index.php?r=operational/cos-cal-h/lists&id="+$(this).val()+"&idcc="+$("#idcchdr").val(), function( data ) {
                          $( "select#searchdrop3" ).html( data );
                        });
                    '])?>
            </tr>
            <tr>
                <td>Deskripsi Biaya</td>
                <td>
                    <?php 
                    echo Html::dropDownList('jenis', NULL, [''], 
                        ['prompt' => '-','class'=>'form-control', 'id'=>'searchdrop3']);

//                    echo $form->field($model, 'jenis')->widget(Select2::classname(),[
//                       'name' => 'AreaID',
//                       'data' => $arrayhelperarea,
//                       'options' => [
//                           'placeholder' => 'Select Biaya ...',
//                       ],
//                   ]);

                    ?>
                </td>
                </td>
            </tr>
            <tr>
                <td>Amount</td>
                <td><?php
                     echo Html::textInput('Amount','',['id'=>'amount','class'=>'form-control']);
                ?>
                </td>
            </tr>
<!--            <tr>
                <td>Is Percentage</td>
                <td><?php
                     echo Html::checkbox('percent',false,['id'=>'check']);
                ?></td>
            </tr>-->
            <tr>
                <td>Remark</td>
                <td><?php
                     echo Html::textInput('Remark','',['id'=>'amount','class'=>'form-control']);
                ?>
                </td>
            </tr>
        </table>
        <?php //print_r($model); die(); ?>
        <div class="form-group" style="margin-left:45%;">
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
             <?= Html::a('Kembali',['index'], ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    
    
    <?php
    
    $query = app\operational\models\CosCalD::find()
            ->where("CostcalIDH = '".$_GET['id']."'")
            ->orderBy(['BiayaID'=>SORT_ASC,'CostcalDID'=> SORT_ASC])
            
            ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);
    
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label'=>'Cost Calc Detail',
                'value' => 'CostcalDID'
            ],
            [
                'label'=>'Tipe Biaya',
                'value' => 'TipeBiaya'
            ],
            [
                'label'=>'Jenis Biaya',
                'value' => function($data)
                {
                    $biayadesc = \app\master\models\MasterBiaya::find()
                            ->select('Description')
                            ->where("BiayaID = '".$data['BiayaID']."'")
                            ->one();
                    
                    if($data['BiayaID'][0] == 'T')
                    {
                        $detail = "Tunjangan ".$biayadesc['Description'];
                        
                    } else {
                        $detail = "Potongan ".$biayadesc['Description'];
                        
                    }
                    return $detail;
                }
            ],
            [
                'label'=>'Jumlah',
                'value' => 'Amount'
            ],
            [
                'label'=>'Remark',
                'value' => 'Remark'
            ],
            [
                'label'=>'Aksi',
                'format' => 'raw',
                'value' => function($data){
                   return Html::a('Hapus','./index.php?r=operational/cos-cal-h/del&idt='.$data['CostcalDID'].'&id='.$data['CostcalIDH'],['onclick'=>'return confirm("Apakah ingin di hapus?")']);
                },
//                'method' => 'post',
            ],
            //
        ],
    ]); ?>
    
    
</div>
