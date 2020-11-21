<?php


namespace core\base\controller;


trait BaseMethods
{


    protected function saveDataToSession($path, $dataToSave, &$targetArr = null){

        if (!$dataToSave) return;

        if (!is_array($targetArr)) $targetArr = &$_SESSION;

        if (is_string($path)){
            $path = explode('/', $path);

            if (count($path) == 1){
                if (is_array($dataToSave)){
                    foreach ($dataToSave as $item => $value){
                        $targetArr[$path[0]][$item] = $value;
                    }
                }else {
                    $targetArr[$path[0]] = $dataToSave;
                }
                return;
            }

            if (!array_key_exists($path[0], $targetArr)) $targetArr[$path[0]] = [];

            $targetArr = &$targetArr[$path[0]];
            unset($path[0]);

            return $this->saveDataToSession(implode('/', $path), $dataToSave, $targetArr);
        }
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