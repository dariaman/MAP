<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
//use app\models\LoginForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
//$model = new app\models\UserMAP();
?>
<div class="login-box">
        <div class="login-logo">
            <a href="../web/index.php"><?= ucfirst(Yii::$app->controller->action->id) ?></a>
        </div>
    <!-- <p>ID action : <?php Yii::$app->controller->action->id ?></p> -->
    <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <div class="form-group display-block has-feedback">
        <?= $form->field($model, 'username')->textInput(['placeholder'=>'Username','class'=>'form-control display-block','style'=>'width:100%;']) ?>
        <span class="glyphicon glyphicon-user form-control-feedback display-block"></span>
    </div>
    <div class="form-group display-block has-feedback">
       <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password','class'=>'form-control display-block','style'=>'width:100%;']) ?>
        <span class="glyphicon glyphicon-lock form-control-feedback display-block"></span>
    </div>        
    <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </label>
          </div>
        </div><!-- /.col -->
        <div class="col-xs-4">
          <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div><!-- /.col -->
    </div>        
        <?php ActiveForm::end(); ?>
    </div>
</div>  
