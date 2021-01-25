<?php

declare (strict_types = 1);

namespace SeanPhp\route\dispatch;

use SeanPhp\route\Dispatch;

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
