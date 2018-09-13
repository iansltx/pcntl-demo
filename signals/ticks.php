<?php

echo "PID: " . posix_getpid() . "\n";

pcntl_signal(SIGINT, function(int $signal) {
    error_log('Got signal ' . $signal . "; And if you want some fun sing obladi blada");
    exit();
});

$lyrics = ['Obladi', 'oblada', 'life goes on', 'bra', 'la la how the life goes on'];

declare(ticks = 1); // available since 4.3.0...probably don't want to use this though
for ($i = 0;; $i++) {
    echo $lyrics[$i % count($lyrics)] . "\n";
    usleep(500000);
}
