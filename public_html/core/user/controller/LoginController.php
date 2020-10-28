<?php


namespace core\user\controller;


/*
 * Вход на сайт
 * 1 получить данные из форм ввода.
 * 2 проверить, есть ли они в бд
 *    да: вывести вы вошли как пользователь
 *    нет: вывести нет такого пользователя
 * */

use core\base\model\UserModel;


class LoginController extends BaseUser
{

    protected function inputData(){

        if (!$this->model) $this->model = UserModel::instance();

        $user_data = $this->createUserData();

        $authorized = $this->checkUserInDataBase($user_data);

        $ses = $_SESSION;

        if ($authorized){

        }

    }

    protected function outputData(){
        $this->redirect($_SERVER['HTTP_REFERER']);
    }

    protected function createUserData(){

        if (!$_POST['login'] || !$_POST['password']){
            $this->redirect($_SERVER['HTTP_REFERER']);
        }

        return ['login' => $_POST['login'],
                'password' => $_POST['password']];

    }

    protected function checkUserInDataBase($user_data){
        $query = [
            'fields' => ['id'],
            'where' => [
                'login' => $user_data['login'],
                'password' => $user_data['password'],
            ],
        ];

        return $this->model->get('users', $query);
    }

}