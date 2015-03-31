<?php

namespace PTSeries\Parser\Lostfilm;

use CLIFramework\Application;

class CLIApplication extends Application
{
    const NAME = 'pt-series/parser-lostfilm';
    const VERSION = '0.1';

    public function init()
    {
        $this->command('getSeries');
    }
}
