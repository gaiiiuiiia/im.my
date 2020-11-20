<?php


namespace core\user\controller;

use core\base\exceptions\UserException;


class LoginController extends BaseUser
{

    protected function inputData(){

        $this->execBase();

        if ($_SESSION['user']['authorized'] && !isset($_POST['logoutButton'])){

            $this->createMessage($this->messages['alreadyLogged']);

            $this->redirect();
        }
        if (isset($_POST['loginButton'])){

            $this->saveDataToSession('userInput', $_POST);

            $userDataFromDB = $this->validateUserLoginData();
            $this->login($userDataFromDB);

            $this->clearUserInputFromSession();

            $this->redirect();
        } else if (isset($_POST['logoutButton'])){

            $this->logout();

            $this->redirect();
        }
    }

    protected function validateUserLoginData(){

        $userData = $this->createUserInputData(['login', 'password']);

        $userDataFromDB = $this->getUserDataFromDB($userData['login'], $this->tables['userLoginTable']);

        if (!$userDataFromDB) {
            $this->createMessage($this->messages['userNotExists']);
            $this->redirect($_SERVER['HTTP_REFERER'] . '/#enter');
        }

        if (!$this->checkPassword($userData['password'], $userDataFromDB)){
            $this->createMessage($this->messages['incorrectPassword']);
            $this->redirect($_SERVER['HTTP_REFERER'] . '/#enter');
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

        return $this->startSession($userData['id']);
    }

    protected function logout(){

        $this->setCookie(true);

        unset($_SESSION['user']);
        unset($_SESSION['id']);
        session_destroy();
        session_start();
        $_SESSION['id'] = 'guestID';
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

            $query_ = [
                'fields' => [
                    'login' => $row . '_login',
                    'email' => $row . 'email@mail.top',
                    'name' => 'имя_' . $row,
                    'surname' => 'фамилия_' . $row,
                    'sex_id' => 1
                ],
            ];

            $this->model->add('user', $query);
            //$this->model->add('user_info', $query_);
        }
    }

}