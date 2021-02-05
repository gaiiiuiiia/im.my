<?php

namespace core\user\controller;

use core\base\model\UserModel;
use core\base\settings\ShopSettings;


class IndexController extends BaseUser
{

    protected $tableContent;
    protected $goodsByCategory;

    protected function inputData(){

        $this->execBase();

        $this->getDataFromTable('goods');

        $this->createGoodsByCategory();

        $translatedWords = include ShopSettings::get('translate2rus') . '.php';

    }

    protected function getDataFromTable($table){

        $this->tableContent = $this->model->get($table);

    }

    protected function createGoodsByCategory(){

        foreach($this->model->get('category') as $category)
            $categories[$category['id']] = $category['name'];

        if ($categories){

            foreach ($this->tableContent as $item){

                $this->goodsByCategory[$categories[$item['category_id']]][] = $item;

            }

        }

    }



}
