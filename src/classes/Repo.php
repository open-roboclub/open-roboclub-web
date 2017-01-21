<?php

namespace App;

use phpFastCache\CacheManager;

final class Repo {
	private static $cache;

	public function setCache($cache) {
		Repo::$cache = $cache;
	}

	public static function purgeCache($keys=[]) {

		if(!empty($keys)) {
			Repo::$cache->deleteItems($keys);
			return;
		}

		Repo::$cache->clear();
	}

	private static function getCacheItem($key, $url) {
		$item = Repo::$cache->getItem($key);

		if (is_null($item->get())) {
			$data = Utils::getJsonArray($url);

			if (!empty($data)) {
				$item->set($data);
				Repo::$cache->save($item);
			} else {
				return $data;
			}
		}

		return $item->get();
	}

	public static function getDownloads($debug = FALSE) {
		if ($debug) {
			return Mock::getDownloads();
		}

		return Repo::getCacheItem('downloads', 'https://amu-roboclub.firebaseio.com/downloads.json');
	}

	public static function getNews($debug = FALSE) {
		if ($debug) {
			return Mock::getNews();
		}

		return array_reverse(Repo::getCacheItem('news', 'https://amu-roboclub.firebaseio.com/news.json'));
	}

	public static function getContributions($debug = FALSE) {
		if ($debug) {
			return Mock::getContributions();
		}

		return array_reverse(Repo::getCacheItem('contributions', 'https://amu-roboclub.firebaseio.com/contribution.json'));
	}

	public static function getProjects($debug = FALSE) {
		if ($debug) {
			return Mock::getProjects();
		}

		return Repo::getCacheItem('projects', 'https://amu-roboclub.firebaseio.com/projects.json?orderBy="ongoing"&equalTo=false');
	}

	public static function rebuildCache($key=''){
		Repo::purgeCache();
		if(!isset($key) || empty($key)) {
			Repo::getDownloads();
			Repo::getProjects();
			Repo::getNews();
			Repo::getContributions();

			return TRUE;
		}

		switch ($key) {
			case 'downloads':
				Repo::getDownloads();
				return TRUE;
			case 'news':
				Repo::getDownloads();
				return TRUE;
			case 'projects':
				Repo::getDownloads();
				return TRUE;
			case 'contribution':
				Repo::getContributions();
				return TRUE;
			default:
				return FALSE;
		}
	}

};