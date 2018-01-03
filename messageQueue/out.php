<?php
// output messages from the queue
 
$redis = new Redis();
 
$redis->connect('127.0.0.1', 6379);
 
$password = '';
 
$redis->auth($password);
 
//list类型出队操作
 
$value = $redis->lpop('message_queue');
 
if($value) {
	echo 'value is --->' . $value;
} else {
	exit('output finished');
}