<?php
	function getGeoData($keyword) {
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$keyword.'&key=AIzaSyD0ap59oM9qMkW1ksjBRprY4-hN3HR7GHQ&language=zh-CN';
		$json = file_get_contents($url);
		$data = json_decode($json);
		return $data;
	}

	function getProvince($components, $flag) {
		$size = count($components);

		if ($size <= 0) return '';
		if ($components[$size-1]->long_name !== '中国') {
			$size--;
		}
		if ($size >= 2 && $components[$size-1]->long_name === '中国') {
			if ($components[$size-2]->types[0] === 'administrative_area_level_1') {
				return $components[$size-2]->long_name;
			} else if ($flag) {
				$data = getGeoData($components[$size-2]->long_name);
				if ($data->status === 'OK' && count($data->results) > 0) {
					return getProvince($data->results[0]->address_components, false);
				}
			}
		}
		return '';
	}


	$result = array();

	if (isset($_GET['keyword']) && $_GET['keyword'] !== '') {
		$data = getGeoData($_GET['keyword']);
		if ($data->status === 'OK') {
			foreach ($data->results as $city) {
				$formatted_address = $city->formatted_address;
				$lat = $city->geometry->location->lat;
				$lng = $city->geometry->location->lng;
				$province = getProvince($city->address_components, true);

				$result[] = array('formatted_address'=>$formatted_address, 'lat'=>$lat, 'lng'=>$lng, 'province'=>$province);
			}
		}
	}
	
	header('Content-Type: application/json; charset=UTF-8');
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>