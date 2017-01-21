<?php

namespace App;

use phpFastCache\CacheManager;

final class Repo {

	public static function purgeCache($keys=[]) {
		$cache = CacheManager::getInstance('files');

		if(!empty($keys)) {
			$cache->deleteItems($keys);
			return;
		}

		$cache->clear();
	}

	private static function getCacheItem($key, $url) {
		$cache = CacheManager::getInstance('files');

		$item = $cache->getItem($key);

		if (is_null($item->get())) {
			$data = Utils::getJsonArray($url);

			if (!empty($data)) {
				$item->set($data);
				$cache->save($item);
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

	public static function rebuildCache(){
		Repo::purgeCache();
		Repo::getDownloads();
		Repo::getProjects();
		Repo::getNews();
		Repo::getContributions();
	}

};