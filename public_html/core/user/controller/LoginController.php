<?php


namespace core\user\controller;


use core\base\controller\Singleton;

class LoginController extends BaseUser
{

    protected function inputData(){

        $this->execBase();

        if ($_SESSION['user']['authorized'] && !isset($_POST['logoutButton'])){

            // если зашли с im.my/login
            if ($_SERVER['HTTP_REFERER'] === SITE_URL . '/login' ||
                $_SERVER['HTTP_REFERER'] === SITE_URL . '/registration'){

                $this->redirect(SITE_URL);
            }

            $this->msgHandler->createMessage('alreadyLogged', 'alreadyLogged');
            $this->redirect($_SERVER['HTTP_REFERER'] . '/#systemMessage');
        }
        if (isset($_POST['loginButton'])){

            $this->createUserInput(['login', 'password']);

            $this->saveDataToArray('user/userInput', $this->userInput, $_SESSION);

            $userDataFromDB = $this->validateUserLoginData();

            $this->login($userDataFromDB);

            $this->deleteDataFromArray('user/userInput', $_SESSION);

            $this->redirect();

        } else if (isset($_POST['logoutButton'])){

            $this->logout();

            $this->redirect();
        }
    }

    protected function validateUserLoginData(){

        $userDataFromDB = $this->getUserDataFromDB(['login' => $this->userInput['login']], $this->userTables['userLoginTable']);

        if (!$userDataFromDB) {
            $this->msgHandler->createMessage('userNotExists', 'loginError');
            $this->redirect($_SERVER['HTTP_REFERER'] . '/#enterError');
        }

        if (!$this->validatePassword($userDataFromDB['password'])){
            $this->msgHandler->createMessage('incorrectPassword', 'loginError');
            $this->redirect($_SERVER['HTTP_REFERER'] . '/#enterError');
        }

        return $userDataFromDB;
    }

    protected function validatePassword($userPasswordFromDB){

        return $this->crypt->decrypt($userPasswordFromDB) === $this->userInput['password'];

    }

    protected function logout(){

        $this->setCookie(['id', 'login', 'password'], true);

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