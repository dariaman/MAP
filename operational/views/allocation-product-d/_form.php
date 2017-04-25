<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use app\operational\models\AllocationProductD;
use app\operational\models\JadwalGolive;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\checkbox\CheckboxX;
   
    if (isset($_GET['id'])){
        $idApH = preg_replace('/[^A-Za-z0-9\-]/', '', $_GET['id']);
    }
    else {
        $idApH ='xxx';
    }

$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})
     
   $.myFunction = function(id){ 
        var h1 = $('#chk');
        
        if($(id).is(':checked'))
        {
            var idcheck = id.substr(id.length-1)
            var a = h1.val();
            var b = "Y";            
        
            if(idcheck == 7)
            {
                var output = [a.slice(0, idcheck-1), b, a.slice(0,idcheck-7)].join('');
            } else {
                var output = [a.slice(0, idcheck-1), b, a.slice(idcheck-7)].join('');
            }
            
            $('#chk').attr("value",output);
        } else {
           
            var idcheck = id.substr(id.length-1)
            var a = h1.val();
            var b = "N";            
        
            if(idcheck == 7) {
                var output = [a.slice(0, idcheck-1), b, a.slice(0,idcheck-7)].join('');
            } else {
                var output = [a.slice(0, idcheck-1), b, a.slice(idcheck-7)].join('');
            }
            
            $('#chk').attr("value",output);
        }
         
    }
        
$('#btnlookupsod').click(function(){
    $('#modalsodlookup').modal('show')
        .find('#modalsodcontent')
        .load($(this).attr('value'));        
});         

$('#btnlookuprod').click(function(){
    $('#modalprodlookup').modal('show')
        .find('#modalprodcontent')
        .load($(this).attr('value'));        
});
SKRIPT;

$this->registerJs($script);

?>
<div class="offering-hdr-index">

    <?php //Pjax::begin(['id' => 'PtlCommentsPjax']);
    
    $modelJadwal = new JadwalGolive();
 
    
    $modelAPH = app\operational\models\AllocationProductH::find()
            ->select('aph.AllocationProductIDH,
                        aph.SOIDH,
                        aph.Description,
                        aph.PicCustomer,
                        aph.Status,
                        mj.Description as JobName,
                        oh.IDJobDesc')
            ->from('AllocationProductH aph')
            ->leftJoin('SOH sh','sh.SOIDH = aph.SOIDH')
            ->leftJoin('OfferingH oh','oh.OfferingIDH = sh.OfferingIDH')
            ->leftJoin('MasterJobDesc mj','mj.IDJobDesc = oh.IDJobDesc')
            ->where("aph.AllocationProductIDH ='".$idApH."'")
            ->one();
    
    $act = 'index.php?r=operational/allocation-product-d/create&id='.$idApH;
    ?>
    
    <div class="offering-hdr-form">

        <?php $form = ActiveForm::begin(); 
            $count = AllocationProductD::find()->select(['COUNT(ProductID) as cnt'])->where("AllocationProductIDH = '".$idApH."'")->one();
            $sisa = ($modelAPH->Qty) - ($count->cnt);
        ?>

        <input type="hidden" name="idsohdr" value="<?php echo $_GET['id'];?>">
        <input type="hidden" name="sodidhid" id="sodidhid" >
        <input type="hidden" name="ofdid" id="cchhid" >
        <input type="hidden" name="areaidhid" id="areaidhid" >
        <input type="hidden" name="jobdeschid" id="jobdeschid" >
        <input type="hidden" name="prodhid" id="prodhid" >
        <input type="hidden" name="qtyhid" id="qtyhid" >
        <input type="hidden" name="start" id="start" >
        <input type="hidden" name="end" id="end" >
        <input type="hidden" name="chk" id="chk" maxlength="7" class="form-control medbox" value="NNNNNNN">

        <table class="table table-striped table-bordered">            
            <tr>
                <td style="width:200px;">ID Go Live Header</td>
                <td>: <label id="SOIDH"><?= $idApH ?> </label></td>
            </tr>
            <tr>
                <td style="width:200px;">ID SO Header</td>
                <td>: <label id="SOIDH"><?= $modelAPH->SOIDH ?> </label></td>
            </tr>
            <tr>
                <td>Description</td>
                <td>: <?= $modelAPH->Description ?></td>
            </tr>
            <tr>
                <td>PIC Customer </td>
                <td>: <?= $modelAPH->PicCustomer ?></td>
            </tr>
            <tr>
                <td>Job Desc </td>
                <td>: <?= $modelAPH->JobName ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>: <?php switch($modelAPH->Status) {
                                    case 'A' : echo 'Approve'; break;
                                    case 'C' : echo 'Correction'; break;
                                    case 'RFA' : echo 'RFA'; break;
                                    case 'D' : echo 'Draft'; break;
    } ?></td>
            </tr>
            <?php if ($modelAPH->Status =='D' || $modelAPH->Status =='C'){?>
            <tr>
                <td>SO Detail</td>
                <td>
                    <?= $form->field($model,'SODID')->textInput(['readonly' => true,'class' => 'form-control medbox display-block']); ?>
                    <?= Html::button('',
                                ['value'=> Url::to('?r=lookup/lookupmodalsod&soh='.$modelAPH->SOIDH),
                                    'class'=>'glyphicon glyphicon-search',
                                    'id'=>'btnlookupsod']);
                        Modal::begin([
                                'header'=>'Offering Detail',
                                'id' => 'modalsodlookup',
                                'size'=>'modal-lg'
                            ]);
                        echo "<div id=modalsodcontent></div>";
                        Modal::end();
                    ?>
                </td>
            </tr>
            <tr>
                <td>Period From</td>
                <td>
                        <?= Html::textInput('periodfrom',NULL,['readonly' => true,'class' => 'form-control smbox','id' => 'pfrom']); ?>
                </td>
            </tr>
            <tr>
                <td>Period To</td>
                <td>
                        <?= $form->field($model,'PeriodTo')->textInput(['readonly' => true,'class' => 'form-control smbox']); ?>
                </td>
            </tr>
            <tr>
                <td>Offering Detail</td>
                <td><?= Html::textInput('OfferingDID',NULL,['readonly' => true,'id'=>'ofd','class' => 'form-control medbox']); ?></td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td><?= Html::textInput('qty',NULL,['readonly'=>true,'id'=>'qty','class'=>'form-control smbox']) ?> </td>
            </tr>
        <!--    <tr>
                <td>Sudah Di Alokasi</td>
                <td><?php //Html::textInput('sisa',NULL,['readonly'=>true,'id'=>'sisa','class'=>'form-control smbox']) ?> </td>
            </tr> -->
            <tr>
                <td>Area</td>
                <td><?= Html::textInput('Area',NULL,['readonly'=>true,'id'=>'area','class'=>'form-control ','style'=>'width:45%;']) ?>  </td>
            </tr>                
            <tr>
                <td>Product</td>
                <td>
                    <?= $form->field($model,'ProductID')->textInput(['readonly' => true,'class' => 'form-control medbox']); ?>
                    <?php //Html::a('...',['/lookup/#'],['class'=>'btn btn-success','id'=>'prbutton']); ?>
                    
                    <?= Html::button('',
                                ['value'=> Url::to('?r=lookup/lookupmodalprod&idjob='.$modelAPH->IDJobDesc),
                                    'class'=>'glyphicon glyphicon-search',
                                    'id'=>'btnlookuprod']);
                        Modal::begin([
                                'header'=>'Product Detail',
                                'id' => 'modalprodlookup',
                                'size'=>'modal-lg'
                            ]);
                        echo "<div id=modalprodcontent></div>";
                        Modal::end();
                    ?>
                </td>
            </tr>
            <tr>
                <td>Area Detail</td>
                <td><?= $form->field($model, 'AreaDetailDesc')->textInput(['class' => 'form-control medbox']) ?></td>
            </tr>
            <tr>
                <td>License Plate</td>
                <td><?= $form->field($model, 'LicensePlate')->textInput(['class' => 'form-control medbox']) ?></td>
            </tr>
            <tr id="tgl">
                <td>Tanggal Tugas</td>
                <td ><?= $form->field($model, 'TglTugas')->widget(DatePicker::classname(), [
                    'options' => [
                        'placeholder' => 'Enter Date ...'
                        ],
                    'pluginOptions' => ['autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                        'startDate' => "2015-11-18",
                        'endDate' => '2016-12-01',
                        'todayHighlight' => true]
                ]); ?>  </td>
            </tr>
            <tr>
                <td>Shift</td>
                <td>
                    <?= $form->field($model,'IsShift')->widget(CheckboxX::classname(), ['pluginOptions'=>['threeState'=>false,'size'=>'sm']]);?>
                </td>
            </tr>
            <tr id="kerja">
                <td>Hari Kerja</td>
                <td>
                    <table class="table table-striped table-bordered" style="width:450px;">
                        <tr>
                            <td style="width:100px;">Hari</td>
                            <td style="width:50px;">Jam Masuk</td>
                            <td style="width:50px;">Jam Keluar</td>
                        </tr>
                        <tr>
                            <td>
                                <?= CheckboxX::widget(['name'=>'H1', 'autoLabel' => true,'labelSettings' => ['label' => 'Senin','position' => CheckboxX::LABEL_LEFT],'options'=>['id'=>'H1' ], 'pluginOptions'=>['size'=>'sm','threeState'=>false]]);?>           
                            </td>
                            <td> <?= TimePicker::widget(['model' => $modelJadwal,
                                    'attribute' => 'Monday1',
                                    'pluginOptions' => [
                                        'showMeridian' => false,
                                        'showSeconds' => false
                                    ]]) ?>
                            </td>
                            <td> <?= TimePicker::widget(['model' => $modelJadwal,
                                    'attribute' => 'Monday2',
                                    'pluginOptions' => [
                                        'showMeridian' => false,
                                        'showSeconds' => false
                                    ]]) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <?= CheckboxX::widget(['name'=>'H2', 'autoLabel' => true,'labelSettings' => ['label' => 'Selasa','position' => CheckboxX::LABEL_LEFT],'options'=>['id'=>'H2' ], 'pluginOptions'=>['size'=>'sm','threeState'=>false]]);?>           
                            </td>
                            <td> <?= TimePicker::widget(['model' => $modelJadwal,
                                    'attribute' => 'Tuesday1',
                                    'pluginOptions' => [
                                        'showMeridian' => false,
                                        'showSeconds' => false
                                    ]]) ?>
                            </td>
                            <td> <?= TimePicker::widget(['model' => $modelJadwal,
                                    'attribute' => 'Tuesday2',
                                    'pluginOptions' => [
                                        'showMeridian' => false,
                                        'showSeconds' => false
                                    ]]) ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?= CheckboxX::widget(['name'=>'H3', 'autoLabel' => true,'labelSettings' => ['label' => 'Rabu','position' => CheckboxX::LABEL_LEFT],'options'=>['id'=>'H3' ], 'pluginOptions'=>['size'=>'sm','threeState'=>false]]);?></td>
                            <td> <?= TimePicker::widget(['model' => $modelJadwal,
                                    'attribute' => 'Wednesday1',
                                    'pluginOptions' => [
                                        'showMeridian' => false,
                                        'showSeconds' => false
                                    ]]) ?>
                            </td>
                            <td> <?= TimePicker::widget(['model' => $modelJadwal,
                                    'attribute' => 'Wednesday2',
                                    'pluginOptions' => [
                                        'showMeridian' => false,
                                        'showSeconds' => false
                                    ]]) ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?= CheckboxX::widget(['name'=>'H4', 'autoLabel' => true,'labelSettings' => ['label' => 'Kamis','position' => CheckboxX::LABEL_LEFT],'options'=>['id'=>'H4' ], 'pluginOptions'=>['size'=>'sm','threeState'=>false]]);?>           </td>
                            <td> <?= TimePicker::widget(['model' => $modelJadwal,
                                    'attribute' => 'Thursday1',
                                    'pluginOptions' => [
                                        'showMeridian' => false,
                                        'showSeconds' => false
                                    ]]) ?>
                            </td>
                            <td> <?= TimePicker::widget(['model' => $modelJadwal,
                                    'attribute' => 'Thursday2',
                                    'pluginOptions' => [
                                        'showMeridian' => false,
                                        'showSeconds' => false
                                    ]]) ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?= CheckboxX::widget(['name'=>'H5', 'autoLabel' => true,'labelSettings' => ['label' => "Jum'at",'position' => CheckboxX::LABEL_LEFT],'options'=>['id'=>'H5' ], 'pluginOptions'=>['size'=>'sm','threeState'=>false]]);?>           </td>
                            <td> <?= TimePicker::widget(['model' => $modelJadwal,
                                    'attribute' => 'Friday1',
                                    'pluginOptions' => [
                                        'showMeridian' => false,
                                        'showSeconds' => false
                                    ]]) ?>
                            </td>
                            <td> <?= TimePicker::widget(['model' => $modelJadwal,
                                    'attribute' => 'Friday2',
                                    'pluginOptions' => [
                                        'showMeridian' => false,
                                        'showSeconds' => false
                                    ]]) ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?= CheckboxX::widget(['name'=>'H6', 'autoLabel' => true,'labelSettings' => ['label' => 'Sabtu','position' => CheckboxX::LABEL_LEFT],'options'=>['id'=>'H6' ], 'pluginOptions'=>['size'=>'sm','threeState'=>false]]);?>           </td>
                            <td> <?= TimePicker::widget(['model' => $modelJadwal,
                                    'attribute' => 'Saturday1',
                                    'pluginOptions' => [
                                        'showMeridian' => false,
                                        'showSeconds' => false
                                    ]]) ?>
                            </td>
                            <td> <?= TimePicker::widget(['model' => $modelJadwal,
                                    'attribute' => 'Saturday2',
                                    'pluginOptions' => [
                                        'showMeridian' => false,
                                        'showSeconds' => false
                                    ]]) ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?= CheckboxX::widget(['name'=>'H7', 'autoLabel' => true,'labelSettings' => ['label' => 'Minggu','position' => CheckboxX::LABEL_LEFT],'options'=>['id'=>'H7' ], 'pluginOptions'=>['size'=>'sm','threeState'=>false]]);?>           </td>
                            <td> <?= TimePicker::widget(['model' => $modelJadwal,
                                    'attribute' => 'Sunday1',
                                    'pluginOptions' => [
                                        'showMeridian' => false,
                                        'showSeconds' => false
                                    ]]) ?>
                            </td>
                            <td> <?= TimePicker::widget(['model' => $modelJadwal,
                                    'attribute' => 'Sunday2',
                                    'pluginOptions' => [
                                        'minuteStep' => 30,
                                        'showMeridian' => false,
                                        'showSeconds' => false
                                    ]]) ?>
                            </td>
                        </tr>                        
                    </table>
                </td>
            </tr>
        </table>
        <?php 
//        if($sisa == 0) {
//            $hid = "display:none;";
//        } else {
//            $hid = "display:in-line";
//        }
//        'style'=>$hid
        ?>
        <br><br>  
        <div class="form-group">
            <?php if($modelAPH->Status == 'RFA') 
                {
                    echo Html::a('Cancel Request',['allocation-product-d/cancel-request','id' => $idApH ], ['class' => 'btn btn-success','id' => 'crfa']);
                } else {
                    echo Html::a('Request for Approval',['allocation-product-d/request','id' => $idApH ], ['class' => 'btn btn-success','id' => 'rfa']);
                }
                
                ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <br><br>
        <?php } else {?>
        </table>
        <?php }?>
        <div class="form-group">
            
            <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    
    
    <?php
   
        $sql = new yii\db\Query();
        
        $sql->select ('apd.AllocationProductIDH, 
                    sd.SODID,
                    od.OfferingDID,
                    ma.Description AreaDesc, 
                    mj.Description JobDesc, 
                    mp.ProductID,
                    mp.Nama,
                    apd.AreaDetailDesc,
                    apd.LicensePlate,
                    apd.TglTugas')
                ->from('AllocationProductD apd')
                ->leftJoin('SOD sd','sd.SODID = apd.SODID')
                ->leftJoin('SOH sh','sh.SOIDH = sd.SOIDH')
                ->leftJoin('OfferingD od','od.OfferingDID = sd.OfferingDID')
                ->leftJoin('OfferingH oh','oh.OfferingIDH = od.OfferingIDH')
                ->leftJoin('MasterProduct mp','mp.ProductID = apd.ProductID')
                ->leftJoin('MasterJobDesc mj','mj.IDJobDesc = oh.IDJobDesc')
                ->leftJoin('MasterArea ma','ma.AreaID = od.AreaID')
            ->where("apd.AllocationProductIDH = '".$_GET['id']."'")
            ->orderBy(['apd.AllocationProductIDH'=>SORT_ASC]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $sql,
            'sort' => false
        ]);
    
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label'=>'SO ID Detail',
                'value' => 'SODID'
            ],
            [
                'label'=>'Offering ID Detail',
                'value' => 'OfferingDID'
            ],
            [
                'label'=>'Area',
                'value' => 'AreaDesc'
            ], 
            [
                'label'=>'Job Desc',
                'value' => 'JobDesc'
            ],
            'ProductID',
            [
                'label'=>'Product',
                'value' => 'Nama'
            ],
         
            [
                'label'=>'Area Detail',
                'value' => 'AreaDetailDesc'
            ],
            [
                'label'=>'License Plate',
                'value' => 'LicensePlate'
            ],
            [
                'label'=>'Tgl Tugas',
                'value' => 'TglTugas'
            ],
            [
                'label'=>'Action',
                'format' => 'raw',
                'value' => function($data){
                       return Html::a('Delete',
                                    ['del', 'idh' => $data['AllocationProductIDH'],
                                            'prid' => $data['ProductID']],
                                    ['data' => [
                                        'confirm' => 'Are you sure you want to delete this item ?',
                                        'method' => 'post',
                                    ]]
                               );
                },
            ],
        ],
    ]); ?>
    
    
</div>
<?php

?>