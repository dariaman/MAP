<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use kartik\widgets\DatePicker;
use app\operational\models\NilaiTes;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */  
            
?>
<div class="offering-hdr-index">

    <h1><?= 'Nilai Tes' ?></h1>
    
 <?php
    $model = app\master\models\MasterCalonProduct::find()->where("CalonProductID ='".$_GET['id']."'")->one();
    $product = $model['CalonProductID'];
    $name = $model['Nama'];
    $jenis = Yii::$app->db->createCommand('select IDJenisTes,Description from JenisTes')->queryAll();
            
    foreach ($jenis as $value){
                
        $singleArray[$value['IDJenisTes']] = $value['Description'];
    }
            
  
   ?>
  
            

    <?php $form = ActiveForm::begin(['action'=>'./index.php?r=master/master-calon-product/add','method' => 'post']); 
        
        
    ?>
    

    <input type="hidden" name="idc" value="<?php echo $_GET['id'];?>">
    <input type="hidden" name="nama" value="<?php echo $name;?>">
  
      
        <table class="table table-striped table-bordered">
         <tr>
             <td style="width:200px;">Calon Product ID </td>
             <td>: <label id="CostcalH"><?= $product ?> </label></td>
         </tr>
         <tr>
             <td>Calon Product Name</td>
             <td>:<?= $name ?> </td>
         </tr>
          <tr>
            <td>Jenis Tes </td>
            <td>
             <?= Html::dropDownList('absen',NULL,$singleArray,['prompt' => 'Select Type', 'class' => 'form-control' , 'id' => 'searchdrop1'])?>
            </td>
         </tr>
     <tr>     
        <td>Nilai Tes</td>
         <td><?= Html::textInput('nilai',NULL,['class'=>'form-control medbox','id'=>'itemid'])?> </td>   
             
       <tr>
            <td>Tanggal Tes</td>
            <td><?php 
                echo DatePicker::widget([
                            
                            'name' => 'Tgltes',
                            'options' => ['placeholder' => 'Enter Date...',],
                            'pluginOptions' => ['autoclose'=>true,
                            'format' => 'yyyy-mm-dd']
                    ]);
                      ?>            
            </td>
            </tr>
        
     </table>
    
        <div class="form-group" style="margin-left:45%;">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success','id'=>'c']) ?>
             <?= Html::a('Back', '', ['class' =>'btn btn-success','onclick'=>"window.history.back(); "]) ?>
        </div>
        <?php ActiveForm::end(); ?>
         
         
    </div>
<?php
 $query = NilaiTes::find()->select('*')
                          ->from('NilaiTes nt')
                          ->innerJoin('MasterCalonProduct mcp','nt.CalonProductID=mcp.CalonProductID')
                          ->innerJoin('JenisTes jt','nt.IDJenisTes=jt.IDJenisTes')
                          ->where(['mcp.CalonProductID'=>$_GET['id']]);                           

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            
        ]);
        ?>
  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
//        'pager' => [
//            'firstPageLabel' => 'First',
//            'lastPageLabel' => 'Last',
//        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            ['label'=>'Calon Product',
             'value'=>'CalonProductID'],
             ['label'=>'Calon Product Name',
             'value'=>'Nama'],
              ['label'=>'Tanggal Tes',
             'value'=>'TglTes'],
            ['label'=>'Jenis Tes',
             'value'=>'Description'],
             ['label'=>'Nilai Tes',
             'value'=>'Nilai'],
            
//            'usercrt',
//             'datecrt',

           ['class' => 'yii\grid\ActionColumn',
                'template' => "{delete}",],
        ],
    ]);?>

