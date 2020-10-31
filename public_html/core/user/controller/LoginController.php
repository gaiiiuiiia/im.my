<?php


namespace core\user\controller;

use core\base\exceptions\UserException;


class LoginController extends BaseUser
{

    protected function inputData(){

        $this->execBase();

        if (isset($_POST['loginButton'])){

            $user_data = $this->createUserData();

            $user_data_from_DB = $this->createUserDataFromDB($user_data);

            if (!$user_data_from_DB) {
                $this->redirect($_SERVER['HTTP_REFERER']);
                //throw new UserException('Пользователя с таким логином не существует', 3);
            }

            if (!$this->checkPassword($user_data['password'], $user_data_from_DB)){
                throw new UserException('Неверный пароль', 4);
            }

            $this->authorize($user_data, $user_data_from_DB);

            $this->redirect($_SERVER['HTTP_REFERER']);
        }
        else if (isset($_POST['logoutButton'])){
            $this->logout();
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
        else if ($this->isCookie === 1){
            $this->redirect($_SERVER['HTTP_REFERER']);
            $this->content = 'страница входа на сайт';
        }
        else if ($this->isCookie === 0){
            $this->content = 'страница входа на сайт';
        }

    }

   /* protected function outputData(){
        $this->redirect($_SERVER['HTTP_REFERER']);
    }*/

    protected function createUserData(){

        if (!$_POST['login'] || !$_POST['password']){
            $this->redirect($_SERVER['HTTP_REFERER']);
        }

        return ['login' => $_POST['login'],
                'password' => $_POST['password']];
    }

    protected function createUserDataFromDB($user_data){

        $query = [
            'fields' => ['id', 'login', 'password', 'salt'],
            'where' => ['login' => $user_data['login']],
        ];

        return $this->model->get('users', $query)[0];
    }

    protected function checkPassword($user_password, $user_data_from_DB){
        if ($this->hash_($user_password, $user_data_from_DB['salt']) === $user_data_from_DB['password']){
            return true;
        }
        return false;
    }

    protected function authorize($user_data, $user_data_from_DB){

        setcookie('login', $user_data['login'], time() + COOKIE_TIME);

        setcookie('password',
            $this->hash_($user_data_from_DB['password'], $user_data_from_DB['salt'], true),
            time() + COOKIE_TIME);

        $_SESSION[$user_data_from_DB['id']] = $user_data_from_DB['id'];
    }

    protected function logout(){

        SetCookie('login', '', time() - 360000, '/');
        SetCookie('password', '', time() - 360000, '/');
        unset($_SESSION['id']);
    }

    private function fill_db_user_data(){
        // Заполняю бд данными

        $data = ['1', 'admin', 'max', '123'];

        foreach ($data as $row){
            $query = [
                'fields' => [
                    'login' => $row,
                    'password' => $this->hash_($row, 'salt_' . $row),
                    'salt' => 'salt_' . $row,
                ],
            ];

            $this->model->add('users', $query);
        }
    }

}