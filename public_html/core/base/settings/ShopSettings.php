<?php
// Файл настроек плагина

namespace core\base\settings;


class ShopSettings
{

    use BaseSettings;

    private $templateArr = [
        'text' => [
            'price',
            'shop',
        ],
        'textarea' => [
            'goods_content',
        ],
    ];

    private $routes = [
        'plugins' => [
            'dir' => false,
            'routes' => [

            ],
        ],
    ];


}