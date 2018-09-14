<?php

foreach ([
             [30, '/tmp/test1-nohup', "Hello universe"],
             [20, '/tmp/test2-nohup', "Hello world"],
             [10, '/tmp/test3-nohup', "Hello Portland"]
         ] as $i => [$seconds, $filename, $output]) {
    exec("nohup ./sleepAndWrite.php $seconds $filename $output >/dev/null 2>&1 &");
}

echo "Processes fired off; check in a few seconds to see whether the files are where they should be!\n";