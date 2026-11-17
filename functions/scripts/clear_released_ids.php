<?php

/**
 * Removes saved subnet and IP address IDs (setting "Keep subnet and IP address IDs")
 * that were released more than N days ago. Subnets / addresses re-added after that get a new ID.
 *
 * Usage: php clear_released_ids.php <days>     (0 clears everything)
 * Cron example, daily at 03:00, keep one year:
 *   0 3 * * * php /path/to/phpipam/functions/scripts/clear_released_ids.php 365
 */

// script can only be run from cli
if (PHP_SAPI != 'cli') {
    exit('This script can only be run from cli!');
}

if (! isset($argv[1]) || ! ctype_digit($argv[1])) {
    exit("Usage: php {$argv[0]} <days>   (0 clears all saved subnet and address IDs)\n");
}
$days = (int) $argv[1];

// include required scripts
require_once __DIR__.'/../functions.php';

$Database = new Database_PDO;

$removed = [];
try {
    foreach (['subnets_released' => 'subnet', 'ipaddresses_released' => 'address'] as $table => $name) {
        $Database->runQuery('DELETE FROM `'.$table.'` WHERE `released` <= NOW() - INTERVAL ? DAY;', [$days], $count);
        $removed[] = "$count $name";
    }
} catch (Exception $exception) {
    exit('Error: '.$exception->getMessage()."\n");
}

print 'Removed '.implode(' and ', $removed)." IDs released more than $days days ago.\n";
