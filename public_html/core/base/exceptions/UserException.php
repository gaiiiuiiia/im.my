<?php


namespace core\base\exceptions;


use core\base\controller\BaseMethods;

class UserException extends \Exception
{
    protected $messages;

    use BaseMethods;

    public function __construct($message = "", $code = 0)
    {
        parent::__construct($message, $code);

        $this->messages = include 'messages.php';

        $error = $this->getMessage();

        $error .= "\r\n" . 'file ' . $this->getFile() . "\r\n" . 'In line ' . $this->getLine() . "\r\n";

        $this->writeLog($error);

    }
}