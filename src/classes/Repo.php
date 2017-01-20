<?php

namespace App;

use phpFastCache\CacheManager;

final class Repo {

	private static function getCacheItem($key, $url) {
		$cache = CacheManager::getInstance('files');

		$item = $cache->getItem($key);
		if (is_null($item->get())) {
			$item->set(Utils::getJsonArray($url));
			$cache->save($item);

			return $item->get();
		}

		return $item->get();
	}

	public static function getDownloads($debug = FALSE) {
		return Repo::getCacheItem('downloads', 'https://amu-roboclub.firebaseio.com/downloads.json');
	}

	public static function getNews($debug = FALSE) {
		return array_reverse(Repo::getCacheItem('news', 'https://amu-roboclub.firebaseio.com/news.json'));
	}

	public static function getContributions($debug = FALSE) {
		return array_reverse(Repo::getCacheItem('contributions', 'https://amu-roboclub.firebaseio.com/contribution.json'));
	}

	public static function getProjects($debug = FALSE) {
		return Repo::getCacheItem('projects', 'https://amu-roboclub.firebaseio.com/projects.json?orderBy="ongoing"&equalTo=false');
	}

};