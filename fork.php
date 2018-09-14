<?php

$outFile = '/tmp/sites-' . bin2hex(random_bytes(4)) . '.txt';

$urlsAndWaits = [
    'https://cascadiaphp.com/speakers' => 3,
    'https://longhornphp.com' => 2,
    'https://php.net' => 1
];

$pids = [];

foreach ($urlsAndWaits as $url => $wait) {
    switch ($pid = pcntl_fork()) {
        case -1:
            echo "Failed to fork process responsible for getting url\n";
            break;
        case 0: // in child
            sleep($wait);
            $timer = microtime(true);
            $contents = file_get_contents($url);
            $fp = fopen($outFile, 'a');
            fwrite($fp, "Got $url in " . round(microtime(true) - $timer, 3) . " sec; length: " . strlen($contents) . "\n");
            fclose($fp);
            exit(0);
            break;
        default: // in parent
            echo "Forked process $pid to wait $wait seconds and then get $url\n";
            $pids[$url] = $pid;
            break;
    }
}

// in parent; processes have been forked
foreach ($pids as $url => $pid) {
    pcntl_waitpid($pid, $status);
    echo "Process $pid to get $url exited with status $status\n";
}

echo file_get_contents($outFile);