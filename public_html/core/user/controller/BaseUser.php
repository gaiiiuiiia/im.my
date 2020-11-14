<?php


namespace core\user\controller;


use core\base\controller\BaseController;
use core\base\model\UserModel;


abstract class BaseUser extends BaseController
{

    protected $model;

    protected $title;

    protected $login;

    protected $message;


    protected function inputData(){

        // Подгрузили пользовательские стили и скрипты
        $this->init();

        $this->title = 'ASTRA';

        if (!$this->model) $this->model = UserModel::instance();

        $this->authorize();

        if (!$this->message) $this->message = $this->getMessage();

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

    private function authorize(){

        if (isset($_SESSION['login'])){
            // Авторизованный пользователь
            $this->login = $_SESSION['login'];

        }
        else{
            // мб гость, а мб и пользователь, который только-только зашел...
            $cookieFields = ['id', 'login', 'password',];
            if ($this->hasCookie($cookieFields)){
                // восстанвить сессию по ним
                // $userData - либо массив данных пользователя из бд, либо false
                if ($userData = $this->checkCookie($cookieFields)){
                    $this->startSession($userData);
                    $this->setCookie(false, $userData);  // проверить, а не конфликтует ли это с "галочкой на запомнить меня"

                    $this->login = $_SESSION['login'];
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

    protected function startSession($userData){

        session_start();

        if ($userData and is_array($userData)){
            $_SESSION['id'] = $userData['id'];
            $_SESSION['login'] = $userData['login'];
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

    protected function createUserData($fields = []){

        if (!$_POST) return [];

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

    protected function hasCookie($fields){

        if ($fields){
            foreach ($fields as $field){
                if (!isset($_COOKIE[$field])) return false;
            }
            return true;
        }
    }

    protected function checkCookie($cookieFields){

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

        if ($this->hash_($userDataFromDB['password'], 'cookie', $userDataFromDB['salt']) === $_COOKIE['password'])
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

    protected function createUserDataFromDB($userData){

        $query = [
            'fields' => [],
            'where' => [
                'login' => $userData['login'],
            ],
        ];

        return $this->model->get('users', $query)[0];
    }

    protected function getMessage(){
        $message = $_SESSION['messageToUser'];
        unset($_SESSION['messageToUser']);

        return $message;
    }

}