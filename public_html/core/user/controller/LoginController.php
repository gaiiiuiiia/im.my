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

        exit;



    }

    protected function outputData(){

        return;
    }

    protected function createUserData(){

        if (!$_POST['login'] || !$_POST['password']) return false;

        $login = $_POST['login'];
        $password = $_POST['password'];

        $query = [
            'fields' => ['id'],
            'where' => [
                'login' => $login,
                'password' => $password,
            ],
        ];

        $res = $this->model->get('users', $query);




    }

}