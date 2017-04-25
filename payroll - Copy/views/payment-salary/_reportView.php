<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\payroll\models\PayrollGajiD */
/* @var $form yii\widgets\ActiveForm */
    
    if(!isset($pr))
    {
       $sql = "select mp.Nama as Name,mp.NIK as NIK,mj.Description as Position,*
        from PayrollGajiH pgh
        left join MasterProduct mp on mp.ProductID = pgh.ProductID
        left join MasterJobDesc mj on mj.IDJobDesc = mp.IDJobDesc
        where pgh.Status = 'P'
        order by mp.NIK
        "; 
    } else {
      
        $sql = "select mp.Nama as Name,mp.NIK as NIK,mj.Description as Position,*
        from PayrollGajiH pgh
        left join MasterProduct mp on mp.ProductID = pgh.ProductID
        left join MasterJobDesc mj on mj.IDJobDesc = mp.IDJobDesc
        where pgh.PayrollGajiIDH IN (".$pr.") and pgh.Status = 'P'
        order by mp.NIK
        ";
    }

    
    
    $modelpayrollgaji = \app\payroll\models\PayrollGajiH::findBySql($sql)->all();

    for($i=0;$i<count($modelpayrollgaji);$i++)
    
    {
    
    $pgidh = $modelpayrollgaji[$i]['PayrollGajiIDH'];
        
    $sql1 = "select BiayaName = Coalesce(mb.Description , mp.Description,'-'),mb.TipeBiaya as Type,*
    from PayrollGajiD  pgd
    left join MasterBiaya mb on mb.BiayaID = pgd.ItemID
    left join MasterPotongan mp on mp.IDPotongan = pgd.ItemID
    left join PayrollGajiH pgh on pgh.PayrollGajiIDH = pgd.PayrollGajiIDH
    where mb.TipeBiaya IN ('1FX','GP') and pgd.ItemID = 'GP000001' and pgd.PayrollGajiIDH = '".$pgidh."'
    union all
    select BiayaName = Coalesce(mb.Description , mp.Description,'-'),mb.TipeBiaya as Type,*
    from PayrollGajiD  pgd
    left join MasterBiaya mb on mb.BiayaID = pgd.ItemID
    left join MasterPotongan mp on mp.IDPotongan = pgd.ItemID
    left join PayrollGajiH pgh on pgh.PayrollGajiIDH = pgd.PayrollGajiIDH
    where mb.TipeBiaya IN ('1FX','GP') and pgd.ItemID <> 'GP000001' and pgd.PayrollGajiIDH = '".$pgidh."'
    ";
    
    $modelpayrollgaji1 = \app\payroll\models\PayrollGajiD::findBySql($sql1)->all();
    
    $sql2 = "	select BiayaName = Coalesce(mb.Description , mp.Description,'-'),*
    from PayrollGajiD  pgd
    left join MasterBiaya mb on mb.BiayaID = pgd.ItemID
    left join MasterPotongan mp on mp.IDPotongan = pgd.ItemID
    left join PayrollGajiH pgh on pgh.PayrollGajiIDH = pgd.PayrollGajiIDH
    where mb.TipeBiaya IN ('2TMB') and pgd.ItemID IN ('0027','0016','0010') and pgd.PayrollGajiIDH = '".$pgidh."'";
    
    $modelpayrollgaji2 = \app\payroll\models\PayrollGajiD::findBySql($sql2)->all();
    
    $sql3 = "select SumName = SUM(Amount)
	from PayrollGajiD pgd
	left join MasterBiaya mb on mb.BiayaID = pgd.ItemID
	where mb.TipeBiaya IN ('1FX','GP') and pgd.PayrollGajiIDH = '".$pgidh."'";
    
    $modelpayrollgaji3 = app\payroll\models\PayrollGajiD::findBySql($sql3)->one();
    
    $sql4 = "	select SumName = SUM(Amount)
	from PayrollGajiD pgd
	left join MasterBiaya mb on mb.BiayaID = pgd.ItemID
	where mb.TipeBiaya IN ('2TMB') and pgd.ItemID IN ('0027','0016','0010') and pgd.PayrollGajiIDH = '".$pgidh."'";
    
    $modelpayrollgaji4 = app\payroll\models\PayrollGajiD::findBySql($sql4)->one();
    
    
    
    ?>
    <table style="font-family: 'Courier'; font-size: 10pt; width:100%; margin-top:100%;">
        <tr>
            <td style="width:150px;"><?= $modelpayrollgaji[$i]['NIK']; ?></td>
            <td style="width:150px;"><?= $modelpayrollgaji[$i]['Name']; ?></td>
            <td style="width:150px;"></td>
        </tr>
        <tr>
            <td style="width:150px; padding-bottom:5px;">Dept: <br>Operational</td>
            <td style="width:150px; padding-bottom:5px;">Position : <br><?= $modelpayrollgaji[$i]['Position']; ?></td>
            <td style="width:150px; padding-bottom:5px; text-align: right;">Periode: <br><?php  echo $modelpayrollgaji[$i]['bln']." ".$modelpayrollgaji[$i]['thn']; ?></td>
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
                                <?php foreach($modelpayrollgaji1 as $index => $value) { 
                                    if($value['Type'] == 'GP') { $value['BiayaName'] = 'Gaji Pokok';  } else { $value['BiayaName'] = $value['BiayaName']; }
                                    ?>
                                <tr>
                                    <td style="text-align:left;"><?php echo $value['BiayaName']; ?></td>
                                    <td style="text-align:right; padding-right:-10px;"><?php echo number_format($value['Amount']) ; ?></td>
                                </tr> 
                                <?php } ?>
                            </table>
                        </td>
                        <td></td>
			<td style="width:49%;" valign='top'>
                            <table style="width:100%;">
                                <?php foreach($modelpayrollgaji2 as $index1 => $value1) { ?>
                                <tr>
                                        <td style="text-align:left; padding-left:45px;"><?= $value1['BiayaName']; ?></td>
                                        <td style="text-align:right; padding-right:-15px;"><?= number_format($value1['Amount']); ?></td>
                                </tr>
                                <?php } ?>
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
                        <td style="text-align: right; padding-left:-15px;"><?= number_format($modelpayrollgaji3['SumName']) ?></td>
                        <td style="text-align: left; padding-left:20px;"><strong>Total Potongan</strong></td>
                        <td style="text-align: right;"><?= number_format($modelpayrollgaji4['SumName']) ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan=3 style="padding-top:5px; padding-bottom:5px;">
                <table style="width:100%;">
                    <tr>
                        <td style="text-align: left;"><strong>Take Home Payment</strong></td>
                        <td style="text-align: right; padding-right:-5px;"><?php echo number_format((($modelpayrollgaji3['SumName']) - ($modelpayrollgaji4['SumName']))) ?></td>
                        <td style="width:25%"></td>
                        <td style="width:25%"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php } ?>