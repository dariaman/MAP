<?php

use yii\helpers\Html;
use app\operational\models\GoLiveProductHistory;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$sodid = Yii::$app->request->get('sodid');
$seqid = Yii::$app->request->get('seqid');

$this->title = 'View Jadwal';


$sql = "select 
    CONVERT(VARCHAR(5),Monday1, 108)AS Monday1, CONVERT(VARCHAR(5),Monday2, 108)AS Monday2,
    CONVERT(VARCHAR(5),Tuesday1, 108)AS Tuesday1, CONVERT(VARCHAR(5),Tuesday2, 108)AS Tuesday2,
    CONVERT(VARCHAR(5),Wednesday1, 108)AS Wednesday1, CONVERT(VARCHAR(5),Wednesday2, 108)AS Wednesday2,
    CONVERT(VARCHAR(5),Thursday1, 108)AS Thursday1, CONVERT(VARCHAR(5),Thursday2, 108)AS Thursday2,
    CONVERT(VARCHAR(5),Friday1, 108)AS Friday1, CONVERT(VARCHAR(5),Friday2, 108)AS Friday2,
    CONVERT(VARCHAR(5),Saturday1, 108)AS Saturday1, CONVERT(VARCHAR(5),Saturday2, 108)AS Saturday2,
    CONVERT(VARCHAR(5),Sunday1, 108)AS Sunday1, CONVERT(VARCHAR(5),Sunday2, 108)AS Sunday2 
    from JadwalGolive
    WHERE SODID = '$sodid' AND SeqProduct = $seqid";
                        
$SODOutstanding = Yii::$app->db->createCommand($sql)->queryAll();

?>
<div class="sod-form">
   <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <p style="text-align:center">Sequence Product : <?= Html::encode($seqid) ?></p>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width:100px;", bgcolor="#6495ed", align="center">Hari</td>
                            <td style="width:150px;", bgcolor="#6495ed", align="center">Jam Masuk</td>
                            <td style="width:150px;", bgcolor="#6495ed", align="center">Jam Keluar</td>
                        </tr>
                        <tr>
                           <td style="width:100px;", align="center">Senin</td>
                            <td style="width:200px;", align="center"><?= $SODOutstanding[0]['Monday1'] ?></td>
                            <td style="width:200px;", align="center"><?= $SODOutstanding[0]['Monday2'] ?></td>
                        </tr>
                        <tr>
                           <td style="width:100px;", align="center">Selasa</td>
                            <td style="width:200px;", align="center"><?= $SODOutstanding[0]['Tuesday1'] ?></td>
                            <td style="width:200px;", align="center"><?= $SODOutstanding[0]['Tuesday2'] ?></td>
                        </tr>
                        <tr>
                           <td style="width:100px;", align="center">Rabu</td>
                            <td style="width:200px;", align="center"><?= $SODOutstanding[0]['Wednesday1'] ?></td>
                            <td style="width:200px;", align="center"><?= $SODOutstanding[0]['Wednesday2'] ?></td>
                        </tr>
                        <tr>
                           <td style="width:100px;", align="center">Kamis</td>
                            <td style="width:200px;", align="center"><?= $SODOutstanding[0]['Thursday1'] ?></td>
                            <td style="width:200px;", align="center"><?= $SODOutstanding[0]['Thursday2'] ?></td>
                        </tr>
                        <tr>
                           <td style="width:100px;", align="center">Jumat</td>
                            <td style="width:200px;", align="center"><?= $SODOutstanding[0]['Friday1'] ?></td>
                            <td style="width:200px;", align="center"><?= $SODOutstanding[0]['Friday2'] ?></td>
                        </tr>
                        <tr>
                           <td style="width:100px;", align="center">Sabtu</td>
                            <td style="width:200px;", align="center"><?= $SODOutstanding[0]['Saturday1'] ?></td>
                            <td style="width:200px;", align="center"><?= $SODOutstanding[0]['Saturday2'] ?></td>
                        </tr>
                        <tr>
                           <td style="width:100px;", align="center">Minggu</td>
                            <td style="width:200px;", align="center"><?= $SODOutstanding[0]['Sunday1'] ?></td>
                            <td style="width:200px;", align="center"><?= $SODOutstanding[0]['Sunday2'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>

<?php
$script = <<<SKRIPT
    
    $('#select').click(function(e)
    {
        e.preventDefault();
        window.close();
    });

   
SKRIPT;

$this->registerJs($script);

?> 