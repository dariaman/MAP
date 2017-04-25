<?php

use app\controllers\GlobalFunction;

$formatx = new GlobalFunction();

$payroll = Yii::$app->db->createCommand(
        "SELECT ph.PayroolIDH,mp.ProductID,mp.Nama,mj.Description,ph.Periode,ph.FixAmount,ph.PotonganAmount,ph.Total
        FROM dbo.PayrollGajiH ph
        INNER JOIN dbo.MasterProduct mp ON mp.ProductID = ph.ProductID
        INNER JOIN dbo.MasterJobDesc mj ON mj.IDJobDesc = mp.IDJobDesc
        WHERE ph.PayroolIDH IN ($PayroolIDH)")->queryAll();
foreach ($payroll as $key => $value) {

$dataT = Yii::$app->db->createCommand("EXEC dbo.ListTunjangan @PyID=$value[PayroolIDH]")->queryAll();
$dataP = Yii::$app->db->createCommand("EXEC dbo.ListPotongan @PyID=$value[PayroolIDH]")->queryAll();

$potongan =0;
$tunjangan=0;
?>
<table style="font-family: 'Courier'; font-size: 10pt; width:100%; height: 135mm; ">
    <tr>
        <td style="width:150px;"><?= $value['ProductID']?></td>
        <td style="width:150px;"><?= $value['Nama']?></td>
        <td style="width:150px;"></td>
    </tr>
    <tr>
        <td style="width:150px; padding-bottom:5px;">Dept: Operational</td>
        <td style="width:150px; padding-bottom:5px;">Position : <?= $value['Description']?></td>
        <td style="width:150px; padding-bottom:5px; text-align: right;">Periode: <?= $formatx->PeriodeToFullString($value['Periode'])?></td>
    </tr>
    <tr>
        <td colspan=3 >
            <table style="width:100%;" cellpadding="10px" cellspacing="0">
                <tr >
                    <td class="JudulKiri"><strong>Penerimaan</strong></td>
                    <td class="JudulKanan"><strong>Jumlah</strong></td>
                    <td class="JudulKiri"><strong>Potongan</strong></td>
                    <td class="JudulKanan"><strong>Jumlah</strong></td>
                </tr>
<tr>
                    <td colspan="2" style="width: 50%;vertical-align:top">
<table style="width: 100%;" cellpadding="0" cellspacing="0">
<?php foreach ($dataT as $ta => $valta) {
?>
    <tr>
        <td><?= $valta['Deskripsi'] ?></td>
        <td style="text-align: right;"><?= number_format($valta['Amount']) ?></td>
    </tr>
<?php  $tunjangan += $valta['Amount']; } ?>
</table>                        
                    </td>
                    <td colspan="2" style="width: 50%;vertical-align:top">
<table style="width: 100%;" cellpadding="0" cellspacing="0">
<?php foreach ($dataP as $ta => $valta) {
?>
    <tr>
        <td><?= $valta['Deskripsi'] ?></td>
        <td style="text-align: right;"><?= number_format($valta['Amount']) ?></td>
    </tr>
<?php  $potongan += $valta['Amount']; } ?>
</table>                         
                    </td>
                </tr>                
                <tr>
                    <td class="JudulKiri"><strong>Total Penerimaan</strong></td>
                    <td class="JudulKanan"><?= number_format($tunjangan)?></td>
                    <td class="JudulKiri"><strong>Total Potongan</strong></td>
                    <td class="JudulKanan"><?= number_format($potongan) ?></td>
                </tr>
                <tr>
                    <td ><strong>Take Home Payment</strong></td>
                    <td style="text-align: right;"><?= number_format($tunjangan - $potongan) ?></td>
                    <td colspan="2"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php
}
