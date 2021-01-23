<?php

declare (strict_types = 1);

namespace frame\route\dispatch;

use frame\route\Dispatch;

/**
 * Response Dispatcher
 */
class Response extends Dispatch
{
    public function exec()
    {
        return $this->dispatch;
    }

}
