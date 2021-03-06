<?php
namespace frontend\components;
use yii\base\Component;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;


class Sms extends Component{
    public $app_key;
    public $app_secret;
    public $sign_name;
    public $template_code;
    private $_num;
    private $_param=[];
    //设置手机号码
    public function setNum($num){
        $this->_num=$num;
        return $this;
    }
    //设置短信内容
     public function setParam(array $param){
        $this->_param=$param;
        return $this;
     }
     //设置短信签名
     public function setSign($sign){
         $this->sign_name=$sign;
         return $this;
     }
     //设置短信模版
     public function setTemple($id){
         $this->template_code=$id;
         return $this;
     }
     //发送短信
    public function send(){
        $client = new Client(new App(['app_key'=>$this->app_key,'app_secret'=>$this->app_secret]));
        $req    = new AlibabaAliqinFcSmsNumSend;
        //$code=rand(1000,9999);
        $req->setRecNum($this->_num)//设置发给谁（手机号码）
            ->setSmsParam($this->_param)
            ->setSmsFreeSignName($this->sign_name)//设置短信签名，必须是已审核的签名
            ->setSmsTemplateCode($this->template_code);//设置短信模版，必须是已审核的模版

        return $client->execute($req);
    }
}