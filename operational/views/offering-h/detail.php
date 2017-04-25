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

$this->title = 'Tambah Offering Detail';
//$this->params['breadcrumbs'][] = $this->title;

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

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
    
    $model = app\operational\models\OfferingH::find()->where("OfferingIDH ='".$_GET['id']."'")->one();
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'iDJobDesc.Description:raw:Job Desc',
            [
                'label' => 'Tipe Bayar',
                'format' => 'raw',
                'value' => $model->TipeBayar == 'ADV' ? 'Advance' : 'Ar Rear'
            ],
            'ThnRemunerasi:raw:Tahun Remunerasi',
            [
                'label' => 'Status',
                'format' => 'raw',
                'value' => $model->Status == 'D' ? 'Draft' : 'RFA'
            ],
            [
                'label'=>'Offering Date',
                'value'=> date("j-F-o ",  strtotime($model->OfferingDate)),
                      
            ]
        ],
    ])
            
            
            ?>

    
    <div class="offering-hdr-form">

        <?php $form = ActiveForm::begin(['action'=>'./index.php?r=operational/offering-h/add','method' => 'post']); 
        $job = \app\master\models\MasterArea::find()
//                ->select('mb.Description,mb.BiayaID')
                ->distinct(true)
                ->from('MasterArea ma')
                ->where('Description IS NOT NULL')
                ->all();
        $arrayhelperjob = ArrayHelper::map($job,'AreaID','Description');   

        ?>

        <input type="hidden" name="idofh" value="<?php echo $_GET['id'];?>">
        <input type="hidden" id="idcchid" name="idcchid">
        <input type="hidden" id="gpidhid" name="gpidhid">
        <input type="hidden" id="areaidhid" name="areaidhid">
        <input type="hidden" id="gpseqidhid" name="gpseqidhid">
        <table class="table table-striped table-bordered">
            <tr>
                <td>Cost Calc</td>
                <td>
                <?php echo Html::textInput('ccid',NULL,['disabled'=>true,'class'=>'form-control medbox','id'=>'ccid'])?>
                <?php echo Html::a('...',"index.php?r=operational/offering-h/cch&job=".$model->IDJobDesc, ['class' => 'btn btn-success','id'=>'ccbutton'])?>
                </td>
            </tr>
            <tr>
                <td>Gaji Pokok</td>
                <td><?php echo Html::textInput('gpid',NULL,['disabled'=>true,'class'=>'form-control medbox','id'=>'gpid'])?></td>
            </tr>
            <tr>
                <td>Area</td>
                <td><?php echo Html::textInput('areaid',NULL,['disabled'=>true,'class'=>'form-control medbox','id'=>'areaid'])?></td>
            </tr>
            <tr>
                <td>Class</td>
                <td><?php echo Html::dropDownList('classid', NULL, ['01'=>'Class A','02'=>'Class B','03'=>'Class C'],['prompt' => 'Pilih Class','class'=>'form-control','id'=>'searchdrop1'])?></td>
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
    
    $query = app\operational\models\OfferingD::find()
            ->innerJoin('MasterGajiPokok','MasterGajiPokok.GapokID = OfferingD.GPID and MasterGajiPokok.SeqID = OfferingD.GPSeqID')
            ->innerJoin('MasterArea','MasterArea.AreaID = OfferingD.AreaID')
            ->where("OfferingIDH = '".$_GET['id']."'")
            ->orderBy(['OfferingDID'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);
    
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label'=>'Offering Detail',
                'value' => 'OfferingDID'
            ],
            [
                'label'=>'Cost Cal ID',
                'value' => 'CostcalIDH'
            ],
            [
                'label'=>'Gaji Pokok',
                'value' => 'gP.Amount'
            ],
            [
                'label'=>'Area',
                'value' => 'area.Description'
            ], 
            [
                'label'=>'Class',
                'value' => 'class.ClassDesc'
            ], 
            [
                'label'=>'Delete',
                'format' => 'raw',
                'value' => function($data){
                   return Html::a('Delete','./index.php?r=operational/offering-h/del&idt='.$data['OfferingDID'].'&id='.$data['OfferingIDH']);
                },
//                'method' => 'post',
            ],
            //
        ],
    ]); ?>
    
    
</div>
