<?php

declare (strict_types = 1);

namespace frame\initializer;

use frame\App;
use frame\service\ValidateService;
use frame\service\ModelService;
use frame\service\PaginatorService;
/**
 * 注册系统服务
 */
class RegisterService
{

    protected $services = [
        ModelService::class,
        ValidateService::class,
        PaginatorService::class,
    ];

    public function init(App $app)
    {
        $file = $app->getRootPath() . 'vendor/services.php';

        $services = $this->services;

        if (is_file($file)) {
            $services = array_merge($services, include $file);
        }

        foreach ($services as $service) {
            if (class_exists($service)) {
                $app->register($service);
            }
        }
    }
}
