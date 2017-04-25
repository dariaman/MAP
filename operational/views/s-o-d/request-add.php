<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;
//use yii\grid\GridView;
//use kartik\grid\GridView;
//use yii\data\ActiveDataProvider;

$this->title = 'Request Add Product';

$glid = Yii::$app->request->get('id');
$sodid = Yii::$app->request->get('sodid');
$sohid = Yii::$app->request->get('sohid');

$modelGoLive = new app\operational\models\GoLiveProduct();

$sql = "select
mj.Description as JobDescName,sd.OfferingDID,sd.Qty,ma.Description as AreaName,mj.IDJobDesc,ma.AreaID,sd.PeriodFrom,sd.PeriodTo
from SOD sd
left join SOH sh on sh.SOIDH = sd.SOIDH
left join OfferingD od on od.OfferingDID = sd.OfferingDID
left join MasterGajiPokok mg on mg.GapokID = od.GPID and mg.SeqID = od.GPSeqID
left join MasterJobDesc mj on mj.IDJobDesc = mg.IDJobDesc
left join MasterArea ma on ma.AreaID = mg.AreaID
where sd.SODID = '$sodid'  and sd.SOIDH = '$sohid'";

$SODOutstanding = Yii::$app->db->createCommand($sql)->queryAll();

?>

<h1><?= Html::encode($this->title) ?></h1>
<div class="change-allocation-product-form">
    <?php $form = ActiveForm::begin();?>
    
    <table class="table table-striped table-bordered">
        <tr>
            <td style="width:200px;">ID SO Header</td>
            <td>: <?= $sohid ?> </td>
        </tr>
        <tr>
            <td style="width:200px;">ID SO Detail</td>
            <td>: <?= $sodid ?> </td>
        </tr>
        <tr>
            <td style="width:200px;">ID Offering Detail</td>
            <td>: <?= $SODOutstanding[0]['OfferingDID'] ?> </td>
        </tr>
        <tr>
            <td style="width:200px;">Job Description</td>
            <td>: <?= $SODOutstanding[0]['JobDescName'] ?> </td>
        </tr>
        <tr>
            <td style="width:200px;">Area Description</td>
            <td>: <?= $SODOutstanding[0]['AreaName'] ?> </td>
        </tr>
        <tr>
            <td style="width:200px;">Jumlah</td>
            <td>: <?= $SODOutstanding[0]['Qty'] ?> </td>
        </tr>
        <tr>
            <td style="width:200px;">Period To</td>
            <td>: <?= $SODOutstanding[0]['PeriodTo'] ?> </td>
        </tr>
        <tr>
            <td style="width:200px;">Period From</td>
            <td>: <?= $SODOutstanding[0]['PeriodFrom'] ?> </td>
        </tr>
        <tr>
            <td style="width:200px;">Product </td>
            <td> <?= $form->field($modelGoLive,'ProductID')->textInput(['readonly' => true,'class' => 'form-control medbox']); ?>
                <?php //Html::a('...',['/lookup/#'],['class'=>'btn btn-success','id'=>'prbutton']); ?>

                <?= Html::button('',
                            ['value'=> Url::to('?r=lookup/lookupmodalprod&idjob='.$SODOutstanding[0]['IDJobDesc']),
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
    </table>
    <?= Html::submitButton('Save', ['class' =>'btn btn-success']) ?>
    <?= Html::a('Cancel', (['s-o-d/detailsod','soh' => Yii::$app->request->get('sohid'),'did' => Yii::$app->request->get('sodid')]), ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>
    
</div>
<?php

$script = <<<SKRIPT
        
$('#btnlookuprod').click(function(){
    $('#modalprodlookup').modal('show')
        .find('#modalprodcontent')
        .load($(this).attr('value'));        
});
        
SKRIPT;
$this->registerJs($script);

?>