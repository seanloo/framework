<?php

namespace frame\app;

use frame\Service as BaseService;

class Service extends BaseService
{
    public function register()
    {
        $this->app->middleware->unshift(MultiApp::class);

        $this->commands([
//            'build' => command\Build::class,
        ]);

        $this->app->bind([
            'frame\route\Url' => Url::class,
        ]);
    }
}
