<?php

echo "Wait ten seconds and check hithere.txt";
exec('nohup ./sleepAndWrite.php 10 hithere.txt hi there > /dev/null 2>&1 &');
