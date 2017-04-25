<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Detail Product';
/* @var $this yii\web\View */
/* @var $model app\master\models\Masterproduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="masterproduct-form">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $this->title; ?></h3>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td style="width: 200px">
                                ID Product
                            </td>
                            <td>
                                <?php
                                echo $model->ProductID;
                                ?> 
                            </td>
                        </tr> 
                        <tr>
                            <td style="width: 200px;"> 
                                Nama 
                            </td>
                            <td>
                                <?php
                                echo $model->Nama;
                                ?>
                        </tr>
                        <tr>
                            <td> Job Desc  </td>
                            <td>
                                <?php
                                $mj = \app\master\models\MasterJobDesc::find()->select('Description')->where(['IDJobDesc' => $model->IDJobDesc])->one();
                                echo $mj->Description;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Area  </td>
                            <td>
                                <?php
                                $ma = \app\master\models\MasterArea::find()->select('Description')->where(['AreaID' => $model->AreaID])->one();
                                echo $ma->Description;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Gender </td>
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
                            <td>
                                <?php
                                echo $model->KTP;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> KTP Expired date </td>
                            <td>
                                <?php
                                echo $model->KTPExpiredDate;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td id="cim"> SIM  </td>
                            <td>
                                <?php
                                echo $model->SIM;
                                ?>
                            </td>
                        </tr>
                        <tr id="cimd">
                            <td> SIM Expired date </td>
                            <td>
                                <?php
                                echo $model->SIMExpiredDate;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Status Nikah</td>
                            <td>
                                <?php
                                echo $model->IDStatusNikah;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Address </td>
                            <td>
                                <?php
                                echo $model->Address;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> City </td>
                            <td>
                                <?php
                                echo $model->City;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Zip</td>
                            <td>
                                <?php
                                echo $model->Zip;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Phone </td>
                            <td>
                                <?php
                                echo $model->Phone;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Mobile1 </td>
                            <td>
                                <?php
                                echo $model->Mobile1;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Mobile2</td>
                            <td>
                                <?php
                                echo $model->Mobile2;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Bank Name</td>
                            <td>
                                <?php
                                echo $model->BankID;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> BankAccNumber </td>
                            <td>
                                <?php
                                echo $model->BankAccNumber;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> NPWP </td>
                            <td>
                                <?php
                                echo $model->NPWP;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Class </td>
                            <td>
                                <?php
                                echo $model->Class;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td> IsActive </td>
                            <td> 
                                <?php
                                if ($model->IsActive = 1) {
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
        <div class="col-xs-12">
            <div class="form-group">
                <?= Html::a('Back', ['master-product/index'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>
