<?php


namespace frame\console\output\driver;

use frame\console\Output;

class Nothing
{

    public function __construct(Output $output)
    {
        // do nothing
    }

    public function write($messages, bool $newline = false, int $options = 0)
    {
        // do nothing
    }

    public function renderException(\Throwable $e)
    {
        // do nothing
    }
}
