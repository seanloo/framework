<?php

namespace SeanPhp\app;

use SeanPhp\Service as BaseService;

class Service extends BaseService
{
    public function register()
    {
        $this->app->middleware->unshift(MultiApp::class);

        $this->commands([
//            'build' => command\Build::class,
        ]);

        $this->app->bind([
            'SeanPhp\route\Url' => Url::class,
        ]);
    }
}
