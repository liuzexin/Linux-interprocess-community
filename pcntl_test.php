<?php
//shared memory

$key = ftok(__FILE__, 'A');//get the key of this file

$needFork = 4;

$childArr = [];

$sharedCount = 1;//This variable can't be shared at all children process.So we need to use  shared-memory way to deal with this circumstance.

//The meaning of fork will get the same as parent process with variable, envoriment and so on. This situation is equal to copy the parent process, and then as individual to run.
for ($i = 0;$i < $needFork;$i++){
    $pid = pcntl_fork();

    if ($pid == -1){
        echo  "fork fail.";
    }elseif ($pid){
        echo "I'm parent" . PHP_EOL;
        pcntl_wait($status);//Prevent child process to be zoombie process.
    }else{
        $child[$pid] = 1;
        sleep(1);
        $sharedCount ++; //Diverse process get the same result : 2.
        echo "I'm child".PHP_EOL;
        break;//Warning:If not break, program may will to fork many children program.
    }
}

echo 'What i am' . $pid . $sharedCount . PHP_EOL;
