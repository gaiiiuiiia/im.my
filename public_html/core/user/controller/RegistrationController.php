<?php


namespace core\user\controller;


class RegistrationController extends BaseUser
{
    protected function inputData(){

        if (isset($_POST['registrationButton'])){
            exit;
        }
    }

}