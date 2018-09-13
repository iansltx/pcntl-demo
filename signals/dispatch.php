<?php

echo "PID: " . posix_getpid() . "\n";

class SignalHandler
{
    protected $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function __invoke(int $signal)
    {
        error_log('Got signal ' . $signal . '; ' . $this->message);
        exit();
    }
}

pcntl_signal(SIGINT, new SignalHandler('And if you want some fun sing obladi blada'));

$lyrics = ['Obladi', 'oblada', 'life goes on', 'bra', 'la la how the life goes on'];

for ($i = 0;; $i++) {
    echo $lyrics[$i % count($lyrics)] . "\n";
    usleep(500000);
    if ($i % 5 == 4) {
        pcntl_signal_dispatch(); // since 5.3
    }
}
