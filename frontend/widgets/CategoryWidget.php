<?php
namespace frontend\widgets;
use frontend\models\GoodCategory;
use yii\base\Widget;

class CategoryWidget extends Widget{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }
    public function run()
    {
      $redis=new \Redis();
      $redis->connect('127.0.0.1');
      $category_html=$redis->get('category_html');
      if ($category_html==null){
          $models=Goodcategory::findAll(['parent_id'=>0]);
          return $this->renderFile('@app/widgets/views/category.php',['models'=>$models]);
          $redis->set('category_html',$category_html);
      }
      return $category_html;
    }
}