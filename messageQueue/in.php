<?php
// input messages to the queue

$redis = new Redis();

$redis->connect('127.0.0.1', 6379);

$password = '';

$redis->auth($password);

$array = [1, 2, 3, 4, 5, 6, 7];

foreach($array as $key => $value) {
	$redis->rpush("message_queue", $value);
}

exit('input finished');