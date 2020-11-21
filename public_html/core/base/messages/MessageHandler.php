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

        $this->saveDataToSession($this->messagesTypes[$type], '<div>'. $message . '</div>');

    }

    public function showMessage($type){

        if (!array_key_exists($type, $this->messagesTypes)){
            echo "<div class='error'>Ошибка вывода! Данный тип сообщения не существует.</div>";
            return;
        }
        if (isset($_SESSION[$this->messagesTypes[$type]])){
            // TODO Написать метод, по аналогии с SaveDataToSession, который будет по маршруту проверять ячейку в массиве

            $msg = $_SESSION[$this->messagesTypes[$type]];
            $msgClass = strpos($type, 'error') ? 'error' : 'notify';

            echo "<div class='$msgClass'>$msg</div>";
            unset($_SESSION[$this->messagesTypes[$type]]);
        }
    }

}