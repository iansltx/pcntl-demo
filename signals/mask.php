<?php

pcntl_async_signals(true);
pcntl_signal(SIGINT, function() { echo "Caught Ctrl-C; exiting...\n"; die(); });

echo "Blocking Ctrl-C because we're doing something important for the next 10 seconds...\n";
pcntl_sigprocmask(SIG_BLOCK, [SIGINT]);
sleep(10);
echo "Done!\n";
pcntl_sigprocmask(SIG_UNBLOCK, [SIGINT]);
echo "Sleeping for another 10 seconds or until Ctrl-C is pressed, whichever comes first.\n";
sleep(10);
