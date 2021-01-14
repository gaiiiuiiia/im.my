<?php

define('VG_ACCESS', true);  // константа безопасности

header('Content-Type:text/html;charset=utf-8');
session_start();

require_once 'config.php';
require_once 'core/base/settings/internal_settings.php';
require_once 'libraries/functions.php';

use core\base\exceptions\RouteException;
use core\base\controller\BaseRoute;
use core\base\exceptions\DbException;
use core\base\exceptions\UserException;

try{
    BaseRoute::routeDirection();
}
catch (RouteException $e){
    exit($e->getMessage());
}
catch (DbException $e){
    exit($e->getMessage());
}
catch (UserException $e){
    exit($e->getMessage());
}
