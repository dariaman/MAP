<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterjadwalkerjaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="masterjadwalkerja-search">

    <?php $form = ActiveForm::begin([
        //'action' => ['dtl'],
        'action' => "./index.php?r=eprocess/jadwal-absensi-status-d/dtl&id=".$_GET['id']."&areaID=".$_GET['areaID']."&cusID=".$_GET['cusID']."&tahun=".$_GET['tahun']."&bulan=".$_GET['bulan'],
        'method' => 'post',
        'options' => ['data-pjax'=>true],
    ]); ?>
    
     <?php 
    
        if(isset($_POST['typeSearch']))
        {
            $type = $_POST['typeSearch'];
        } else {
            $type = NULL;
        }

        if(isset($_POST['textsearch']))
        {
            $text = $_POST['textsearch'];
        } else {
            $text = NULL;
        }
            
        echo Html::dropDownList('typeSearch',$type,['AD.ProductID'=>'Product ID', 'mp.Nama'=>'Product Name'],['prompt'=>'ALL','class' => 'form-control display-block','id' => 'searchdrop']);
        echo Html::textInput('textsearch',$text,['class' => 'form-control display-block','id'=> 'searchbox']);
    ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
