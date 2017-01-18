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
}