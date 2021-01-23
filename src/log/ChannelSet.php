<?php

declare (strict_types = 1);

namespace frame\log;

use frame\Log;

/**
 * Class ChannelSet
 * @package frame\log
 * @mixin Channel
 */
class ChannelSet
{
    protected $log;
    protected $channels;

    public function __construct(Log $log, array $channels)
    {
        $this->log      = $log;
        $this->channels = $channels;
    }

    public function __call($method, $arguments)
    {
        foreach ($this->channels as $channel) {
            $this->log->channel($channel)->{$method}(...$arguments);
        }
    }
}
