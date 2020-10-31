<?php


namespace core\user\controller;


use core\admin\model\Model;
use core\base\controller\BaseController;
use core\base\model\UserModel;
use core\base\settings\Settings;

abstract class BaseUser extends BaseController
{

    protected $model;

    protected $isCookie;

    protected $title;


    protected function inputData(){

        // Подгрузили пользовательские стили и скрипты
        $this->init();

        $this->title = 'Astra';

        if (!$this->model) $this->model = Model::instance();

        if (!$this->isCookie) $this->isCookie = $this->checkCookie();

        $this->setCookie($this->isCookie);

    }

    protected function outputData(){

        if (!$this->content){
            $args = func_get_arg(0);
            $vars = $args ? $args : [];

            $this->content = $this->render($this->template, $vars);
        }

        $this->header = $this->render(TEMPLATE . 'header');
        $this->footer = $this->render(TEMPLATE . 'footer');

        // дефолтная раскладка хедер контент футер
        return $this->render(ADMIN_TEMPLATE . 'layout/default');
    }

    protected function execBase(){
        self::inputData();
    }

    protected function hash_($row, $salt = '', $cookie = false){
        // hash_algos()[9] - алгоритм шифрования sha512

        $new_row = '';
        foreach (str_split($row) as $letter){
            $new_row .= !$cookie ?
                $letter . 'salt' . $salt : $letter . 'ItsACookieSalt' . $salt;
        }

        return hash('sha512', $new_row);
    }

    protected function checkCookie(){
        // return 1, если куки были и совпали
        //       -1, если куки были и не совпали
        //        0, если куки не было

        if ($_COOKIE['login'] and $_COOKIE['password']){
            $query = [
                'fields' => ['login', 'password', 'salt'],
                'where' => ['login' => $_COOKIE['login']],
            ];

            $user_data_from_DB = $this->model->get('users', $query)[0];

            if ($user_data_from_DB){

                if ($_COOKIE['password'] === $this->hash_($user_data_from_DB['password'],
                        $user_data_from_DB['salt'], true)){
                    return 1;
                }
                return -1;
            }
        }
        return 0;
    }

    protected function setCookie($isCookie){

        if ($isCookie === 1){
            // куки совпали - обновляем куки
            setcookie('login', '', time() - 1, '/');
            setcookie('password', '', time() - 1, '/');
            setcookie ('login', $_COOKIE['login'], time() + COOKIE_TIME, '/');
            setcookie ('password', $_COOKIE['password'], time() + COOKIE_TIME, '/');
        }
        else if ($isCookie === -1){
            // куки не совпали - удаляем их
            setCookie('login', '', time() - 360000, '/');
            setCookie('password', '', time() - 360000, '/');
        }
    }

}