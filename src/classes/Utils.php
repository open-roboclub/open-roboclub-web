<?php

namespace App;

final class Utils {
	
	public static function getReverseJsonArray($url) {
		return array_reverse(Utils::getJsonArray($url), true);
	}

	public static function getJsonArray($url) {
		$curlSession = curl_init();
		$curlSession = curl_init();
	    curl_setopt($curlSession, CURLOPT_URL, $url);
	    curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
	    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

	    $jsonData = json_decode(curl_exec($curlSession));
	    curl_close($curlSession);

		return (array) $jsonData;
	}

	public static function formatSizeUnits($bytes) {
		$original = $bytes;
		$bytes = intval(str_replace(",", "", $bytes));

		if(!ctype_digit($bytes))
			return $original;

		if ($bytes >= 1073741824) {
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		} elseif ($bytes >= 1048576) {
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		} elseif ($bytes >= 1024) {
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		} elseif ($bytes > 1) {
			$bytes = $bytes . ' bytes';
		} elseif ($bytes == 1) {
			$bytes = $bytes . ' byte';
		} else {
			$bytes = '0 bytes';
		}

		return $bytes;
	}
}