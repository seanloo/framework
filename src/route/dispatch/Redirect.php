<?php

declare (strict_types = 1);

namespace SeanPhp\route\dispatch;

use SeanPhp\Response;
use SeanPhp\route\Dispatch;

/**
 * Redirect Dispatcher
 */
class Redirect extends Dispatch
{
    public function exec()
    {
        return Response::create($this->dispatch, 'redirect')->code($this->code);
    }
}
