<?php

declare (strict_types = 1);

namespace frame\route\dispatch;

use frame\Response;
use frame\route\Dispatch;

/**
 * View Dispatcher
 */
class View extends Dispatch
{
    public function exec()
    {
        // 渲染模板输出
        return Response::create($this->dispatch, 'view')->assign($this->param);
    }
}
