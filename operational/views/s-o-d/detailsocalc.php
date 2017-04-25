<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

$this->title = 'Detail SO CostCalc';

$idsod = Yii::$app->request->get('id');

$modelcch = app\operational\models\OfferingD::find()->where(['OfferingDID' => $model->OfferingDID])->one();

$periodupd = $model->PeriodUpdateCoscal;
$statuscc = $model->StatusCoscal;
$mfee = $model->MFee;
$mfeeot = $model->MFeeOT;
$yearnw = Yii::$app->request->post('tahun', date('o'));
$monthnw = Yii::$app->request->post('bulan', date('m'));
$yearf = $yearnw;
$array = array();

for ($i = $yearnw; $i <= $yearf; $i++) {
    $array[$i] = $i;
}

$idCoscalH = Yii::$app->request->get('CostcalIDH', 'xxx');

$sql = 'select ch.CostcalIDH,
            ch.CostcalDate,
            ch.JobDescID,
            mj.Description JobDescription,
            ch.IsActive,
            ch.OfferingDID,
            oh.Status statusOffering,
            ch.SODID,
            sh.Status statusSO
        from CosCalH ch
        left join MasterJobDesc mj on mj.IDJobDesc=ch.JobDescID
        left join OfferingD od on od.CostcalIDH=ch.CostcalIDH
        left join OfferingH oh on oh.OfferingIDH=od.OfferingIDH
        left join SOH sh on sh.OfferingIDH=oh.OfferingIDH
        where ch.CostcalIDH=\'' . $idCoscalH . '\'';

$modelCosCalH = app\operational\models\CosCalH::findBySql($sql)->one();

//// Cek Jika Model Kosong, 
//// artinya data tidak ada (indikasi Error)

$biaya = Yii::$app->db->createCommand("select mb.BiayaID,mb.Description from MasterBiaya mb
                    left join CosCalD cd on cd.BiayaID=mb.BiayaID and CostcalIDH = '" . $idCoscalH . "'
                    where cd.CostcalDID is null
                            and mb.Tipe IN ('1FX','MGM1')")->queryAll();
$arraybiaya = ArrayHelper::map($biaya, 'BiayaID', 'Description');
?>

<h1><?= Html::encode($this->title) ?></h1>
<div class="change-allocation-product-form">
    <?php $form = ActiveForm::begin(['action' => ['change-so-cc'], 'method' => 'post']); ?>
    <input type="hidden" name="idsoh" value="<?= Yii::$app->request->get('idsoh') ?>">
    <input type="hidden" name="idsod" value="<?= Yii::$app->request->get('id') ?>">
    <br><br>
    <table class="table table-striped table-bordered">
        <tr>
            <td style="width:170px;">ID Costcal Header</td>
            <td>: <label id="CostcalH"><?= $idCoscalH ?> </label></td>
        <input type="hidden" value="<?= $idCoscalH ?>" name="idcostcalh">
        </tr>
        <tr>
            <td>Job Description</td>
            <td>: <?= $modelCosCalH->JobDescription ?></td>
        </tr>
        <tr>
            <td>CostCalc Date</td>
            <td>: <?= $modelCosCalH->CostcalDate ?></td>
        </tr>
        <tr>
            <td>OfferingDID</td>
            <td>: <?= $modelCosCalH->OfferingDID ?></td>
        </tr>
        <tr>
            <td>Status Offering</td>
            <td>: <?php
                switch ($modelCosCalH->statusOffering) {
                    case 'D' : echo 'Draft';
                        break;
                    case 'RFA' : echo 'Request For Approval';
                        break;
                    case 'C' : echo 'Correction';
                        break;
                    case 'A' : echo 'Approve';
                        break;
                    default : echo '-';
                }
                ?></td>
        </tr>
        <tr>
            <td>SODID</td>
            <td>: <?php echo $idsod; ?></td>
        </tr>
        <tr>
            <td>Status SO</td>
            <td>: <?php
                switch ($modelCosCalH->statusSO) {
                    case 'D' : echo 'Draft';
                        break;
                    case 'RFA' : echo 'Request For Approval';
                        break;
                    case 'C' : echo 'Correction';
                        break;
                    case 'A' : echo 'Approve';
                        break;
                    default : echo '-';
                }
                ?></td>
        </tr>
        <tr>
            <td style="width: 200px"> Management Fee</td>
            <td>: <?= number_format($mfee, 0, '.', '') . " %"; ?></td>
        </tr>
        <tr>
            <td> Management Fee OT</td>
            <td>: <?= number_format($mfeeot, 0, '.', '') . " %"; ?></td>
        </tr>
    </table>
    <br>
    <?php
    $sql = new yii\db\Query();
    $sql->select('sc.*, mb.Description as biayadesc')
            ->from('SOCostCalc sc')
            ->leftJoin(['mb' => app\master\models\MasterBiaya::tableName()], 'mb.BiayaID = sc.BiayaID')
            ->where(['sc.SODID' => Yii::$app->request->get('id')])
//            ->andWhere(['<>', 'sc.BiayaID', 'M1000001'])
//            ->andWhere(['<>', 'sc.BiayaID', 'M5000001'])
//            ->andWhere(['<>', 'sc.BiayaID', 'GP000001'])
            ->orderBy(['sc.BiayaID' => SORT_ASC]);

    $exec = $sql->all();

    foreach ($exec as $index => $value) {
        echo Html::hiddenInput('biayaid[]', $value['BiayaID']);
    }

    $dataProvider = new ActiveDataProvider([
        'query' => $sql,
        'sort' => false
    ]);
    $dataProvider->pagination->pageSize = 100;

    $modelccd = \app\operational\models\SOCostCalc::find()->where(['SODID' => $model->SODID])->all();
    ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}',
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'header' => 'M Fee',
                'headerOptions' => ['style' => 'text-align:center; width:15px;'],
                'contentOptions' => ['style' => 'text-align:center'],
                'checkboxOptions' => function ($modelccd, $key, $index, $column) {

            if ($modelccd['IsManagementFee'] == 0) {
                return ['value' => $modelccd['BiayaID'], 'checked' => false];
            } else {
                return ['value' => $modelccd['BiayaID'], 'checked' => true];
            }
        }
            ],
            [
                'headerOptions' => ['style' => 'text-align:center; width:200px;'],
                'attribute' => 'biayadesc',
                'contentOptions' => ['style' => 'text-align:left'],
            ],
            [
                'headerOptions' => ['style' => 'text-align:center; width:200px;'],
                'contentOptions' => ['style' => 'text-align:left'],
                'attribute' => 'Value',
                'format' => 'raw',
                'value' => 'Amount'
            ],
            [
                'headerOptions' => ['style' => 'text-align:center; width:200px;'],
                'attribute' => 'Remark',
                'contentOptions' => ['style' => 'text-align:left'],
            ],
        ],
    ]);
    ?>

    <div class="form-group">
<?= Html::a('Back', ['s-o-d/create', 'soidh' => Yii::$app->request->get('idsoh')], ['class' => 'btn btn-success']) ?>
    </div>


<?php ActiveForm::end(); ?>

</div>
