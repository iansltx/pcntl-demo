<?php

/**
 * Required to not hang on SIGCONT, but function body won't be executed if
 * we block when waiting on the signal. But if we're blocking waiting on
 * signals, we don't need to listen for signals otherwise, hence the
 * lack of declaring ticks, dispatching signals manually, or asking the
 * system to dispatch asynchronously.
 */
pcntl_signal(SIGCONT, function() { echo "This will never run!\n"; });

echo "PID: " . posix_getpid() . "\n";

if (!function_exists('pcntl_sigtimedwait')) {
    echo "This OS doesn't support pcntl_sigtimedwait :(\n";
} else {
    echo "Waiting for SIGCONT, for up to 5.12 seconds...";
    $signal = pcntl_sigtimedwait([SIGCONT], $sigInfo, 5, 120 * (1000 ** 2));
    echo "Got signal " . $signal . " with info " . json_encode($sigInfo) . "!\n";
}

if (!function_exists('pcntl_sigwaitinfo')) {
    echo "This OS doesn't support pcntl_sigwaitinfo :(\n";
} else {
    echo "Waiting for a SIGCONT...";
    $signal = pcntl_sigwaitinfo([SIGCONT], $sigInfo); // second param doesn't need 7.1!
    echo "Got signal " . $signal . " with info " . json_encode($sigInfo) . "!\n";
}
