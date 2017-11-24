<?php
/**
 * 爬虫 
 * 用基本的 stream_get_contents 方法处理
 */

/**
 * 从给定的 url 获取 html 内容
 * @param  string $url 目标 url
 * @return string 获取的 html 内容
 */
function getUrlContent($url) {
	if (!$url) exit('input url not exist!!!');

    $handle = fopen($url, "r"); // 访问 url

    if ($handle) {
        $content = stream_get_contents($handle, -1); // 读取资源流到一个字符串,第二个参数需要读取的最大的字节数。默认是-1（读取全部的缓冲数据）
        // $content = file_get_contents($url, 1024 * 1024);
        return $content;
    } else {
        return false;
    } 
} 

/**
 * 利用正则表达式从 html 内容中筛选出链接
 * @param string $content 之前获取的 html 内容
 * @return array 符合筛选条件的数组
 */
function filterUrl($content) {
	if (!$content) exit('html content not exist!!!');

    $pattern = '/<[a|A].*?href=[\'\"]{0,1}([^>\'\"\ ]*).*?>/';

    if (preg_match_all($pattern, $content, $matches)) {
        return $matches[1];
    }
}

/**
 * 对已经获取到的链接进行处理，如果是相对路径就进行修正
 * @param string $base_url 完整 url 的公用头部
 * @param array $url_list 待处理的 url 数组
 * @return array 处理后的链接数组
 */
function reviseUrl($base_url, $url_list) {
	if (!$base_url || !$url_list || !is_array($url_list)) exit('improve url not exist!!!');

    $url_info = parse_url($base_url); // 解析 url
    $base_url = $url_info["scheme"] . '://';

    if (isset($url_info["user"]) && isset($url_info["pass"])) {
        $base_url .= $url_info["user"] . ":" . $url_info["pass"] . "@";
    }

    $base_url .= $url_info["host"];

    if (isset($url_info["port"])) {
        $base_url .= ":" . $url_info["port"];
    }

    $base_url .= $url_info["path"];

    $result = '';

    foreach ($url_list as $url_item) {
        if (preg_match('/^http/', $url_item) || preg_match('/^https/', $url_item)) {
            // 已经是完整的 url
            $result .= "\t" . $url_item;
        } else {
            // 相对路径
            $result .= "\t" . $base_url . '/' . $url_item;
        } 
    } 

    return $result;
} 

/**
 * 执行主程序
 * @param string $url 目标 url
 * @return array 处理后的最终链接数组
 */
function crawler($url) {
	if (!$url) exit('input url not exist!!!');

    $content = getUrlContent($url); // 从给定的 url 获取 html 内容

    print_r(filterUrl($content));
    exit('!!!');

    if ($content) {
        $url_list = reviseUrl($url, filterUrl($content)); // 从 html 内容筛选并处理出链接

        if ($url_list) {
            return $url_list;
        }
    }

    return false;
} 

/**
 * 测试用主程序
 */
function main() {
    $input_url_list = "input_url_list.txt"; // 将待处理的 url 全部放在一个文件中处理，以换行分割
    $output_link_list = "output_link_list.txt"; // 将得到的 url 以文件的形式保存在本地
    // $input_url_list = "https://www.baidu.com/";
    
    if (!file_exists($input_url_list)) exit('input file not exist!!!');

    $input = explode(PHP_EOL, file_get_contents($input_url_list)); // 一行一个 url 读入数组

    $result = '';

    foreach ($input as $key => $value) {
    	$result .= PHP_EOL . $value . " : " . PHP_EOL . crawler($value) . PHP_EOL;
    }

    fopen($output_link_list, 'ab'); // 将得到的结果以文件的形式保存在本地

    // fclose($output_link_list); // 存完数据就把文件关闭
} 

echo "crawler start!" . PHP_EOL;

main();

echo "crawler end!" . PHP_EOL;
