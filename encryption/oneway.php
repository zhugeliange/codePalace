<?php
/**
* md5
**/
echo 'md5: ' . PHP_EOL;
var_dump(md5('password string.')); // 32 byte
var_dump(md5('password string.', TRUE)); // 16 byte （默认是16byte的原始二进制格式，会显示乱码，解决方案如下）
var_dump(substr(md5('password string.'), 8, 16)); // 16byte乱码解决方案：32byte时的第8到24位之间的内容和16byte情况下的值是一样的，可以截取下就行

/**
* sha1
**/
echo 'sha1: ' . PHP_EOL;
var_dump(sha1('password string.')); // 40byte
var_dump(sha1('password string.', TRUE)); // 20byte （默认是16byte的原始二进制格式，会显示乱码，解决方案如下）
var_dump(substr(md5('password string.'), 8, 16)); // 20byte乱码解决方案：40byte时的第10到30位之间的内容和20byte情况下的值是一样的，可以截取下就行

/**
* hash
**/
echo 'hash: ' . PHP_EOL;
var_dump(hash('sha512', 'password string.')); // hash支持多种哈希算法，这里演示‘sha512’方式。512bit，即128byte
var_dump(hash('sha512', 'password string.', TRUE)); // 还支持第三个参数用于输出截取后的原始二进制值，不同算法长度不同

/**
* crypt
**/
echo 'crypt: ' . PHP_EOL;
var_dump(crypt('password string.')); // 默认创建出来的是弱密码，即没有加盐则会有不同的算法自动提供，php5.6及之后的版本会报个提示
var_dump(crypt('password string.', '$1$rasmusle$')); // 加的盐值也应该设置一定的复杂度，并且由于不同系统使用的算法不一致所以可能会导致得到的结果也不一致，可以用默认的crypt来生成盐值
var_dump(hash_equals(crypt('password string.'), crypt('password string.', crypt('password string.')))); 
// 这里用默认的crypt来生成盐值，这样就避免了不同算法的问题
// hash_equals比较两个字符串，无论它们是否相等，本函数的时间消耗是恒定的。这里就可以专门用来crypt函数的时序攻击
// 这里再科普一下时序攻击：一句话就是通常比较密码时计算机从头开始按位逐次比较遇见不同就返回false，因为计算速度是一定的，
// 那么等于说可以根据这个计算时间来推断大概多少位的时候开始不一样了，这样就大大降低了破译密码的难度了

/**
* password_hash
**/
echo 'password_hash: ' . PHP_EOL;
var_dump(password_hash('password string.', PASSWORD_DEFAULT)); 
// password_hash是crypt的一个简单封装，并且完全与现有的密码哈希兼容，所以推荐使用
// 第二个参数指明用什么算法，目前支持：PASSWORD_DEFAULT和PASSWORD_BCRYPT，通常使用前者，目前是60个字符，但是以后可能会增加，所以数据库可以设置成255个字符比较稳妥，后者生成长度为60的兼容使用 "$2y$" 的crypt的字符串
// 第三个参数是加盐，php7之后已经废除了，因为默认会给出一个高强度的盐值
var_dump(password_verify('password string.', password_hash('password string.', PASSWORD_DEFAULT))); // password_verify是专门用来比较用password_hash生成的密码的，可以防止时序攻击，可以参考hash_equals之于crypt
