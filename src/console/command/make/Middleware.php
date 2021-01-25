<?php


namespace SeanPhp\console\command\make;

use SeanPhp\console\command\Make;

class Middleware extends Make
{
    protected $type = "Middleware";

    protected function configure()
    {
        parent::configure();
        $this->setName('make:middleware')
            ->setDescription('Create a new middleware class');
    }

    protected function getStub(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'middleware.stub';
    }

    protected function getNamespace(string $app): string
    {
        return 'app\\middleware';
    }
}
