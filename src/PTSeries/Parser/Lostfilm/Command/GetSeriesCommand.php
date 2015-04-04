<?php

namespace PTSeries\Parser\Lostfilm\Command;

use CLIFramework\Command;
use PTSeries\Parser\Lostfilm\LostfilmApi;

class GetSeriesCommand extends Command
{
    function execute()
    {
        $logger = $this->logger;

        $logger->info('execute');
        $logger->error('error');

//        $input = $this->ask('Please type something');


        $lostfilm = new LostfilmApi();


        var_dump($lostfilm->getSeries());
    }
}
