<?php

declare (strict_types = 1);

namespace SeanPhp\route\dispatch;

use SeanPhp\Response;
use SeanPhp\route\Dispatch;

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
