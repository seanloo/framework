<?php

declare (strict_types = 1);

namespace frame\console\command;

use frame\console\Command;
use frame\console\Input;
use frame\console\Output;

class Version extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('version')
            ->setDescription('show system webui version');
    }

    protected function execute(Input $input, Output $output)
    {
        $output->writeln('v' . $this->app->version());
    }

}
