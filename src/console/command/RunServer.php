<?php

declare (strict_types = 1);

namespace SeanPhp\console\command;

use SeanPhp\console\Command;
use SeanPhp\console\Input;
use SeanPhp\console\input\Option;
use SeanPhp\console\Output;

class RunServer extends Command
{
    public function configure()
    {
        $this->setName('run')
            ->addOption(
                'host',
                'H',
                Option::VALUE_OPTIONAL,
                'The host to server the application on',
                '0.0.0.0'
            )
            ->addOption(
                'port',
                'p',
                Option::VALUE_OPTIONAL,
                'The port to server the application on',
                8000
            )
            ->addOption(
                'root',
                'r',
                Option::VALUE_OPTIONAL,
                'The document root of the application',
                ''
            )
            ->setDescription('PHP Built-in Server for System');
    }

    public function execute(Input $input, Output $output)
    {
        $host = $input->getOption('host');
        $port = $input->getOption('port');
        $root = $input->getOption('root');
        if (empty($root)) {
            $root = $this->app->getPublicPath();
        }

        $phpSbin = ($this->app->mode() == 'npv') ? '/usr/local/webserver/sbin/php' : 'php';

        $command = sprintf(
            $phpSbin.' -S %s:%d -t %s %s',
            $host,
            $port,
            escapeshellarg($root),
            escapeshellarg($root . DIRECTORY_SEPARATOR . 'router.php')
        );

        $output->writeln(sprintf('Development server is started On <http://%s:%s/>', '0.0.0.0' == $host ? '127.0.0.1' : $host, $port));
        $output->writeln(sprintf('You can exit with <info>`CTRL-C`</info>'));
        $output->writeln(sprintf('Document root is: %s', $root));
        passthru($command);
    }

}
