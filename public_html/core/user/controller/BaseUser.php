<?php


namespace core\user\controller;


use core\admin\model\Model;
use core\base\controller\BaseController;
use core\base\settings\Settings;

abstract class BaseUser extends BaseController
{

    protected $model;

    protected $title;


    protected function inputData(){

        // Подгрузили пользовательские стили и скрипты
        $this->init();

        $this->title = 'Astra';

        if (!$this->model) $this->model = Model::instance();

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


}