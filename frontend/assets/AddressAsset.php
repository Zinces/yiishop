<?php
namespace frontend\assets;
use yii\web\AssetBundle;

class AddressAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/home.css',
        'style/address.css',
        'style/bottomnav.css',
        'style/footer.css',
        'style/list.css',
        'style/common.css',
        'style/goods.css',
        'style/jqzoom.css',
        'style/cart.css',
        'style/fillin.css',
        'style/footer.css',
        'style/success.css',
        'style/order.css',


    ];
    public $js = [
        'js/header.js',
        'js/home.js',
        'js/list.js',
        'js/goods.js',
        'js/jqzoom-core.js',
        'js/cart1.js',
        'js/cart2.js',



    ];
    public $depends = [
       /* 'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',*/
        'yii\web\JqueryAsset',
        /* <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="js/header.js"></script>
    <script type="text/javascript" src="js/home.js"></script>*/
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}