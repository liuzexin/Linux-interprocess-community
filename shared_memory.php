<?php
//shared memory

$key = ftok(__FILE__, 'A');//get the key of this file

$needFork = 4;

$sharedCount = 1;

$sharedMem = shm_attach($key);//get instance

$sharedKey = 123;

for ($i = 0;$i < $needFork;$i++){
    $pid = pcntl_fork();

    if ($pid == -1){
        echo  "fork fail.";
    }elseif ($pid){
        echo "I'm parent" . PHP_EOL;
        wirteToMem('ParentKey', 'ParentValue');
        pcntl_wait($status);
    }else{
        sleep(1);
        echo "I'm child".PHP_EOL;
        $data = readFromMem();
        var_dump($data);
        break;
    }
}

echo 'What i am' . $pid . $sharedCount . PHP_EOL;


function writeToMem($key, $value){
    //$sharedKey You can understand that the key is used to find value
    if(!shm_has_var($sharedMem, $sharedKey)){//If we get nothing,set it.
        $data = shm_put_var($sharedMem, $sharedKey, [$key => $value]);
    }
    return;
}

function readFromMem(){
    if (shm_has_var($sharedMem, $sharedKey)){
        $data = shm_get_var($sharedMem, $sharedKey);
    }
    return $data;
}
