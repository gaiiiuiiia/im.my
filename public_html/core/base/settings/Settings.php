<?php


namespace core\base\settings;


use core\base\controller\Singleton;

class Settings
{

    use Singleton;

    // Расширение
    private $expansion = 'core/admin/expansion/';

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
                'login' => 'login',
            ],
        ],
        'default' => [
            'controller' => 'IndexController',
            'inputMethod' => 'inputData',
            'outputMethod' => 'outputData',
        ],
    ];

    private $defaultTable = 'teachers';

    private $formTemplates = PATH . 'core/admin/view/include/form_templates/';

    private $projectTables = [
        'teachers' => [
            'name' => 'Учителя',
            'img' => 'pages.png',
        ],
        'students' => [
            'name' => 'Ученики',
        ],
    ];

    private $templateArr = [
        'text' => ['name'],
        'textarea' => ['content'],
        'radio' => ['visible'],
        'select' => ['menu_position', 'parent_id'],
        'img' => ['img']
    ];

    private $translate = [
        'name' => ['Название', 'Не более 100 символов'],
    ];

    private $radio = [
        'visible' => [
            'Нет',
            'Да',
            'default' => 'Да'
        ],
    ];

    private $rootItems = [
        'name' => 'Корневая',
        'tables' => ['articles'],
    ];

    private $blockNeedle = [
        'vg-rows' => [],
        'vg-img' => ['img'],
        'vg-content' => ['content'],
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