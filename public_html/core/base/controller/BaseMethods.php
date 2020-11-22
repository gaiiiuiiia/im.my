<?php


namespace core\base\controller;


trait BaseMethods
{


    protected function saveDataToArray($path, $dataToSave, &$targetArr){

        if (!$dataToSave || !is_array($targetArr)) return false;

        if (is_string($path)){
            $path = explode('/', $path);

            if (count($path) === 1){
                if (is_array($dataToSave)){
                    foreach ($dataToSave as $item => $value){
                        $targetArr[$path[0]][$item] = $value;
                    }
                }else {
                    $targetArr[$path[0]] = $dataToSave;
                }
                return true;
            }

            if (!array_key_exists($path[0], $targetArr)) $targetArr[$path[0]] = [];

            $next = array_shift($path);

            return $this->saveDataToArray(implode('/', $path), $dataToSave, $targetArr[$next]);
        }
        return false;
    }

    protected function getDataFromArray($path, &$array){

        if (!$path || !is_array($array)) return null;

        if (is_string($path)){

            $path = explode('/', $path);

            if (count($path) === 1){
                return $array[$path[0]];
            }

            $next = array_shift($path);

            if (!isset($array[$next])) return false;

            return $this->getDataFromArray(implode('/', $path),$array[$next]);
        }
        return false;
    }

    protected function deleteDataFromArray($path, &$array){

        if (!$path || !is_array($array)) return false;

        /*if (!$__array && !$__path) {
            $__array = &$array;
            $__path = $path;
        }*/

        if (is_string($path)) {

            $path = explode('/', $path);

            if (count($path) === 1) {
                unset($array[$path[0]]);
                //$this->deleteEmptyDir($__path, $__array);
                return true;
            }

            $next = array_shift($path);

            return $this->deleteDataFromArray(implode('/', $path),$array[$next]);
        }
        return false;
    }

    /*private function deleteEmptyDir($path, &$array){

        $path = explode('/', $path);

        if (count($path) === 1)

        $new_array = array_filter($targetArr, function($element) {
            return !empty($element);
        });

    }*/

    protected function clearStr($str){

        // очистка от лишних тегов html, php, js
        if (is_array($str)) {
            foreach ($str as $key => $item) {
                $str[$key] = trim(strip_tags($item));
            }
            return $str;
        }

        return trim(strip_tags($str));
    }

    protected function clearNum($num){
        return $num * 1;
    }

    protected function isPost(){
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    protected function isAjax(){
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

    }

    protected function redirect($http = false, $code = false){

        if ($code){
            $codes = [
                '301' => 'HTTP/1.1 301 Move Permanently',
            ];
            if ($codes[$code]){
                header($codes[$code]);
            }
        }

        if ($http){
            $redirect = $http;
        }
        else {
            $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
        }

        header("Location: $redirect");

        exit;
    }

    protected function writeLog($message, $file = 'log.txt', $event = 'Fault'){

        $dateTime = new \DateTime();

        $str = $event . ': ' . $dateTime->format('d-m-Y G:i:s') . ' - ' . $message . "\r\n";

        file_put_contents('log/' . $file, $str, FILE_APPEND);

    }

}