<?php
use yii\helpers\Html;
use app\operational\models\TransactionMaster;

$countRFA = Yii::$app->db->createCommand("SELECT COUNT(1) FROM dbo.TransactionMaster")->queryScalar();
$countRFASO = Yii::$app->db->createCommand("SELECT COUNT(1) FROM dbo.TransactionMaster WHERE Transtype='SO000001'")->queryScalar();
$countRFAChangeSO = Yii::$app->db->createCommand("SELECT COUNT(1) FROM dbo.TransactionMaster WHERE Transtype='SO000002'")->queryScalar();
$countRFAOff = Yii::$app->db->createCommand("SELECT COUNT(1) FROM dbo.TransactionMaster WHERE Transtype='OF000001'")->queryScalar();
$countRFAGolive = Yii::$app->db->createCommand("SELECT COUNT(1) FROM dbo.TransactionMaster WHERE Transtype='AP000001'")->queryScalar();

$groupid1 = Yii::$app->user->identity->GroupID;

?>

<header class="main-header">

    <?= Html::a(Yii::$app->name, Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php if($groupid1 == '916' OR $groupid1 == '911')
                {
                ?>
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-bell-o"></i>
                      <span class="label label-danger"><?= $countRFA; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"> Anda Memiliki <?= $countRFA; ?> Permintaan Approval</li>
                      <li>
                        <!-- inner menu: contains the actual data -->
                        <ul class="menu">
                            <li>
                                <a href="#">
                                  <i class="fa fa-envelope text-red"></i> <?= $countRFAOff; ?> Permintaan Approval Offering
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                  <i class="fa fa-exchange text-aqua"></i> <?= $countRFASO; ?> Permintaan Approval SO
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                  <i class="fa fa-check text-yellow"></i> <?= $countRFAChangeSO; ?> Permintaan Approval Perubahan SO
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                  <i class="fa fa-truck text-navy"></i> <?= $countRFAGolive; ?> Permintaan Approval Go Live
                                </a>
                            </li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                <?php } else { } ?> 
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-user"></i> User Account
                    </a>
                    <ul class="dropdown-menu" style="width:150px; important">
                      <li>
                        <a href="#">
                          <?= Html::a('<i class="fa fa-lock text-aqua"></i> Change Password', 
                            ['/user/account'],['title' => 'Change Password']) ?>
                        </a>
                      </li>
                      <li>
                        <?= Html::a('<i class="fa fa-power-off text-danger"></i> Log Out', './index.php?r=user/logout',['title' => 'Log Out']) ?>
                      </li>
                    </ul>
                </li>
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-file-text"></i> Report</a>
                </li>
            </ul>
          </div>
    </nav>
</header>