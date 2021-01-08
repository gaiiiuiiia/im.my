<?php


namespace core\base\controller;

use core\base\exceptions\RouteException;
use core\base\settings\Settings;

abstract class BaseController
{

    use BaseMethods;

    protected $header;
    protected $content;
    protected $footer;
    protected $page;

    protected $errors;

    protected $controller;
    protected $inputMethod;
    protected $outputMethod;
    protected $parameters;

    protected $template;

    protected $styles;
    protected $scripts;

    protected $userId;
    protected $data;
    protected $ajaxData;

    public function route(){
        $controller = str_replace('/', '\\', $this->controller);

        try {
            // 10 видео 10 минута
            // поиск метода request в классе $controller. далее при помощи $object можно вызвать request
            $object = new \ReflectionMethod($controller, 'request');

            $args = [
                'parameters' => $this->parameters,
                'inputMethod' => $this->inputMethod,
                'outputMethod' => $this->outputMethod,
            ];

            $object->invoke(new $controller, $args);
        }catch(\ReflectionException $e) {
            throw new RouteException($e->getMessage());
        }
    }

    public function request($args){

        $this->parameters = $args['parameters'];
        $inputData = $args['inputMethod'];
        $outputData = $args['outputMethod'];

        $data = $this->$inputData();

        if (method_exists($this, $outputData)){
            $page = $this->outputData($data);
            if ($page){
                $this->page = $page;
            }
        }
        elseif ($data){
            $this->page = $data;
        }

        if ($this->errors){
            $this->writeLog($this->errors);
        }

        $this->getPage();
    }

    protected function render($path = '', $parameters = []){
        // подключение шаблонов

        // разбор параметров. получаем доступ к элементам массива в виде
        // $elem = value, где $elem - ячейка массива
        extract($parameters);

        if (!$path){
            $class = new \ReflectionClass($this);
            $space = str_replace('\\', '/', $class->getNamespaceName() . '\\');
            $routes = Settings::get('routes');

            if ($space === $routes['user']['path']){
                $template = TEMPLATE;
            }
            else{
                $template = ADMIN_TEMPLATE;
            }

            $path = $template . explode('controller',
                    strtolower((new \ReflectionClass($this))->getShortName()))[0];
        }

        // буфер обмена
        ob_start();
        if (!@include_once $path . '.php'){
            throw new RouteException('Отсутсвует шаблон - ' . $path);
        }

        return ob_get_clean();
    }

    protected function getPage(){

        if (is_array($this->page)){
            foreach ($this->page as $block){
                echo $block;
            }
        }
        else{
            echo $this->page;
        }
        exit;
    }

    protected function init($admin = false){

        $dir = $admin ? ADMIN_CSS_JS : USER_CSS_JS;
        $template = $admin ? ADMIN_TEMPLATE : TEMPLATE;

        if ($dir['styles']) {
            foreach ($dir['styles'] as $item){
                $this->styles[] = PATH . $template . trim($item, '/');
            }
        }
        if ($dir['scripts']) {
            foreach ($dir['scripts'] as $item){
                $this->scripts[] = PATH . $template . trim($item, '/');
            }
        }
    }

}