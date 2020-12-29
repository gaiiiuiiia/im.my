<?php

namespace core\user\controller;

use core\admin\model\Model;
use core\base\controller\BaseController;

class IndexController extends BaseController
{

    protected function inputData(){


        $model = Model::instance();

        $res = $model->get('goods', [
            'where' => ['id' => '1,2'],
            'operand' => ['IN'],
            'join' => [
                'goods_filters' => ['on' => ['id', 'teachers']],
                'filters' => [
                    'fields' => ['name as student_name'],
                    'on' => ['students', 'id']
                ],
            ],
            'join_structure' => true,
        ]);

        exit();

    }

}
