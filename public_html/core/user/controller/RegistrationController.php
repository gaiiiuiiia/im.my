<?php


namespace core\user\controller;


class RegistrationController extends BaseUser
{
    protected function inputData(){
        $this->execBase();

        if (isset($_POST['registrationButton'])){
            $userData = $this->createUserData(['nameUser', 'email','password','passwordCheck']);

            //exit;
        }
    }

}