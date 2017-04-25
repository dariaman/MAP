<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$SODID = Yii::$app->request->get('SODID', 'xxx');
$SeqProduct = Yii::$app->request->get('SeqProduct', 'xxx');
$this->title = 'Jadwal Golive ManPower';
$sql = 'select jg.Monday1
      ,jg.Monday2
      ,jg.Tuesday1
      ,jg.Tuesday2
      ,jg.Wednesday1
      ,jg.Wednesday2
      ,jg.Thursday1
      ,jg.Thursday2
      ,jg.Friday1
      ,jg.Friday2
      ,jg.Saturday1
      ,jg.Saturday2
      ,jg.Sunday1
      ,jg.Sunday2
    from JadwalGolive jg
    left join GoLiveProduct gl on gl.SODID=jg.SODID and gl.SeqProduct=jg.SeqProduct
    where jg.SODID=\'' . $SODID . '\'and jg.SeqProduct=\'' . $SeqProduct . '\'';
$jadwalgolive = Yii::$app->db->createCommand($sql)->queryAll();
?>


<div class="sod-form">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td>SODID :</td>
                            <td>: <label> <?= $SODID ?></label></td>
                        </tr>
                        <tr>
                            <td>SeqProduct </td>
                            <td>: <label> <?= $SeqProduct ?></label></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= Html::encode('List Hari') ?></h1>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr><td style="width:10%;"></td><td style="text-align: center;width: 10%">In</td><td style="text-align: center;width: 10%">Out</td><td style="width: 70%"></td></tr>
                        <tr><td>- Monday</td><td style="text-align: center"><?= $jadwalgolive[0]['Monday1'] ?></td><td style="text-align: center"><?= $jadwalgolive[0]['Monday2'] ?></td><td style="width: 70%"></td></tr>
                        <tr><td>- Tuesday</td><td style="text-align: center"><?= $jadwalgolive[0]['Tuesday1'] ?></td><td style="text-align: center"><?= $jadwalgolive[0]['Tuesday2'] ?></td><td style="width: 70%"></td></tr>
                        <tr><td>- Thursday</td><td style="text-align: center"><?= $jadwalgolive[0]['Thursday1'] ?></td><td style="text-align: center"><?= $jadwalgolive[0]['Thursday2'] ?></td><td style="width: 70%"></td></tr>
                        <tr><td>- Friday</td><td style="text-align: center"><?= $jadwalgolive[0]['Friday1'] ?></td><td style="text-align: center"><?= $jadwalgolive[0]['Friday2'] ?></td><td style="width: 70%"></td></tr>
                        <tr><td>- Saturday</td><td style="text-align: center"><?= $jadwalgolive[0]['Saturday1'] ?></td><td style="text-align: center"><?= $jadwalgolive[0]['Saturday2'] ?></td><td style="width: 70%"></td></tr>
                        <tr><td>- Sunday</td><td style="text-align: center"><?= $jadwalgolive[0]['Sunday1'] ?></td><td style="text-align: center"><?= $jadwalgolive[0]['Sunday2'] ?></td><td style="width: 70%"></td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box-body">
                <?= Html::a('Back', ['/operational/s-o-h'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    
     
    
<!--    
    <div class="sod_index">
        <br>
        <?php
        $sql = new \yii\db\Query;
        $sql->select('
       jg.Monday1
      ,jg.Monday2
      ,jg.Tuesday1
      ,jg.Tuesday2
      ,jg.Wednesday1
      ,jg.Wednesday2
      ,jg.Thursday1
      ,jg.Thursday2
      ,jg.Friday1
      ,jg.Friday2
      ,jg.Saturday1
      ,jg.Saturday2
      ,jg.Sunday1
      ,jg.Sunday2')
                ->from(['jg' => app\operational\models\JadwalGolive::tableName()])
                ->leftJoin(['gl' => app\operational\models\GoLiveProduct::tableName()], 'gl.SODID=jg.SODID and gl.SeqProduct=jg.SeqProduct ')
                ->where('jg.SODID=\'' . $SODID . '\'and jg.SeqProduct=\'' . $SeqProduct . '\'')
                ->orderBy('jg.SODID');

        $dataProvider = new \yii\data\ActiveDataProvider(['query' => $sql]);
        $dataProvider->pagination->pageSize = 50;

//        echo 
        GridView::widget([
            'dataProvider' => $dataProvider,
            'pjax' => false,
            'layout' => "{items}",
            'resizableColumns' => true,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'Monday1',
                'Monday2',
                'Tuesday1',
                'Tuesday2',
                'Wednesday1',
                'Wednesday2',
                'Thursday1',
                'Thursday2',
                'Friday1',
                'Friday2',
                'Saturday1',
                'Saturday2',
                'Sunday1',
                'Sunday2',
            ],
        ]);
        ?>
    </div>-->

</div>


