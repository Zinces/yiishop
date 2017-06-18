<?php
namespace backend\widgets;
use backend\models\Menu;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Widget;
use yii\helpers\Html;

class MenuWidget extends Widget{
    public function init()
    {
        parent::init();
    }

    public function run()
    {

    NavBar::begin([
       /* 'brandLabel' => '吾',*/
        'brandUrl' => \Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems[] = ['label' => '首页', 'url' => ['/goods/index']];
    if (\Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '登录', 'url' => ['/admin/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/admin/logout'], 'post')
            . Html::submitButton(
                '退出 (' . \Yii::$app->user->identity->user . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
        /*$menuItems[] = ['label' => '修改密码', 'url' => ['/admin/mpassword']];
        $menuItems[] = ['label' => '权限', 'url' => ['/rbac/indexpermission']];
        $menuItems[] = ['label' => '角色', 'items'=>[['label'=>'11','url'=>['goods/index'],['label'=>'11','url'=>['goods/index']]]];*/
        $menus=Menu::findAll(['parent_id'=>0]);
        foreach ($menus as $menu){
            $Items=['label'=>$menu->label,'items'=>[]];
                foreach ($menu->parents as $children){
                    if(\Yii::$app->user->can($children->url)){
                        $Items['items'][]=['label'=>$children->label,'url'=>[$children->url]];
                    }
                }
            if(!empty($Items['items'])){
                $menuItems[]=$Items;
            }

        }
    }
    //var_dump($menuItems);exit;
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();

        parent::run();
    }
}