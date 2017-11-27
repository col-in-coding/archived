<?php

require_once('Log.php');

$log = new Log();
// $log->write('Log.txt', "My name is Colin");
echo $log->read('Log.txt');