<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use bootui\datetimepicker\Timepicker;
/* @var $this yii\web\View */
/* @var $searchModel app\operational\models\OfferingHdrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Edit';
//$this->params['breadcrumbs'][] = $this->title;

$script = <<<SKRIPT
        window.onunload = refreshParent;
        function refreshParent() {
            window.close();
            window.opener.location.reload();
        }
SKRIPT;

$this->registerJs($script);

?>
<div class="offering-hdr-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php        
        $desc = \app\master\models\MasterProduct::find()
                ->where(['ProductID' => $model->ProductID])
                ->one();
        
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label'=>'Nama',
                'value'=> $model->Nama 
            ],
            [
                'label'=>'NIK',
                'value'=> $model->NIK
            ],
        ],
    ])?>
    <div class="offering-hdr-form">
        
        
        <?php $form = ActiveForm::begin(['action'=>'./index.php?r=eprocess/jadwal-absensi-status-d/updprd','method' => 'post']); 
       
        ?>
        <input type="hidden" name="tahun" value="<?= $_GET['tahun'];?>"> 
        <input type="hidden" name="bulan" value="<?= $_GET['bulan'];?>">
        <input type="hidden" name="tgl" value="<?= $_GET['tgl'];?>">
        <input type="hidden" name="pid" value="<?= $_GET['pid'];?>"> 
        <input type="hidden" name="cusid" value="<?= $_GET['cusid'];?>"> 
        <table class="table table-striped table-bordered">
            <tr>
                <td>Tanggal</td>
                <td><?php $tgl = strtotime($_GET['tgl']); $newdate = date('j',$tgl); echo $newdate;?></td>
            </tr>
           <tr>
                <td>Status</td>
                <td><?php echo Html::dropDownList('status', NULL, ['NM'=> 'Normal','LB'=>'Libur'], ['prompt' => 'Select Status','class'=>'form-control display-block', 'id'=>'searchdrop1']) ?></td>
            </tr>
            <tr>
                <td>Jadwal Masuk</td>
                <td><?= Timepicker::widget([
                              'name' => 'masuk',
                              'options' => ['class' => 'form-control display-block','style'=>'width:25%;'],
                              'addon' => ['prepend' => 'Jadwal Masuk'],
                              'format' => 'HH:mm',
                        ]); ?>
                </td>
            </tr>
            <tr>
                <td>Jadwal Keluar</td>
                <td><?= Timepicker::widget([
                              'name' => 'keluar',
                              'options' => ['class' => 'form-control display-block','style'=>'width:25%;'],
                              'addon' => ['prepend' => 'Jadwal Keluar'],
                              'format' => 'HH:mm',
                        ]); ?>
                </td>
            </tr>
        </table>
        <?php //print_r($model); die(); ?>
        <div class="form-group" style="margin-left:45%;">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
             
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
