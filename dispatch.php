<?php
pcntl_signal(SIGHUP,  function($signo) {
             
});

posix_kill(posix_getpid(), SIGHUP);

echo "分发...\n";
echo "完成\n";

?>
