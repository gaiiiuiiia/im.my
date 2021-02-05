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

            $method = new \ReflectionMethod($controller, 'request');

            $parameters = [
                'parameters' => $this->parameters,
                'inputMethod' => $this->inputMethod,
                'outputMethod' => $this->outputMethod,
            ];

            $method->invoke(new $controller, $parameters);

        }
        catch(\ReflectionException $e){
            throw new RouteException($e->getMessage());
        }
    }

    public function request($args){

        $this->parameters = $args['parameters'];
        $inputData = $args['inputMethod'];
        $outputData = $args['outputMethod'];

        $data = $this->$inputData();

        if (method_exists($this, $outputData)){
            $page = $this->$outputData($data);
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
        // подключение шаблонов и рендеринг

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

        $paths = $admin ? ADMIN_CSS_JS : USER_CSS_JS;
        $template = $admin ? ADMIN_TEMPLATE : TEMPLATE;

        if ($paths['styles']) {
            foreach ($paths['styles'] as $item){
                $this->styles[] = PATH . $template . trim($item, '/');
            }
        }
        if ($paths['scripts']) {
            foreach ($paths['scripts'] as $item){
                $this->scripts[] = PATH . $template . trim($item, '/');
            }
        }
    }

}