<?php


namespace core\admin\controller;


use core\base\controller\BaseController;
use core\admin\model\Model;
use core\base\exceptions\RouteException;
use core\base\settings\Settings;


abstract class BaseAdmin extends BaseController
{

    protected $model;

    protected $table;
    protected $columns;
    protected $data;
    protected $foreignData;

    protected $adminPath;

    protected $menu;
    protected $title;

    protected $messages;

    protected $translate;
    protected $blocks = [];

    protected $templateArr;
    protected $formTemplates;
    protected $noDelete;


    protected function inputData(){

        $this->init(true);

        $this->title = 'Some title of my site';

        if (!$this->model){
            $this->model = Model::instance();
        }
        if (!$this->menu){
            $this->menu = Settings::get('projectTables');
        }
        if (!$this->adminPath){
            $this->adminPath = PATH . Settings::get('routes')['admin']['alias'] . '/';
        }
        if (!$this->templateArr) $this->templateArr = Settings::get('templateArr');
        if (!$this->formTemplates) $this->formTemplates = Settings::get('formTemplates');

        if (!$this->messages)
            $this->messages = include $_SERVER['DOCUMENT_ROOT'] . PATH . Settings::get('messages') . 'informationMessages.php';

        $this->sendNoCacheHeaders();

    }

    protected function outputData(){

        if (!$this->content){
            $args = func_get_arg(0);
            $vars = $args ? $args : [];

            // if (!$this->template) $this->template = ADMIN_TEMPLATE . 'show';

            $this->content = $this->render($this->template, $vars);
        }

        $this->header = $this->render(ADMIN_TEMPLATE . 'include/header');
        $this->footer = $this->render(ADMIN_TEMPLATE . 'include/footer');

        return $this->render(ADMIN_TEMPLATE . 'layout/default');
    }

    protected function sendNoCacheHeaders(){

        header("Last-Modified: " . gmdate("D, d m Y H:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Cache-Control: max-age=0");
        // для браузера IE проверка после и до
        header("Cache-Control: post-check=0,pre-check=0");
    }

    protected function execBase(){
        self::inputData();
    }

    protected function createTableData($settings = false){

        if (!$this->table){

            if ($this->parameters){
                $this->table = array_keys($this->parameters)[0];
            }
            else{
                if (!$settings) $settings = Settings::instance();
                $this->table = $settings::get('defaultTable');
            }
        }
        $this->columns = $this->model->showColumns($this->table);

        if (!$this->columns){
            new RouteException('Не найдены поля в таблице - ' . $this->table, 2);
        }
    }

    protected function expansion($args = [], $settings = false){

        $filename = explode('_', $this->table);
        $className = '';

        foreach ($filename as $item){
            $className .= ucfirst($item);
        }
        if (!$settings){
            $path = Settings::get('expansion') . $className . 'Expansion';
        }else if (is_object($settings)){
            $path = $settings::get('expansion') . $className . 'Expansion';
        }else{
            $path = $settings . $className . 'Expansion';
        }

        $class = $path . $className . 'Expansion';

        if (is_readable($_SERVER['DOCUMENT_ROOT'] . PATH . $class . '.php')){
            $class = str_replace('/', '\\', $class);

            $exp = $class::instance();

            foreach ($this as $name => $value){
                // передаем ссылку
                $exp->$name = &$this->$name;
            }

            return  $exp->expansion($args);

        }
        else{
            $file = $_SERVER['DOCUMENT_ROOT'] . PATH . $path . $this->table . '.php';

            extract($args);
            if (is_readable($file)) return include $file;
        }

        return false;
    }

    protected function createOutputData($settings = false){

        if (!$settings) $settings = Settings::instance();

        $blocks = $settings::get('blockNeedle');

        $this->translate = $settings::get('translate');

        if (!$blocks || !is_array($blocks)){
            foreach ($this->columns as $name => $item){
                if ($name === 'id_row') continue;

                if (!$this->translate[$name]) $this->translate[$name][] = $name;
                $this->blocks[0][] = $name;
            }
            return;
        }

        $default = array_keys($blocks)[0];

        foreach ($this->columns as $name => $item){
            if ($name === 'id_row') continue;

            $insert = false;

            foreach ($blocks as $block => $value){

                if (!array_key_exists($block, $this->blocks)) $this->blocks[$block] = [];

                if (in_array($name, $value)){
                    $this->blocks[$block][] = $name;
                    $insert = true;
                    break;
                }
            }

            if (!$insert) $this->blocks[$default][] = $name;
            if (!$this->translate[$name]) $this->translate[$name][] = $name;
        }

        return;
    }

    protected function createRadio($settings = false){

        if (!$settings) $settings = Settings::instance();

        $radio = $settings::get('radio');

        if ($radio){
            foreach ($this->columns as $name => $item){
                if ($radio[$name]){
                    $this->foreignData[$name] = $radio[$name];
                }
            }
        }
    }

    protected function checkPost($settings = false){

        if ($this->isPost()){
            $this->clearPostFields($settings);
            $this->table = $this->clearStr($_POST['table']);
            unset($_POST['table']);

            if ($this->table){
                $this->createTableData($settings);
                $this->editData();
            }

        }

    }

    protected function addSessionData($arr = []){
        if (!$arr) $arr = $_POST;

        foreach ($arr as $key => $item){
            $_SESSION['res'][$key] = $item;
        }

        $this->redirect();
    }

    protected function countChar($str, $counter, $answer, $arr = []){

        if (mb_strlen($str) > $counter){

            $str_res = mb_str_replace('$1', $answer, $this->messages['count']);
            $str_res = mb_str_replace('$2', $counter, $str_res);

            $_SESSION['res']['answer'] = '<div class="error">' . $str_res . '</div>';
            $this->addSessionData($arr);

        }

    }

    protected function emptyFields($str, $answer, $arr = []){

        if (empty($str)){
            $_SESSION['res']['answer'] = '<div class="error">' . $this->messages['empty'] . ' ' . $answer . '</div>';
            $this->addSessionData($arr);
        }

    }


    protected function clearPostFields($settings, &$arr = []){
        if (!$arr) $arr = &$_POST;  // ссылка
        if (!$settings) $settings = Settings::instance();

        $id = $_POST[$this->columns['id_row']] ?: false;

        $validate = $settings::get('validation');
        if (!$this->translate) $this->translate = $settings::get('translate');

        foreach ($arr as $key => $item){
            if (is_array($item)){
                $this->clearPostFields($settings, $item);
            } else{
                if (is_numeric($item)){
                    $arr[$key] = $this->clearNum($item);
                }
                if ($validate){

                    if ($validate[$key]){

                        if ($this->translate[$key]){
                            $answer = $this->translate[$key][0];
                        } else{
                            $answer = $key;
                        }

                        if ($validate[$key]['crypt']){
                            if ($id){
                                if (empty($item)){
                                    unset($arr[$key]);
                                    continue;
                                }
                            }

                            $arr[$key] = md5($item);
                        }

                        if ($validate[$key]['empty']) $this->emptyFields($item, $answer, $arr);
                        if ($validate[$key]['trim']) $arr[$key] = trim($item);
                        if ($validate[$key]['int']) $arr[$key] = $this->clearNum($item);
                        if ($validate[$key]['count']) $this->countChar($item, $validate[$key]['count'], $answer, $arr);

                    }
                }
            }
        }
    }

    protected function editData(){

    }

}