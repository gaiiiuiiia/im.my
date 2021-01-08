<?php


namespace libraries;


class FileEdit
{

    protected $imgArr = [];
    protected $directory;

    public function addFile($directory = false){

        $this->directory = $directory ?: $_SERVER['DOCUMENT_ROOT'] . PATH . UPLOAD_DIR;

        foreach ($_FILES as $key => $file) {

            if (is_array($file['name'])){  // Множественное добавление файлов
                $file_arr = [];

                foreach ($file['name'] as  $i => $value){
                    if (!empty($file['name'][$i])){

                        foreach ($file as $field => $values){
                            $file_arr[$field] = $values[$i];
                        }

                        $file_name = $this->createFile($file_arr);

                        if ($file_name) $this->imgArr[$key][] = $file_name;
                    }
                }
            }
            else{ // Единичное добавление файла
                if ($file['name']){
                    $file_name = $this->createFile($file);

                    if ($file_name) $this->imgArr[$key] = $file_name;
                }
            }
        }
        return $this->getFiles();
    }

    protected function createFile($file){

        $fileNameArr = explode('.', $file['name']);
        $ext = $fileNameArr[count($fileNameArr) - 1];
        unset($fileNameArr[count($fileNameArr) - 1]);

        $fileName = implode('.', $fileNameArr);

        $fileName = (new TextModify())->translit($fileName);

        $fileName = $this->checkFile($fileName, $ext);

        $fileFullName = $this->directory . $fileName;

        if ($this->uploadFile($file['tmp_name'], $fileFullName)){
            return $fileName;
        }
        return false;
    }

    protected function uploadFile($tmpName, $destination){

        if (move_uploaded_file($tmpName, $destination)) return true;

        return false;
    }

    protected function checkFile($fileName, $ext, $fileLastName = ''){

        if (!file_exists($this->directory . $fileName . $fileLastName . '.' . $ext))
            return $fileName . $fileLastName . '.' . $ext;

        return $this->checkFile($fileName, $ext, '_' . hash('crc32', time() . mt_rand(1, 1000)));

    }

    public function getFiles(){
        return $this->imgArr;
    }

}