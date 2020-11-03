<?php
	function getGeoData($keyword, $language) {
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$keyword.'&key=AIzaSyD0ap59oM9qMkW1ksjBRprY4-hN3HR7GHQ&language='.$language;
		$json = file_get_contents($url);
		$data = json_decode($json);
		return $data;
	}

	function parseCountryProvince($city, $language, $flag) {
		$components = $city->address_components;
		$country = '';
		$province = '';
		foreach ($components as $component) {
			if (in_array('country', $component->types)) {
				$country = $component->long_name;
			} else if (in_array('administrative_area_level_1', $component->types)) {
				$province = $component->long_name;
			}
		}
		// if empty, retry with formatted address
		if ($flag && $country == '' && $city->formatted_address != '') {
			$data = getGeoData($city->formatted_address, $language);
			if ($data->status === 'OK' && count($data->results) > 0) {
				return parseCountryProvince($data->results[0], $language, false);
			}
		}
		// special handle for China
		if ($country == '台湾') {
			$country = '中国';
			$province = '台湾省';
		} else if ($country == '香港') {
			$country = '中国';
			$province = '香港特别行政区';
		} else if ($country == '澳门') {
			$country = '中国';
			$province = '澳门特别行政区';
		}
		return array($country, $province);
	}

	function getResult($keyword, $language) {
		$result = array();
		$data = getGeoData($keyword, $language);
		if ($data->status === 'OK') {
			foreach ($data->results as $city) {
				$formatted_address = $city->formatted_address;
				$lat = $city->geometry->location->lat;
				$lng = $city->geometry->location->lng;

				$parsed = parseCountryProvince($city, $language, true);
				$country = $parsed[0];
				$province = $parsed[1];

				$result[] = array('formatted_address'=>$formatted_address, 'lat'=>$lat, 'lng'=>$lng, 
					'country'=>$country, 'province'=>$province);
			}
		}
		return $result;
	}

	$result = array();
	if (isset($_GET['keyword']) && $_GET['keyword'] !== '') {
		$result = getResult($_GET['keyword'], 'zh-CN');
		if (count($result) > 0 && $result[0]['country'] == '日本') {
			$result = getResult($_GET['keyword'], 'ja');
		}
	}
	header('Content-Type: application/json; charset=UTF-8');
	header('Access-Control-Allow-Origin: *');
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>