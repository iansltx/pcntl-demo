<?php
pcntl_signal(SIGALRM, function(int $signal) {
    echo "Alarm time!\n";
    for ($i = 0; $i < 8; $i++) {
        echo chr(7); usleep(250000);
    }
});

if ($argc < 2 || !is_numeric($argv[1])) {
    die("Usage: alarm.php time_until_alarm_in_seconds\n");
}

echo "Setting alarm for " . $argv[1] . " seconds from now...\n";

pcntl_async_signals(true);
pcntl_alarm($argv[1]);
sleep(900); // will get cut short by the alarm
