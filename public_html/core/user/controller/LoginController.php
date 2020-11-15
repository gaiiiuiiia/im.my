<?php


namespace core\user\controller;

use core\base\exceptions\UserException;


class LoginController extends BaseUser
{

    protected $error;

    protected function inputData(){

        $this->execBase();

        if ($this->login){
            $this->createMessage($this->messages['alreadyLogged']);
            $this->redirect();
        }

        if (isset($_POST['loginButton'])){

            $userDataFromDB = $this->validateUserLoginData();

            $this->login($userDataFromDB);
            $this->redirection = true;
        }
        else if (isset($_POST['logoutButton'])){
            $this->logout();
        }
    }

    protected function outputData(){
        if ($this->login){
            $this->redirect();
        }

        parent::outputData(func_get_arg(0));
    }

    protected function validateUserLoginData(){

        $userData = $this->createUserData(['login', 'password']);

        $userDataFromDB = $this->createUserDataFromDB($userData);

        if (!$userDataFromDB) {
            $this->createMessage($this->messages['userNotExists']);
            $this->redirect();
        }

        if (!$this->checkPassword($userData['password'], $userDataFromDB)){
            $this->createMessage($this->messages['incorrectPassword']);
            $this->redirect();
        }

        return $userDataFromDB;
    }

    protected function checkPassword($user_password, $user_data_from_DB){
        if ($this->hash_($user_password, 'pass', $user_data_from_DB['salt']) === $user_data_from_DB['password']){
            return true;
        }
        return false;
    }

    protected function login($userData){

        if (isset($_POST['rememberMe'])) $this->setCookie(false, $userData);

        session_start();
        $_SESSION['id'] = $userData['id'];
        $_SESSION['login'] = $userData['login'];
    }

    protected function logout(){

        $this->setCookie(true);

        unset($_SESSION['login']);
        unset($_SESSION['id']);
        session_destroy();
        session_start();
        $_SESSION['id'] = 'guestID';
        $this->login = null;
    }

    private function fill_db_user_data(){
        // Заполняю бд данными

        $data = ['1', 'admin', 'max', '123'];

        foreach ($data as $row){
            $query = [
                'fields' => [
                    'login' => $row,
                    'password' => $this->hash_($row, 'pass', 'salt_' . $row),
                    'salt' => 'salt_' . $row,
                ],
            ];

            $this->model->add('users', $query);
        }
    }

}