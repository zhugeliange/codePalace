<?php
$file = file_get_contents('./industry.sql');

$data = explode(';', str_replace(PHP_EOL, '', $file));

foreach ($data as $key => $value) {
	$value = preg_replace("/insert into sys_dict_tree_data \(CODE, VALUE, ORDERNO, PARENTCODE\)values \(|\)/u", '', $value);
	
	if ($value) {
		$item = explode(',', $value);

		$level = preg_match("/^[A-Z]$/", trim($item[0], '\' ')) ? 1 : (preg_match("/^[A-Z]\d\d$/", trim($item[0], '\' ')) ? 2 : (preg_match("/^[A-Z]\d\d\d$/", trim($item[0], '\' ')) ? 3 : 4 ));

		$datas[] = array('level' => $level, 'code' => trim($item[0], '\' '), 'value' => $item[1], 'parent_code' => trim($item[3], '\' '));
	}
}

$result = $industry_one = $industry_two = $industry_three = [];

for ($i=0; $i < 4; $i++) {
	foreach ($datas as $key => $value) {
		if ($value['level'] == 1 && $i == 0) {
			$result[] = array('industry_level' => $value['level'], 'industry_one' => $value['value'], 'industry_two' => "''", 'industry_three' => "''", 'industry_four' => "''", 'industry_code' => "'" . $value['code'] . "'");

			$industry_one[$value['code']] = $value['value'];
		} else if ($value['level'] == 2 && $i == 1) {
			$result[] = array('industry_level' => $value['level'], 'industry_one' => $industry_one[$value['parent_code']], 'industry_two' => $value['value'], 'industry_three' => "''", 'industry_four' => "''", 'industry_code' => "'" . $value['code'] . "'");

			$industry_two[$value['code']] = array('one' => $industry_one[$value['parent_code']], 'two' => $value['value']);
		} else if ($value['level'] == 3 && $i == 2) {
			$result[] = array('industry_level' => $value['level'], 'industry_one' => $industry_two[$value['parent_code']]['one'], 'industry_two' => $industry_two[$value['parent_code']]['two'], 'industry_three' => $value['value'], 'industry_four' => "''", 'industry_code' => "'" . $value['code'] . "'");

			$industry_three[$value['code']] = array('one' => $industry_two[$value['parent_code']]['one'], 'two' => $industry_two[$value['parent_code']]['two'], 'three' => $value['value']);
		} else if ($value['level'] == 4 && $i == 3) {
			$result[] = array('industry_level' => $value['level'], 'industry_one' => $industry_three[$value['parent_code']]['one'], 'industry_two' => $industry_three[$value['parent_code']]['two'], 'industry_three' => $industry_three[$value['parent_code']]['three'], 'industry_four' => $value['value'], 'industry_code' => "'" . $value['code'] . "'");
		}
	}
}

$results = [];

$sql = "INSERT INTO a_industry (industry_level, industry_one, industry_two, industry_three, industry_four, industry_code) VALUES ";

foreach ($result as $key => $value) {
	$results[] = '(' . implode($value, ',') . ')';
}

$sql = $sql . implode($results, ',') . ';';

$file = fopen('./a_industry.sql', 'w');

fwrite($file, $sql);

fclose($file);

exit('!!!!!!!!!');