<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\modal;
//use bootui\datetimepicker;
use yii\helpers\ArrayHelper;
use app\master\models\JenisTes;
use app\master\models\Mastercalonproduct;
//use app\operational\models\NilaiTesSearch;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model app\operational\models\NilaiTes */
/* @var $form yii\widgets\ActiveForm */
?>

<?php Modal::begin([
             'header'=>'<h4>Vlookup</h4>',
             'id'=> 'modal',
             'size'=>'modal-lg',
         ]);
         echo"<div id='modalcalon'></div>";
         modal::end();
         
         ?>

<div class="nilai-tes-form">
 
 

    <?php $form = ActiveForm::begin(); ?>
   
   <table class="table table-striped table-bordered"> 
    
    <?php $jenistes=JenisTes::find()->select('IDJenisTes,Description')->all()  ?>
    </tr>
    <?='<input type=hidden name=calonproduct id=cp value= >'; ?>
     <tr> 
         <td> Calon Product ID </td>
         <td>
    <?= $form->field($model, 'CalonProductID')->textInput(['name'=>'calon','id'=>'cpa','disabled'=>true,'style'=> 'width:400px;'])->label('Calon Product')->hint("please CalonProduct ID") ?>
    </td>
     </tr>
    
    <?php 
          $cp= new Mastercalonproduct();
          
            ?>
     <tr>
         <td> Nama Calon Product </td>
         <td>
       <?= $form->field($cp, 'Nama')->textInput(['name'=>'calon','id'=>'cpn','disabled'=>true,'style'=> 'width:400px;'])->label('Calon Product Name') ?>
           <?= Html::button('...', ['value'=>Url::to('index.php?r=operational/nilai-tes/calonproduct'),'class' => 'btn btn-success','id'=>'modalcp']);?>
         </td>  
 
     <tr> <td> Tgl Tes</td>
         <td>
             <?= \bootui\datetimepicker\Datepicker::widget([
                'name' => 'date',
                'options' => ['class' => 'form-control','style'=> 'width:200px;'],
                'addon' => ['prepend' => 'Tgl Tes'],
                'format' => 'YYYY-MM-DD',
            ]); ?>

         </td>
     </tr>
     <tr>
         <td> ID Jenis Tes </td>
         <td>
    <?= $form->field($model, 'IDJenisTes')->dropDownList(ArrayHelper::map($jenistes,'IDJenisTes','Description'),['prompt' => 'Select jenis tes','style'=> 'width:200px;'])->label('jenis tes');?>
         </td>
     </tr>
     <tr> 
         <td>Nilai Tes</td>
         <td>
    <?= $form->field($model, 'Nilai')->textInput(['maxlength'=>50   ,'style'=> 'width:400px;'])->label('Nilai Tes') ?>
         </td>
     </tr>
    
 </table>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
    </div>
         

    <?php ActiveForm::end(); ?>
    <?php Pjax::begin(['id'=>'PtlCommentsPjax']); 
//    echo $this->render('_search', ['model' => $searchModel]); ?>
     <?php
    $con=Yii::$app->db->createCommand("exec spnilai");
    $command=$con->createCommand("exec spnilai")->setSql();
    $query =$command;
           

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);
    
    ?>
 
    
   <?=GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

         
            ['label'=>'Jenis Tes',
             'value'=>'iDJenisTes.Description'],
             ['label'=>'Nilai Tes',
             'value'=>'Nilai'],
                    
        ],
    ]);
    ?>
    
    
<?php Pjax::end(); ?>
    <?php
$script = <<<SKRIPT

$(function(){
$('#modalcp').click(function() {
	$('#modal').modal('show')
		.find('#modalcalon')
		.load($(this).attr('value'));

	})
        });

SKRIPT;

$this->registerJs($script);
?>

</div>
