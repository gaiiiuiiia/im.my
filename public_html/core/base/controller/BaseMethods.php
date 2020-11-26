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

    protected function deleteDataFromArray($path, &$array, &$__empty_dir = null){

        if (!$path || !is_array($array)) return false;

        if (is_string($path)) {

            if (!$__empty_dir)
                $__empty_dir = [$path, &$array];

            $__empty_dir[] = !(count($array) > 1);

            $path = explode('/', $path);

            if (count($path) === 1) {
                unset($array[$path[0]]);
                $this->deleteEmptyDir($__empty_dir);
                return true;
            }

            $next = array_shift($path);

            return $this->deleteDataFromArray(implode('/', $path),$array[$next], $__empty_dir);
        }
        return false;
    }

    private function deleteEmptyDir($empty_dir){

        $path = explode('/', array_shift($empty_dir));
        $array = array_shift($empty_dir);

        $empty_dirs = array_keys($empty_dir, true);
        $last = end($empty_dirs);

        $to_delete = implode('/', array_slice($path, 0, $last));

        $this->deleteDataFromArray($to_delete, $array);
    }

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