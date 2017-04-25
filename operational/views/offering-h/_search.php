<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\operational\models\OfferingHSearch */
/* @var $form yii\widgets\ActiveForm */

//Pjax::begin(['id' => 'offeringcoscalsearch']);

?>

<div class="box-body">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
        'options' => ['data-pjax' => true],
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
    
        echo Html::dropDownList('typeSearch',$type,
                                        ['OfferingIDH'=>'Offering ID', 
                                        'CustomerID'=>'Customer Name',
                                        'NoSurat'=>'Nomor Surat',
                                        'IDJobDesc'=>'Job Description',
                                        'Status'=>'Status'],['prompt'=>'ALL','class' => 'form-control','id' => 'searchdrop']);
        echo Html::textInput('textsearch',$text,['class' => 'form-control','id'=> 'searchbox']);
    ?>
    <div class="form-group">
        <?php 
            echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']);
//            echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); 
       // Pjax::end()
                ;?>

</div>

<?php

$script = <<<SKRIPT

//$(document).on('submit', 'form[data-pjax]', function(event) {
//  $.pjax.submit(event, '#offeringcoscalsearch')
//})

SKRIPT;

$this->registerJs($script);

?>
