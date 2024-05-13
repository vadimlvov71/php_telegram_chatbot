<?php
namespace app\controllers;
use Yii;
use PDO;

use yii\web\Controller;
use app\models\Telegram;

use \yii\base\HttpException;
use app\components\CurlComponents;

use yii\web\Response;

class TelegramController extends Controller
{
	
	//private $chat_id = "1971625323";
	public function actionChatbot(){
		$token = "7010315744:AAH-0-3XiB6tXhyRwh17ei_-BdmA8HI8mt4";
		//$telegram_api_url ="";

		$data = json_decode(file_get_contents('php://input'), true); // передаём в переменную $result полную информацию о сообщении пользователя
		//$this->writeLogFile($data, false);
		$chat_id = $data['message']['chat']['id'];
		$first_name = $data['message']['from']['first_name'];
		$last_name = $data['message']['from']['last_name'];

		
		$responseMessage = "";
		if ($data['message']['text'] == '/start') {
			$responseMessage .= "Hello! " . $first_name;
			$model = new Telegram();
			$model->first_name = $first_name;
			$model->last_name = $last_name;
			if ($model->save()){
				$responseMessage .= " your name was stored";
			}
		} else {
			$responseMessage .= $first_name . ", your message was stored";
		}
		//exit;
		$curl = new CurlComponents($token);
		$curl
		->sendMessage()
		->responseMessage($responseMessage)
		->actionApi($chat_id)
		;
	
	
		
	/*$curl
		->setWebhook()
		->deleteMessage()
		->actionApi()
		;*/
	
	exit;
		$chats = Telegram::find()
			   ->select(['id', 'name'])
			   //->orWhere(['type' => 11])
			  ->all();

		foreach ($chats as $item){
			echo $item['id']."###".$item['first_name']."<br>";

		}
	
	}
	function writeLogFile($string, $clear = false){
	
		$log_file_name = "../runtime/logs/message.txt";
		if($clear == false) {
			$now = date("Y-m-d H:i:s");
			file_put_contents($log_file_name, $now." ".print_r($string, true)."\r\n", FILE_APPEND);
		}
		else {
			file_put_contents($log_file_name, '');
			file_put_contents($log_file_name, $now." ".print_r($string, true)."\r\n", FILE_APPEND);
		}
	}
    
}

