<?php

// NOTE: Requires php-zts and the pthreads extension (build from Dockerfile-pthreads!)
// adapted from https://github.com/krakjoe/pthreads/blob/master/examples/CallAnyFunction.php

class Caller extends Thread {

    /**
     * Provide a passthrough to call_user_func_array()
     *
     * @param callable $method
     * @param mixed ...$params
     */
    public function __construct(callable $method, ...$params)
    {
        $this->method = $method;
        $this->params = $params;
        $this->result = null;
        $this->joined = false;
    }

    /**
    * The smallest thread in the world
    **/
    public function run()
    {
        $this->result = ($this->method)(...$this->params);
    }

    /**
     * Static method to create your threads from functions ...
     * @param $method
     * @param array $params
     * @return Caller
     */
    public static function call($method, ...$params) : self
    {
        $thread = new Caller($method, ...$params);
        if ($thread->start()) {
            return $thread;
        }
    }

    /**
    * Do whatever, result stored in $this->result, don't try to join twice
    **/
    public function getResult()
    {
        if (!$this->joined) {
            $this->joined = true;
            $this->join();
        }

        return $this->result;
    }

    public function __toString()
    {
        return (string) $this->getResult();
    }

    private $method;
    private $params;
    private $result;
    private $joined;
}

echo "About to call two threads: one that waits 10 seconds and one that grabs the speaker list...";
$speakers = Caller::call('file_get_contents', 'https://www.cascadiaphp.com/speakers');
$sleeper = Caller::call(function($seconds) { sleep($seconds); }, 10);

echo "threads created. Let's wait a few seconds on the main thread...\n";
for ($i = 0; $i < 4; $i++) {
    usleep(500000);
    echo ". ";
}
echo "\n";

echo "Grabbing speaker thread result: ";
echo strlen($speakers) . ' bytes long: ' . substr($speakers, 0, 140) . "\n";

echo "Waiting for sleep to finish...";
$sleeper->getResult();
echo "done!\n";