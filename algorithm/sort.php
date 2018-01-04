<?php

$array = [3, 1, 4, 1, 5, 9, 2, 6, 5, 4];

/**
 * 冒泡排序 两两比较，大的下沉排后面，小的上浮排前面，递归总数减一次即可全部排好了，顾名思义冒泡泡呗。。。
 * @param  array  $array 
 * @return array
 */
function bubbleSort($array = array())
{
	$length = count($array);

	// 外层循环总长度减一次
    for($i = 1; $i < $length; $i++) {
    	// 内层遍历整个数组，这里不用foreach这些php封装的函数，因为这样就不局限于语言了
    	for ($j = 0; $j < ($length - $i); $j++) {
    		// 两两比较，当前者大于后者时上浮，即交换位置
    		if ($array[$j] > $array[$j + 1]) {
        		$temp = $array[$j];
        		$array[$j] = $array[$j + 1];
        		$array[$j + 1] = $temp;
        	}
    	}
    }

    return $array;
}

/**
 * 选择排序 每次选择一个最小的排到最前面，递归总数减一次即可全部依次排好了。
 * @param  array  $array
 * @return array
 */
function selectSort($array = array())
{
	$length = count($array);

	// 外层循环总长度减一次
    for($i = 0; $i < ($length - 1); $i++) {
    	// 初始化一个最小值暂存起来
    	$k = $i;

    	// 内层遍历数组除了刚刚已经选取的最小值的其他部分，这里实际上可以用php自带的min函数来直接取出最小值，不过还是像上面说的，不要局限于语言
    	for ($j = ($i + 1); $j < $length; $j++) {
    		// 将剩下的数与刚刚初始化的最小值一一进行比较，如果有更小的就替换，这里只是暂存
    		if ($array[$k] > $array[$j]) {
    			$k = $j;
    		}
    	}

    	// 如果刚刚的一次遍历已经用最小的$j替换掉初始化的$i了，即$i!=$j，那么就替换掉
    	if ($i != $k) {
    		$temp = $array[$k];
    		$array[$k] = $array[$i];
    		$array[$i] = $temp;
    	}
    }

    return $array;
}

/**
 * 插入排序 就是先假设前面除最后一个元素之外都已经排好了，然后用这最后一个和前面一一去比较，小就往前排，递归总数减一次即可全部依次排好了。
 * @param  array  $array
 * @return array
 */
function insertSort($array = array())
{
	$length = count($array);

	// 外层循环总长度减一次
    for($i = 0; $i < $length; $i++) {
    	// 取最后一个元素往前面插，这里就不要用array_pop()之类的函数了，一来性能肯定是会慢点，二来还是不要被语言限制了
    	$temp = $array[$i];

    	// 内层遍历除最后一个元素之外的部分
    	for ($j = ($i - 1); $j > -1; $j--) {
    		// 依次与刚刚选取的最后一个元素比较，小就往前排
    		if ($temp < $array[$j]) {
    			// 其它向后挪一位
    			$array[$j + 1] = $array[$j];
    			// 刚刚的$temp插进来
    			$array[$j] = $temp;
    		} else {
	    		// 如果不需要移动就表示已经全部排好了
	    		break;
    		}
    	}
    }

    return $array;
}

/**
 * 快速排序 先随便选一个基准元素，通常是第一个元素，然后与剩下的比较，小的放基准的左边，大的就放基准的右边，反复调用。这个方法最大的好处就是可以并行执行，所以速度很快。
 * @param  array  $array
 * @return array
 */
function quickSort($array = array())
{
	// 如果已经分到最底层了就直接返回
	if (!isset($array[1])) {
		return $array;
	}

	// 选取第一个元素为基准，并删除之，否则内存就炸了。。。
	$base = array_shift($array);

	// 初始化两个数组分别用于存放小于和大于基准的
	$array_left = $array_right = [];

	// 分别遍历这两个数组
	foreach ($array as $value) {
		// 如果小于基准就放入$array_left数组，否则放入$array_right数组
		if ($value < $base) {
			$array_left[] = $value;
		} else {
			$array_right[] = $value;
		}
	}

	// 合并并递归调用，注意顺序不能错了，left和right互换就成从大到小排序了
	return array_merge(quickSort($array_left), array($base), quickSort($array_right));
}

// 上面各种判断过滤我都没加，主要是在于逻辑，另外我是用for来控制循环次数的，实际上也可以用递归来实现，这样代码看起来就会精炼多了，不过不太利于阅读，这个具体就见仁见智了啊。

echo "bubbleSort:" . PHP_EOL;

print_r(bubbleSort($array));

echo "selectSort:" . PHP_EOL;

print_r(selectSort($array));

echo "insertSort:" . PHP_EOL;

print_r(insertSort($array));

echo "quickSort:" . PHP_EOL;

print_r(quickSort($array));

exit;