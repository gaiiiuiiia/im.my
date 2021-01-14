<?php

namespace core\user\controller;


class IndexController extends BaseUser
{

    protected function inputData(){

        $this->execBase();

        $this->content = "HI I'm a IndexController \n";

        print_arr($_COOKIE);
        echo '<br>';
        print_arr($_SESSION);
    }

}
