<?php

namespace core\user\controller;

use core\base\controller\BaseController;

class IndexController extends BaseUser
{

    protected function inputData(){

        $this->execBase();

        return ['content_' => 'some_content_part'];

        // могу венуть массив с данными. и получить к ним доступ в будущем!


    }

}
