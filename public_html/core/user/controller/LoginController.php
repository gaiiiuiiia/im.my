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
use core\base\controller\BaseController;

class LoginController extends BaseController
{
    protected $model;

    protected function inputData(){

        $this->model = Model::instance();

        $w = $this->model->get('teachers');

        exit;

    }

    protected function outputData(){

    }

}