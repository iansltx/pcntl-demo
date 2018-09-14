<?php

use Symfony\Component\Process\Process;

require 'vendor/autoload.php';

/** @var Process[] $processes */
$processes = [];

foreach ([
    [3, '/tmp/test1', "Hello universe\n"],
    [2, '/tmp/test2', "Hello world\n"],
    [1, '/tmp/test3', "Hello Portland\n"]
         ] as $i => [$seconds, $filename, $output]) {
    $process = new Process(['./sleepAndWrite.php', $seconds, $filename, $output]);
    $process->start(function($type, $output) use ($i) {
        echo "Got output of type $type from process $i: $output";
    });
    $processes[] = $process;
}

foreach (array_reverse($processes) as $i => $process) {
    $process->wait();
    echo "Process $i complete\n";
}