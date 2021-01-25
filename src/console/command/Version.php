<?php

declare (strict_types = 1);

namespace SeanPhp\console\command;

use SeanPhp\console\Command;
use SeanPhp\console\Input;
use SeanPhp\console\Output;

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
