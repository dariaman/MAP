<?php

$modelmenu = [];

$groupid = Yii::$app->user->identity->GroupID;

if ($groupid == '911'){
    $modelmenu = \app\models\MsMenu::find()->select('MenuID,MenuName,LinkAddress,ParentID')
                ->where(['IsAktif' => 1,'Tipe' => 'APP'])
                ->orderBy(['MenuID'=>SORT_ASC])->all();
} else { 
    $modelmenu = \app\models\MsMenu::find()
                ->select('mn.MenuID,mn.MenuName,mn.LinkAddress,mn.ParentID')
                ->from(['mn' => app\models\MsMenu::tableName()])
                ->leftJoin(['ua' => app\models\UserAccess::tableName()],'ua.MenuID = mn.MenuID')
                ->where(['ua.GroupID' => $groupid,'Tipe' => 'APP','mn.IsAktif' => 1])
                ->orderBy(['mn.MenuID'=>SORT_ASC])->all();
}
?>
<aside class="main-sidebar" style="padding-top: 0px;">
    <section class="sidebar" style="overflow-x: auto;">

<?php

    $stringMenu = '';
    foreach ($modelmenu as $menuuser)
    {
        $parents = $menuuser->ParentID;
        if (!isset($parentsold)){ // set nilai parent pertama kali
            $parentsold =$parents;
        }
        if ($parentsold != $parents){
            $stringMenu = $stringMenu . '</li></ul>';
            $parentsold =$parents;
        }
        
        if ($parents == $menuuser->MenuID){
            
            if($parents == '4000000000')
            {
                $icon = 'fa fa-database';
            } else if ($parents == '7000000000')
            {
                $icon = 'fa fa-users';
            } else if ($parents == '8000000000')
            {
                $icon = 'fa fa-money';
            } else if ($parents == '9000000000')
            {
                $icon = 'fa fa-clipboard';
            } else if ($parents == '9990000000')
            {
                $icon = 'fa fa-cog';
            } else {
                $icon = 'fa fa-folder';
            }
            
                 $stringMenu = $stringMenu . '<ul class="sidebar-menu">'.
                    '<li class="treeview">'
                    . '<a href="#">'
                        . '<i class="'.$icon.'"></i> '
                        . '<span>'.$menuuser->MenuName.'</span>'
                        . '<i class="fa fa-angle-left pull-right"></i>'
                    . '</a>';      
        }else{
            
            if($menuuser->MenuID == '4000000100')
            {
                $iconA = 'fa fa-user-plus';
            } else if ($menuuser->MenuID == '4000000200') 
            {
                $iconA = 'fa fa-user';
            } else if ($menuuser->MenuID == '4000000300')
            {
                $iconA = 'fa fa-industry'; 
            } else if ($menuuser->MenuID == '4000000400')
            {
                $iconA = 'fa fa-map'; 
            } else if ($menuuser->MenuID == '4000000410') 
            {
                $iconA = 'fa fa-dollar';
            } else if ($menuuser->MenuID == '4000000500') 
            {
                $iconA = 'fa fa-briefcase';
            } else if ($menuuser->MenuID == '4000000600') 
            {
                $iconA = 'fa fa-file';
            } else if ($menuuser->MenuID == '4000001200') 
            {
                $iconA = 'fa fa-plus';
            } else if ($menuuser->MenuID == '4000001210') 
            {
                $iconA = 'fa fa-minus';
            } else if ($menuuser->MenuID == '4000001500') 
            {
                $iconA = 'fa fa-calendar';
            } else if ($menuuser->MenuID == '4000002100') 
            {
                $iconA = 'fa fa-institution';
            } else if ($menuuser->MenuID == '7000000200') 
            {
                $iconA = 'fa fa-envelope';
            } else if ($menuuser->MenuID == '7000000300') 
            {
                $iconA = 'fa fa-exchange';
            } else if ($menuuser->MenuID == '7000000500') 
            {
                $iconA = 'fa fa-mail-reply';
            }else if ($menuuser->MenuID == '7000000550') 
            {
                $iconA = 'fa fa-user-plus'; 
            } else if ($menuuser->MenuID == '7000001000') 
            {
                $iconA = 'fa fa-check';
            } else if ($menuuser->MenuID == '8000000100') 
            {
                $iconA = 'fa fa-calendar-check-o';
            } else if ($menuuser->MenuID == '8000000150') 
            {
                $iconA = 'fa fa-calendar-o';
            } else if ($menuuser->MenuID == '8000000200') 
            {
                $iconA = 'fa fa-file-text';
            } else if ($menuuser->MenuID == '8000000400') 
            {
                $iconA = 'fa fa-table';
            } else if ($menuuser->MenuID == '8000000500') 
            {
                $iconA = 'fa fa-plus-circle';
            } else if ($menuuser->MenuID == '8000000600') 
            {
                $iconA = 'fa fa-minus-circle';
            } else if ($menuuser->MenuID == '8000000700') 
            {
                $iconA = 'fa fa-list-alt';
            } else if ($menuuser->MenuID == '9000000400') 
            {
                $iconA = 'fa fa-book';
            } else if ($menuuser->MenuID == '9000000600') 
            {
                $iconA = 'fa fa-bookmark';
            } else if ($menuuser->MenuID == '9000000700') 
            {
                $iconA = 'fa fa-file-text';
            } else {
                $iconA = 'fa fa-angle-right';
            }
            
                $stringMenu = $stringMenu .
                    '<ul class="treeview-menu">'.
                        '<li>'
                        . '<a class="solTitle" href=index.php?r='.$menuuser->LinkAddress.'>'
                            . '<i class="'.$iconA.'"></i>'
                            . '<span>'.$menuuser->MenuName.'</span>'
                        . '</a>'
                        . '</li>'.
                    '</ul>'; 
        }
    }
    echo $stringMenu;
echo "</section></aside>";
