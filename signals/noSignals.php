<?php

echo "PID: " . posix_getpid() . "\n";

$lyrics = ['Obladi', 'oblada', 'life goes on', 'bra', 'la la how the life goes on'];

for ($i = 0;; $i++) {
    echo $lyrics[$i % count($lyrics)] . "\n";
    usleep(500000);
}
