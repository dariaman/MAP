<?php

use yii\helpers\Html;

app\assets\AppAsset::register($this);
dmstr\web\AdminLteAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@bower/adminlte/dist');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
<?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="skin-blue">
        <?php $this->beginBody() ?>
        <div class="wrapper" style="min-height:100%;">
        <?php if(!Yii::$app->user->isGuest){
            echo $this->render('header.php', ['directoryAsset' => $directoryAsset]);            
        } ?>

            <div class="wrapper row-offcanvas row-offcanvas-left">
                <!--<ins>-->
        <?php if(!Yii::$app->user->isGuest){
            echo $this->render('left.php', ['directoryAsset' => $directoryAsset]);            
        } ?>
        <?= $this->render('content.php', ['content' => $content, 'directoryAsset' => $directoryAsset]) ?>

                <footer class="main-footer">
                    <div class="container"><strong>Copyright &copy; 2015 Surya Sudeco</strong></div>
                </footer>
        <?php if(!Yii::$app->user->isGuest){
            echo $this->render('right.php', ['directoryAsset' => $directoryAsset]);            
        } ?>
            </div>

        </div>

<?php $this->endBody() ?>
    </body>
</html>
        <?php $this->endPage(); 
        