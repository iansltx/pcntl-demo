<?php

echo "The zombie (PID " . posix_getpid() .
    ") is sleeping. It'll die after 60 seconds, but if you hit Ctrl-C, it will wake up!\n";

// have to pass by reference below so signal handlers know when the zombie is awake
$isAwake = false;

pcntl_signal(SIGTERM, function() use (&$isAwake) { // normal "kill" command signal
    echo $isAwake ? " <thud>\n" : "You killed the zombie in its sleep.\n";
    exit(0); // without this exit, you'd have to send a kill -9 / SIGKILL to end this process
});

pcntl_signal(SIGALRM, function() use (&$isAwake) {
    echo $isAwake ? "INS!!!1! <dies>\n" : "The zombie died in its sleep.\n";
    exit(0);
});

pcntl_signal(SIGINT, function() use (&$isAwake) { // would normally exit the script...
    if ($isAwake) return;
    $isAwake = true; // ...but we're talking about a zombie here...
    echo "BR";
});

pcntl_alarm(60);
pcntl_async_signals(true);

sleep(120);
if ($isAwake) { // signals will interrupt the sleep above
    // we have to do this here rather than in the signal handler because once in a handler
    // you won't get additional signals...and we want to be able to kill the zombie with
    // SIGTERM rather than just SIGKILL
    while (true) {
        echo "A";
        usleep(250000);
    }
}
