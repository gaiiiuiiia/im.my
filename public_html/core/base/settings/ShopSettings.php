<?php
// Файл настроек плагина

namespace core\base\settings;


class ShopSettings
{
    use BaseSettings;

    private $templateArr = [
        'text' => ['login', 'password', 'price'],
        'textarea' => ['goods_content'],
        'select' => ['sex_id', 'category_id'],
    ];

    private $routes = [
        'plugins' => [
            'dir' => false,
            'routes' => [

            ],
        ],
    ];

    private $translate = [
        'description' => ['Описание товара', 'Опишите данный товар, что в нем особенного (не более 160 символов)'],
        'sex_id' => ['Sex', 'К какой категории товаров отнести данный товар'],
        'category_id' => ['Категория товара', 'К какой категории товаров отнести данный товар'],
    ];

    private $translate2rus = 'core/user/translate/translate2rus';

}