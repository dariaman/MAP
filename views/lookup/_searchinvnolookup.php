<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="so-search">

    <?php $form = ActiveForm::begin([
        'method' => 'POST',
         'options' => ['data-pjax' => true ],
    ]); 
     
    echo Html::dropDownList('typeSearch','',['OfferingIDH'=>'Offering ID', 
                                            'oh.IDJobDesc'=>'JobDesID',
                                            'mj.Description'=>'Job Description',
                                            'oh.NoSurat'=>'No Surat'],
                            ['prompt'=>'ALL','class' => 'form-control','id' => 'searchdrop']);
        echo Html::textInput('textsearch','',['id' => 'searchbox', 'class' => 'form-control']);

            echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']);

     ActiveForm::end(); ?>

</div>
