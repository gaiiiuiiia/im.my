<?php


namespace core\admin\controller;


use core\base\controller\BaseController;
use core\admin\model\Model;

class IndexController extends BaseController
{

    protected function inputData(){

        $db = Model::instance();

        $table = 'teachers';

        $files['gallery_img'] = ["new_red.jpg"];
        $files['img'] = 'main_img. jpg';

        $_POST['id'] = 4;
        $_POST['name'] = 'Ivan';
        $_POST['content'] = 'Some Text';

        $res = $db->edit($table);

        exit('Iam admin panel');
    }
}