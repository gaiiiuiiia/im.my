<?php


namespace core\base\messages;


use core\base\controller\BaseMethods;
use core\base\controller\Singleton;
use core\base\settings\Settings;

class MessageHandler
{
    use Singleton;
    use BaseMethods;

    protected $messagesTypes;

    private function __construct(){

        $this->messagesTypes = include $_SERVER['DOCUMENT_ROOT'] . PATH .
            Settings::get('messages') . 'messagesTypes.php';

    }

    public function createMessage($message, $type){

        if (!array_key_exists($type, $this->messagesTypes)) return;

        $this->saveDataToArray($this->messagesTypes[$type], '<div>'. $message . '</div>', $_SESSION);

    }

    public function showMessage($type){

        if (!array_key_exists($type, $this->messagesTypes)){
            echo "<div class='error'>Ошибка вывода! Данный тип сообщения не существует.</div>";
            return;
        }
        if ($msg = $this->getDataFromArray($this->messagesTypes[$type], $_SESSION)){

            $msgClass = strpos(strtolower($type), 'error') ? 'error' : 'notify';

            echo "<div class='$msgClass center'>$msg</div>";
            $this->deleteDataFromArray($this->messagesTypes[$type], $_SESSION);
        }
    }

}