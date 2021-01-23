<?php

declare (strict_types = 1);

namespace frame\route\dispatch;

use frame\Response;
use frame\route\Dispatch;

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
