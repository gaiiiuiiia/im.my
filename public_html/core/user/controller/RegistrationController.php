<?php


namespace core\user\controller;


class RegistrationController extends BaseUser
{
    protected function inputData(){

        $this->execBase();

        if (isset($_POST['registrationButton']) && !isset($_SESSION['user']['authorized'])){

            $this->createUserInput(['name',
                                'login',
                             'email',
                       'password',
            'confirm-password']);

            $this->saveDataToArray('user/userInput', $this->userInput, $_SESSION);

            $this->validateUserRegistrationData();

            $this->registerUser();

            $this->deleteDataFromArray('user/userInput', $_SESSION);

            $this->login();

            $this->redirect(SITE_URL);
        } else if (isset($_SESSION['user']['authorized'])){
            $this->msgHandler->createMessage($this->messages['alreadyLogged'], 'alreadyLogged');
            $this->redirect($_SERVER['HTTP_REFERER'] . '/#systemMessage');
        }
    }

    protected function validateUserRegistrationData(){

        $this->checkLogin();
        $this->checkPassword();
        $this->checkEmail();


    }

    protected function registerUser(){
        $salt = hash('crc32', time() + mt_rand(0, 1000));

        $query1 = [
            'fields' => [
                'login' => $this->userInput['login'],
                'password' => $this->hash_($this->userInput['password'], 'pass', $salt),
                'salt' => $salt,
            ],
        ];

        $query2 = [
            'fields' => [
                'login' => $this->userInput['login'],
                'email' => $this->userInput['email'],
                'name' => $this->userInput['name'],
            ],
        ];

        $this->model->add($this->tables['userLoginTable'], $query1);
        $this->model->add($this->tables['userInfoTable'], $query2);
    }

    protected function login(){

        $query = [
            'fields' => [],
            'where' => ['login' => $this->userInput['login']],
        ];

        $res = $this->model->get($this->tables['userLoginTable'], $query)[0];

        return (new LoginController())->login($res);
    }

    protected function checkLogin(){

        $query = [
            'fields' => ['id'],
            'where' => ['login' => $this->userInput['login']]
        ];

        if ($this->model->get($this->tables['userLoginTable'], $query)[0]){

            $this->msgHandler->createMessage($this->messages['loginExists'], 'registrationError');
            $this->redirect($_SERVER['HTTP_REFERER'] . '/#enter');
        }

        return true;
    }

    protected function checkPassword(){

        if ($this->userInput['password'] !== $this->userInput['confirm-password']){
            $this->msgHandler->createMessage($this->messages['passwordsDoNotMatch'], 'registrationError');
            $this->redirect($_SERVER['HTTP_REFERER'] . '/#enter');
        }

    }

    protected function checkEmail(){

        $query = [
            'fields' => ['email'],
            'where' => ['email' => $this->userInput['email']]
        ];

        if ($this->model->get($this->tables['userInfoTable'], $query)[0]){

            $this->msgHandler->createMessage($this->messages['emailExists'], 'registrationError');
            $this->redirect($_SERVER['HTTP_REFERER'] . '/#enter');
        }

        return true;
    }

}