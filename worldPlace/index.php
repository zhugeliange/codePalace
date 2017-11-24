<?php
	/**
	 * parse xml to sql
	 */

$file = fopen('./LocList.xml', 'r');

$result = [];

for ($i=0; $i < 4; $i++) { 
	$country = $state = $city = $region = $place_code = '""';
	rewind($file);

	while (!feof($file)) {
		$column = fgets($file);

		if (strpos($column, 'CountryRegion Name')) {
			preg_match('/(Name="){1}.*(" Code){1}/u', $column, $matches);
			$country = '"' . preg_replace('/(Name)|(Code)|=|"|\s/u', '', $matches[0]) . '"';

			if ($i === 0) {
				preg_match('/(Code="){1}.*("){1}/u', $column, $matches);
				$place_code = '"' . preg_replace('/(Code)|=|"|\/|\s/u', '', $matches[0]) . '"';

				array_push($result, array('place_level' => 1, 'country' => $country, 'state' => $state, 'city' => $city, 'region' => $region, 'place_code' => $place_code));
			}
		}

		if (strpos($column, 'State Name') && $i > 0) {
			preg_match('/(Name="){1}.*(" Code){1}/u', $column, $matches);
			$state = '"' . preg_replace('/(Name)|(Code)|=|"|\s/u', '', $matches[0]) . '"';

			if ($i === 1) {
				preg_match('/(Code="){1}.*("){1}/u', $column, $matches);
				$place_code = '"' . preg_replace('/(Code)|=|"|\/|\s/u', '', $matches[0]) . '"';

				array_push($result, array('place_level' => 2, 'country' => $country, 'state' => $state, 'city' => $city, 'region' => $region, 'place_code' => $place_code));
			}
		}

		if (strpos($column, 'City Name') && $i > 1) {
			preg_match('/(Name="){1}.*(" Code){1}/u', $column, $matches);
			$city = '"' . preg_replace('/(Name)|(Code)|=|"|\s/u', '', $matches[0]) . '"';

			if ($i === 2) {
				preg_match('/(Code="){1}.*("){1}/u', $column, $matches);
				$place_code = '"' . preg_replace('/(Code)|=|"|\/|\s/u', '', $matches[0]) . '"';

				array_push($result, array('place_level' => 3, 'country' => $country, 'state' => $state, 'city' => $city, 'region' => $region, 'place_code' => $place_code));
			}
		}

		if (strpos($column, 'Region Name') && $i > 2) {
			preg_match('/(Name="){1}.*(" Code){1}/u', $column, $matches);
			$region = '"' . preg_replace('/(Name)|(Code)|=|"|\s/u', '', $matches[0]) . '"';

			if ($i === 3) {
				preg_match('/(Code="){1}.*("){1}/u', $column, $matches);
				$place_code = '"' . preg_replace('/(Code)|=|"|\/|\s/u', '', $matches[0]) . '"';

				array_push($result, array('place_level' => 4, 'country' => $country, 'state' => $state, 'city' => $city, 'region' => $region, 'place_code' => $place_code));
			}
		}
	}
}

fclose($file);

$item = [];

$sql = "INSERT INTO a_place (place_level, country, state, city, region, place_code) VALUES ";

foreach ($result as $key => $value) {
	$item[] = '(' . implode($value, ',') . ')';
}

$sql = $sql . implode($item, ',') . ';';

$file = fopen('./a_place.sql', 'w');

fwrite($file, $sql);

fclose($file);

exit('!!!!!!!!!');