<?php
namespace app\components;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
 
class CurlComponents extends Component{
	public $method;
      public $token;
      public $message;

      function __construct($token) {
            $this->token = $token;
        }
	public  function setWebhook()
      {
		$this->method = "setWebhook";
		return $this;
	}
      public  function sendMessage()
      {
		$this->method = "sendMessage";
		return $this;
	}
      public function responseMessage($responseMessage)
      {
		$this->message = $responseMessage;
		return $this;
	}
	public function actionApi($chat_id){
            $getQuery = array(
                  "chat_id" 	=> $chat_id,
                  "text"  	=> $this->message,
                  "parse_mode" => "html",
                  );
            $ch = curl_init("https://api.telegram.org/bot". $this->token ."/".$this->method."?" . http_build_query($getQuery));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            if(curl_errno($ch)){
                  return curl_error($ch); 
            } 
            $resultQuery = curl_exec($ch);
            curl_close($ch);
            
           return $resultQuery;
            
      }
	
}
?>
