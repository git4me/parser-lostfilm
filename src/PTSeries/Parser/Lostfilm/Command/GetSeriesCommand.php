<?php

namespace PTSeries\Parser\Lostfilm\Command;

use CLIFramework\Command;

class GetSeriesCommand extends Command
{
    function execute()
    {
        $logger = $this->logger;

        $logger->info('execute');
        $logger->error('error');

        $input = $this->ask('Please type something');

    }
}
