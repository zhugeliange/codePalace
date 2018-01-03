<?php
/**
* urlencode
**/
echo 'urlencode: ' . PHP_EOL;
var_dump(urlencode('http://www.baidu.com')); // 编码url字符串，此字符串中除了 -_. 之外的所有非字母数字字符都将被替换成百分号（%）后跟两位十六进制数，空格则编码为加号（+）。此编码与 WWW 表单 POST 数据的编码方式是一样的，同时与 application/x-www-form-urlencoded 的媒体类型编码方式一样。与其对应的逆向解密函数为urldecode
var_dump(htmlspecialchars('<a href="test"\>Test</a\>')); // 将特殊字符转换为 HTML 实体，与其对应的逆向解密函数为htmlspecialchars_decode。不够用的话用htmlentities，会把所有具有 HTML 实体的字符都转换了。

/**
* base64_encode
**/
echo 'base64_encode: ' . PHP_EOL;
var_dump(base64_encode('password string.')); // 使用 MIME base64 对数据进行编码，设计此种编码是为了使二进制数据可以通过非纯 8-bit 的传输层传输，例如电子邮件的主体。
// Base64-encoded 数据要比原始数据多占用 33% 左右的空间。与其对应的逆向解密函数为base64_decode
