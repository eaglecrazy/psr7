<?php

use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

$aggregator = new ConfigAggregator([
    new PhpFileProvider(__DIR__ . '/autoload/{{,*.}global,{,*.}local}.php'),
],
'var/config-cache.php');


//var_dump($aggregator->getMergedConfig()['doctrine']['cache']);

return $aggregator->getMergedConfig();