#!/usr/bin/env php

<?php

if ($argc < 4) {
    die("Usage: ./sleepAndWrite.php sleep_in_seconds filename output\n");
}

sleep($argv[1]);
error_log('Done sleeping. Writing contents to file.');
file_put_contents($argv[2], implode(' ', array_slice($argv, 3)));
