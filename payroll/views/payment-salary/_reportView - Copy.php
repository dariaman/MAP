<?php

$payroll = Yii::$app->db->createCommand(
        "SELECT mp.ProductID,mp.Nama,mj.Description,ph.Periode,ph.FixAmount,ph.PotonganAmount,ph.Total
        FROM dbo.PayrollGajiH ph
        INNER JOIN dbo.MasterProduct mp ON mp.ProductID = ph.ProductID
        INNER JOIN dbo.MasterJobDesc mj ON mj.IDJobDesc = mp.IDJobDesc
        WHERE ph.PayroolIDH='$PayroolIDH'")->queryAll();

?>

<table style="font-family: 'Courier'; font-size: 10pt; width:100%; margin-top:100%;">
    <tr>
        <td style="width:150px;"><?= $payroll[0]['ProductID']?></td>
        <td style="width:150px;"><?= $payroll[0]['Nama']?></td>
        <td style="width:150px;"></td>
    </tr>
    <tr>
        <td style="width:150px; padding-bottom:5px;">Dept: Operational</td>
        <td style="width:150px; padding-bottom:5px;">Position : <?= $payroll[0]['Description']?></td>
        <td style="width:150px; padding-bottom:5px; text-align: right;">Periode: <?= $payroll[0]['Periode']?></td>
    </tr>
    <tr>
        <td colspan=3 style="border-top: 1px solid black;  border-bottom: 1px solid black; padding-top:5px; padding-bottom:5px;">
            <table style="width:100%;">
                <tr>
                    <td style="text-align: left;"><strong>Penerimaan</strong></td>
                    <td style="text-align: right; padding-right:20px;"><strong>Jumlah</strong></td>
                    <td style="text-align: left; padding-left:20px;"><strong>Potongan</strong></td>
                    <td style="text-align: right;"><strong>Jumlah</strong></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan=3 style="padding-top:5px;">
	<table style="width:100%;" >
                <tr>
                    <td style="width:49%; " valign='top'>
                        <table style="width:100%;">
                            <tr>
                                <td style="text-align:left;"></td>
                                <td style="text-align:right; padding-right:-10px;"></td>
                            </tr> 
                        </table>
                    </td>
                    <td></td>
		<td style="width:49%;" valign='top'>
                        <table style="width:100%;">
                            <tr>
                                <td style="text-align:left; padding-left:45px;"></td>
                                <td style="text-align:right; padding-right:-15px;"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding-top:150px;"></td>
    </tr>
    <tr>
        <td colspan=3 style="border-top: 1px solid black;  border-bottom: 1px solid black; padding-top:5px; padding-bottom:5px;">
            <table style="width:100%;">
                <tr>
                    <td style="text-align: left;"><strong>Total Penerimaan</strong></td>
                    <td style="text-align: right; padding-left:-15px;"><?= number_format($payroll[0]['FixAmount'])?></td>
                    <td style="text-align: left; padding-left:20px;"><strong>Total Potongan</strong></td>
                    <td style="text-align: right;"><?= number_format($payroll[0]['PotonganAmount']) ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan=3 style="padding-top:5px; padding-bottom:5px;">
            <table style="width:100%;">
                <tr>
                    <td style="text-align: left;"><strong>Take Home Payment</strong></td>
                    <td style="text-align: right; padding-right:-5px;"><?= number_format($payroll[0]['Total']) ?></td>
                    <td style="width:25%"></td>
                    <td style="width:25%"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
