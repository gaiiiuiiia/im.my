<?php


namespace core\base\settings;


use core\base\controller\Singleton;

class Settings
{

    use Singleton;

    // Расширение
    private $expansion = 'core/admin/expansion/';

    private $messages = 'core/base/messages/';

    private $routes = [
        'admin' => [
            'alias' => 'admin',
            'path' => 'core/admin/controller/',
            'hrUrl' => false,
            'routes' => [

            ],
        ],
        'settings' => [
            'path' => 'core/base/settings/',
        ],
        'plugins' => [
            'path' => 'core/plugins/',
            'hrUrl' => false,
            'dir' => false,
        ],
        'user' => [
            'path' => 'core/user/controller/',
            'hrUrl' => true,
            'routes' => [

            ],
        ],
        'default' => [
            'controller' => 'IndexController',
            'inputMethod' => 'inputData',
            'outputMethod' => 'outputData',
        ],
    ];

    private $defaultTable = 'goods';

    private $formTemplates = PATH . 'core/admin/view/include/form_templates/';

    private $projectTables = [
        'goods' => [
            'name' => 'Товары',
            'img' => 'pages.png',
        ],
        'filters' => [
            'name' => 'Фильтры',
        ],
    ];

    private $templateArr = [
        'text' => ['name'],
        'textarea' => ['content', 'keywords'],
        'radio' => ['visible'],
        'checkboxlist' => ['filters'],
        'select' => ['menu_position', 'parent_id'],
        'img' => ['img'],
        'gallery_img' => ['gallery_img'],
    ];

    private $translate = [
        'name' => ['Название', "Не более 100 символов"],
    ];

    private $radio = [
        'visible' => [
            'Нет',
            'Да',
            'default' => 'Да',
        ],
    ];

    private $rootItems = [
        'name' => 'Корневая',
        'tables' => ['articles', 'filters'],
    ];

    private $manyToMany = [
        'goods_filters' => ['goods', 'filters', 'type' => 'child'],  // 'type' => 'child' || 'root'

    ];

    private $blockNeedle = [
        'vg-rows' => [],
        'vg-img' => ['img'],
        'vg-content' => ['content', 'keywords'],
    ];

    private $validation = [
        'name' => [
            'empty' => true,
            'trim' => true,
            ],
        'price' => [
            'int' => true,
        ],
        'login' => [
            'empty' => true,
            'trim' => true,
        ],
        'password' => [
            'crypt' => true,
            'empty' => true,
        ],
        'keywords' => [
            'count' => 70,
            'trim' => true,
        ],
        'description' => [
            'count' => 160,
            'trim' => true,
        ],
    ];

    static public function get($property){
        return self::instance()->$property;
    }

    public function glueProperties($class){
        $baseProperties = [];

        foreach ($this as $name => $item){
            $property = $class::get($name);

            if (is_array($property) && is_array($item)){
                $baseProperties[$name] = $this->arrayMergeRecursive($this->$name, $property);
                continue;
            }

            if (!$property){
                $baseProperties[$name] = $this->$name;
            }
        }

        return $baseProperties;
    }

    public function arrayMergeRecursive(){

        $arrays = func_get_args();

        $base = array_shift($arrays);  // возвращает первый элемент массива

        foreach ($arrays as $array){
            foreach ($array as $key => $value){
                if (is_array($value) && is_array($base[$key])){
                    $base[$key] = $this->arrayMergeRecursive($base[$key], $value);
                }
                else{
                    if (is_int($key)){
                        if (!in_array($value, $base)){
                            array_push($base, $value);
                            continue;
                        }
                    }
                    $base[$key] = $value;
                }
            }
        }

        return $base;
    }
}