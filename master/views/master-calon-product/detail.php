<?php

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterCalonProduct */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->CalonProductID;
$idCP = Yii::$app->request->get('id', 'xxx');

?>

<div class="master-calon-product-form">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= 'Calon Product Detail' ?></h3>
                </div>
                <div class="box-body">
                   <table class="table table-striped">
                    <tr>
                        <td>
                            Calon Product ID
                        </td>
                        <td style="width:1px;">:</td>
                        <td>
                            <?php
                            echo $model->CalonProductID;
                            ?>         
                        </td>
                    </tr> 
                    <tr>
                        <td style="width: 200px"> Nama Calon Product</td>
                        <td style="width:1px;">:</td>
                        <td> 
                            <?php
                            echo $model->Nama;
                            ?>                   
                        </td>
                    </tr>
                    <tr>
                        <td> Job Description</td>
                        <td style="width:1px;">:</td>
                        <td>
                            <?php
                            echo $model->IDJobDesc;
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td>Gender </td>
                        <td style="width:1px;">:</td>
                        <td>    
                            <?php
                            if ($model->Gender = 'm') {
                                echo 'Male';
                            } else {
                                echo 'Felame';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td> KTP </td>
                        <td style="width:1px;">:</td>
                        <td>
                            <?php
                            echo $model->KTP;
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td>KTP Expired date</td>
                        <td style="width:1px;">:</td>
                        <td>
                            <?php
                            echo $model->KTPExpireddate;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td> SIM </td>
                        <td style="width:1px;">:</td>
                        <td>
                            <?php
                            echo $model->SIM;
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> SIM Expire Date </td>
                        <td style="width:1px;">:</td>
                        <td>
                            <?php
                            echo $model->SIMExpireDate;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Status Nikah </td>
                        <td style="width:1px;">:</td>
                        <td>
                            <?php
                            echo $model->IDstatusnikah;
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> Address </td>
                        <td style="width:1px;">:</td>
                        <td>
                            <?php
                            echo $model->Address;
                            ?>                 
                        </td>
                    </tr>
                    <tr>
                        <td> Refferensi Desc </td>
                        <td style="width:1px;">:</td>
                        <td>
                            <?php
                            echo $model->RefferensiDesc;
                            ?>                   
                        </td>
                    </tr>
                    <tr>
                        <td> City </td>
                        <td style="width:1px;">:</td>
                        <td>
                            <?php
                            echo $model->City;
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> Zip </td>
                        <td style="width:1px;">:</td>
                        <td>
                            <?php
                            echo $model->Zip;
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> Phone</td>
                        <td style="width:1px;">:</td>
                        <td>
                            <?php
                            echo $model->Phone;
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td>Mobile 1</td>
                        <td style="width:1px;">:</td>
                        <td>
                            <?php
                            echo $model->Mobile1;
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> Mobile 2</td>
                        <td style="width:1px;">:</td>
                        <td>
                            <?php
                            echo $model->Mobile2;
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> Bank Nama</td>
                        <td style="width:1px;">:</td>
                        <td>
                            <?php
                            echo $model->BankID;
                            ?>                 
                        </td>
                    </tr>
                    <tr>
                        <td>Bank Acc Number </td>
                        <td style="width:1px;">:</td>
                        <td>
                            <?php
                            echo $model->BankAccNumber;
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> NPWP </td>
                        <td style="width:1px;">:</td>
                        <td> 
                            <?php
                            echo $model->NPWP;
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> IsActive </td>
                        <td style="width:1px;">:</td>
                        <td> 
                            <?php
                            if($model->IsActive=1){
                                echo 'Active';
                            } else {
                                 echo 'Deactive';
                            }

                            ?> 
                        </td>
                    </tr>
                </table> 
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                          <h3 class="box-title">Test Result</h3>
                </div>
                <div class="box-body">
                    <?php
                    $query = app\operational\models\NilaiTes::find()
                            ->select('*')
                            ->from('NilaiTes nt')
                            ->Join('JOIN', 'JenisTes jt', 'nt.IDJenisTes = jt.IDJenisTes')
                            ->where(['CalonProductID' => $idCP]);


                    $dataProvider = new ActiveDataProvider([
                        'query' => $query,
                        'sort' => false
                    ]);

                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'pjax' => FALSE,
                        'columns' => [
                            ['label' => 'Jenis Tes',
                                'value' => 'Description'],
                            ['label' => ' Nilai Tes',
                                'value' => 'Nilai'],
                            ['label' => ' Tanggal Tes',
                                'value' => 'TglTes'],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <table >
            <tr>
                <td style="width: 120px">
                    <?php
                    echo Html::a('Back', ['master-calon-product/'], ['class' => 'btn btn-success', 'style' => 'width:110px;']);
                    ?>
                </td>
                <td style="width: 50px">
                            <?php
                            if (!$model->isNewRecord) {
                                echo Html::a('Tambah Nilai', ['nilai-tes/create/', 'CalonProductID' => $idCP], ['class' => 'btn btn-warning', 'style' => 'width:110px;']);
                            } else {

                            }
                            ?>
                </td>
            </tr>
            </table>
        </div>
    </div>
</div>
