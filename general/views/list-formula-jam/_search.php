<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\general\models\ListFormulaJamSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="list-formula-jam-search">
<?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
        'options'=>['data-pjax' => true ],
    ]); 
    
    $type = Yii::$app->request->post('typeSearch','');
    $text = Yii::$app->request->post('textsearch','');

    echo Html::dropDownList('typeSearch',$type,
                        ['JenisFormulaJam'=>'JenisFormulaJam', 'Description'=>'Description'],
                        ['prompt'=>'ALL','class'=>'form-control','id' => 'searchdrop']) ;
    
        echo Html::textInput('textsearch',$text,['id' => 'searchbox', 'class' => 'form-control']);
        echo Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn']);
    ActiveForm::end(); ?>
</div>
