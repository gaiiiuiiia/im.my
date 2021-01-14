<?php

defined('VG_ACCESS') or die ('Access denied');

use core\base\exceptions\RouteException;

const MS_MODE = false;  // работаем с браузером Microsoft?

const TEMPLATE = 'templates/default/';
const ADMIN_TEMPLATE = 'core/admin/view/';
const USER_TEMPLATE = 'core/user/view/';
const UPLOAD_DIR = 'userfiles/';

const COOKIE_VERSION = '1.0.0';
const CRYPT_KEY = 'TjWnZr4u7x!z%C*FbQeThWmZq4t7w!z$G+KbPeShVmYq3t6w%D*G-KaPdSgVkYp3w!z%C*F-JaNdRgUk4t7w9z$C&F)J@NcRmYq3t6w9y$B&E)H@SgVkYp3s6v9y/B?E';
const COOKIE_TIME = 60;
const BLOCK_TIME = 3;

const QTY = 8;  // кол-во товаров на странице
const QTY_LINKS = 3;  // кол-во ссылок справа и слева (пагинация)

const ADMIN_CSS_JS = [
    'styles' => ['css/main.css'],
    'scripts' => [
        'js/frameworkfunctions.js',
        'js/scripts.js'],
];
const USER_CSS_JS = [
    'styles' => ['css/main.css'],
    'scripts' => [],
];


function autoloadMainClasses($class_name){
    $class_name = str_replace('\\', '/', $class_name);

    if (!@include_once $class_name . '.php'){
        throw new RouteException('Не верное имя файла для подключения - ' . $class_name);
    }
}

spl_autoload_register('autoloadMainClasses');
