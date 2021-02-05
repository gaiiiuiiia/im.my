<?php


namespace core\base\messages;


use core\base\controller\BaseMethods;
use core\base\controller\Singleton;
use core\base\exceptions\UserException;
use core\base\settings\Settings;

class MessageHandler
{
    use Singleton;
    use BaseMethods;

    protected $messages;
    protected $messagesTypes;

    private function __construct(){

        $this->messagesTypes = include $_SERVER['DOCUMENT_ROOT'] . PATH .
            Settings::get('messages') . 'messagesTypes.php';

        $this->messages = include $_SERVER['DOCUMENT_ROOT'] . PATH .
            Settings::get('messages') . 'informationMessages.php';

    }

    public function createMessage($message, $type){

        try{
            if (!array_key_exists($type, $this->messagesTypes) ||
                !array_key_exists($message, $this->messages))

                throw new UserException("Некорректное сообщение пользователю с параметрами $type, $message");
        }
        catch (UserException $e){
            return;
        }

        $this->saveDataToArray($this->messagesTypes[$type], '<div>'. $this->messages[$message] . '</div>', $_SESSION);

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