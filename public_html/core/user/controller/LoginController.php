<?php


namespace core\user\controller;


/*
 * Вход на сайт
 * 1 получить данные из форм ввода.
 * 2 проверить, есть ли они в бд
 *    да: вывести вы вошли как пользователь
 *    нет: вывести нет такого пользователя
 * */

use core\admin\model\Model;


class LoginController extends BaseUser
{

    protected function inputData(){

        return 'some_text';

    }

    protected function outputData(){
        return func_get_arg(0);
    }

}