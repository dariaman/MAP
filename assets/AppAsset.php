<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@bower/admin-lte/dist';
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [        
        'css/site.css',
        'css/modified.css',
    ];
    
    public $js = [
//        'js/app.min.js',
//        'js/main.js'
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}