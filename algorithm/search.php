<?php
$array = [1, 2, 3, 4, 5, 6, 7, 8, 9];

/**
 * 二分法查找 while方式
 * @param  array   $array  已排好序的目标数组
 * @param  integer $search 待查找的元素
 * @return mixed 成功返回找到的元素的位置，失败返回false
 */
function binWhileSearch ($array = array(), $search = 0)
{
	// 获取数组长度
    $large = count($array) - 1;

    // 初始化最小的值
    $small = 0;

    // 
    while ($small <= $large) {
    	//获取中间数（向下取整）
        $middle = floor(($small + $large) / 2);

        // 如果中间数刚好是要查找的就直接返回
        if ($array[$middle] == $search) {  
            return $middle;
        } else if ($array[$middle] < $search) {
        	//当中间数小于所查值时，则$middle左边的值都小于$search，此时要将$middle赋值给$small  
            $small = $middle + 1;  
        } else if ($array[$middle] > $search) {
        	//中间值大于所查值,则$middle右边的所有值都大于$search,此时要将$middle赋值给$large  
            $large = $middle - 1;  
        }  
    } 

    return false;  
}

/**
 * 二分法查找 递归方式
 * @param  array   $array  已排好序的目标数组
 * @param  integer $small  最小的值
 * @param  integer $large  最大的值
 * @param  integer $search 待查找的元素
 * @return mixed 成功返回找到的元素的位置，失败返回false
 */
function binRecursiveSearch ($array = array(), $small = 0, $large = 0, $search = 0)
{  
    if ($small <= $large) {
    	//获取中间数（向下取整）
        $middle = floor(($small + $large) / 2);
        // 如果中间数刚好是要查找的就直接返回
        if($array[$middle] == $search){  
            return $middle;  
        } else if ($array[$middle] < $search) {  
        	//当中间数小于所查值时，则$middle左边的值都小于$search，此时要将$middle赋值给$small 
            return binRecursiveSearch($array, $middle + 1, $large, $search);  
        } else if ($array[$middle] > $search) {  
        	//中间值大于所查值,则$middle右边的所有值都大于$search,此时要将$middle赋值给$large  
            return binRecursiveSearch($array, $small, $middle - 1, $search);  
        }  
    }

    return false;  
} 

echo "binWhileSearch:" . PHP_EOL;

print_r(binWhileSearch($array, 7));

echo PHP_EOL . "binRecursiveSearch:" . PHP_EOL;

print_r(binRecursiveSearch($array, 0, 9, 7));

exit;