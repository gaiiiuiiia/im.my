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

            $userLoginData = $this->registerUser();

            $this->deleteDataFromArray('user/userInput', $_SESSION);

            $this->login($userLoginData);

            $this->redirect(SITE_URL);

        } else if (isset($_SESSION['user']['authorized'])){

            $this->msgHandler->createMessage('alreadyLogged', 'alreadyLogged');

            $this->redirect($_SERVER['HTTP_REFERER'] . '/#systemMessage');

        }
    }

    protected function validateUserRegistrationData(){

        return $this->checkLogin() && $this->checkPassword() && $this->checkEmail();

    }

    /**
     * Добавлет данные о пользователе в таблицу user и user_info.
     * возвращает данные о пользователе из таблицы user.
     * @return mixed
     */
    protected function registerUser(){

        $query1 = [
            'fields' => [
                'login' => $this->userInput['login'],
                'password' => $this->crypt->encrypt($this->userInput['password']),
            ],
        ];

        $this->model->add($this->userTables['userLoginTable'], $query1);

        $userLoginData = $this->model->get($this->userTables['userLoginTable'], [
            'where' => ['login' => $this->userInput['login']],
        ])[0];

        $query2 = [
            'fields' => [
                'user_id' => $userLoginData['id'],
                'email' => $this->userInput['email'],
                'name' => $this->userInput['name'],
            ],
        ];

        $this->model->add($this->userTables['userInfoTable'], $query2);

        return $userLoginData;
    }

    protected function checkLogin(){

        $query = [
            'fields' => ['id'],
            'where' => ['login' => $this->userInput['login']]
        ];

        if ($this->model->get($this->userTables['userLoginTable'], $query)[0]){

            $this->msgHandler->createMessage('loginExists', 'registrationError');
            $this->redirect($_SERVER['HTTP_REFERER'] . '/#enter');
        }

        return true;
    }

    protected function checkPassword(){

        if ($this->userInput['password'] !== $this->userInput['confirm-password']){
            $this->msgHandler->createMessage('passwordsDoNotMatch', 'registrationError');
            $this->redirect($_SERVER['HTTP_REFERER'] . '/#enter');
        }

    }

    protected function checkEmail(){

        $query = [
            'fields' => ['email'],
            'where' => ['email' => $this->userInput['email']]
        ];

        if ($this->model->get($this->userTables['userInfoTable'], $query)[0]){

            $this->msgHandler->createMessage('emailExists', 'registrationError');
            $this->redirect($_SERVER['HTTP_REFERER'] . '/#enter');
        }

        return true;
    }

}