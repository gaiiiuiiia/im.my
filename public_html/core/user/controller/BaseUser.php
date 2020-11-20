<?php


namespace core\user\controller;


use core\base\controller\BaseController;
use core\base\model\UserModel;
use core\base\settings\Settings;


abstract class BaseUser extends BaseController
{

    protected $model;

    protected $title;

    protected $messages;

    protected $tables;

    protected function inputData(){

        // Подгрузили пользовательские стили и скрипты
        $this->init();

        $this->title = 'ASTRA';

        if (!$this->tables) $this->tables = Settings::get('userTables');

        if (!$this->model) $this->model = UserModel::instance();

        if (!$this->messages)
            $this->messages = include $_SERVER['DOCUMENT_ROOT'] . PATH .
                                        Settings::get('messages') . 'informationMessages.php';

        $this->authorizeUser();

        $this->createUserInformation();
    }

    protected function outputData(){

        if (!$this->content){
            $args = func_get_arg(0);
            $vars = $args ? $args : [];

            $this->content = $this->render($this->template, $vars);
        }

        $this->header = $this->render(USER_TEMPLATE . 'include/header');
        $this->footer = $this->render(USER_TEMPLATE . 'include/footer');

        // дефолтная раскладка хедер контент футер
        return $this->render(ADMIN_TEMPLATE . 'layout/default');
    }

    protected function createUserInformation(){

        if ($_SESSION['user']['authorized'] && !$_SESSION['user']['userInfo']){

            $user_data = $this->getUserDataFromDB($_SESSION['id'], $this->tables['userInfoTable']);
            $this->saveDataToSession($_SESSION['user']['user_info'], $user_data);
        }
    }

    private function authorizeUser(){

        if (!isset($_SESSION['user']['authorized'])){

            $cookieFields = ['id', 'login', 'password',];

            if ($this->hasCookie($cookieFields)){

                if ($userData = $this->validateCookie($cookieFields)){

                    $this->startSession($userData['id']);
                    $this->setCookie(false, $userData);  // проверить, а не конфликтует ли это с "галочкой на запомнить меня".
                    // не конфликтует, т.к. еслки куки есть, то они были установлены ранее. тут просто продлеваем эти куки
                }
                else{
                    $this->setCookie(true);
                }
            }
            else{
                // создать сессию - это будет гость
                $this->startSession(false);
            }
        }
    }

    protected function startSession($userId){

        session_start();

        if ($userId){
            $_SESSION['id'] = $userId;
            $_SESSION['user']['authorized'] = true;
        }
        else {
            $_SESSION['id'] = 'guestID';
        }
    }

    protected function execBase(){
        self::inputData();
    }

    /**
     * @param $row
     * @param string $salt: соль
     * @param string $type: 'pass' для пароля в БД
     *                      'cookie' для хранения в куки $_COOKIES
     *                      'ses' для хранения в массиве $_SESSION
     * @return string
     */
    protected function hash_($row, $type, $salt = ''){
        // hash_algos()[9] - алгоритм шифрования sha512

        $possible_types = [
            'pass',
            'cookie',
            'ses',
            ];
        $row = str_split($row);
        $new_row = '';

        if (in_array(strtolower($type), $possible_types)){
            foreach ($row as $letter){
                $new_row .= $letter . $type . $salt;
            }
        }
        return hash('sha512', $new_row);
    }

    protected function createUserInputData($fields = []){

        if ($this->isPost()){

            if (!$fields){
                // получить все данные из массива пост
                foreach ($_POST as $key => $value){
                    $res[$key] = $value;
                }
            }
            else{
                foreach ($fields as $value){
                    $res[$value] = $_POST[$value];
                }
            }
            return $res;
        }
        return [];
    }

    protected function hasCookie($fields){

        if ($fields){
            foreach ($fields as $field){
                if (!isset($_COOKIE[$field])) return false;
            }
            return true;
        }
    }

    protected function validateCookie($cookieFields){

        if (!$cookieFields) return false;

        foreach ($cookieFields as $field){
            if ($field !== 'password') $where[$field] = $_COOKIE[$field];
        }

        $query = [
            'fields' => [],
            'where' => $where,
            'operand' => ['='],
            'condition' => ['AND'],
        ];

        $userDataFromDB = $this->model->get('users', $query)[0];

        if ($userDataFromDB && $this->hash_($userDataFromDB['password'],
                                            'cookie', $userDataFromDB['salt']) === $_COOKIE['password'])
            return $userDataFromDB;
        return false;
    }

    protected function setCookie($delete = false, $userData = []){

        if ($userData){
            setcookie('id', $userData['id'], time() + COOKIE_TIME, '/');
            setcookie('login', $userData['login'], time() + COOKIE_TIME, '/');
            setcookie('password', $this->hash_($userData['password'], 'cookie', $userData['salt']),
                                                                time() + COOKIE_TIME, '/');
        }
        else if ($delete){
            setcookie('id', '', time() - 1, '/');
            setcookie('login', '', time() - 1, '/');
            setcookie('password', '', time() - 1, '/');
        }
    }

    /**
     * @param $field - поле, по которому ищется пользователь в базе. либо id, либо login
     * @param $table
     * @return mixed
     */
    protected function getUserDataFromDB($field, $table){
        if (is_string($field)) $where = ['login' => $field];
            else if (is_numeric($field)) $where = ['id' => $field];
                else return null;

        $query = [
            'fields' => [],
            'where' => $where,
        ];

        return $this->model->get($table, $query)[0];
    }

    protected function createMessage($message){
        $_SESSION['res']['answer'] = '<div class="error">' . $message . '</div>';
    }

    /**
     * @param $arr - массив с данными
     * @param $sessionCell - ячейка в массиве $_SESSION, куда будет записаны данные из массива $arr
     * ОЖИДАЕТСЯ, ЧТО ЭТОТ ПАРАМЕТР ИМЕЕТ ВИД $_SESSION[...].. и тд
     */
    protected function saveDataToSession($sessionCell, $arr = null){
        // TODO Подумать, как доставить данные из ячейки в ячейку сессии
        if (!$arr){
            if ($this->isPost()){
                foreach ($_POST as $item => $value){
                    $sessionCell[$item] = $value;
                }
            }
        } else {
            foreach ($arr as $item => $value){
                $_SESSION[$sessionCell][$item] = $value;
            }
        }


    }

    protected function clearUserInputFromSession(){
        unset($_SESSION['userInput']);
    }

}