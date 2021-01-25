<?php

declare (strict_types = 1);

namespace SeanPhp\initializer;

use SeanPhp\App;
use SeanPhp\service\ValidateService;
use SeanPhp\service\ModelService;
use SeanPhp\service\PaginatorService;
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
