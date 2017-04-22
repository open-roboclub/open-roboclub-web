<?php

namespace App\Utils;

use phpFastCache\Cache\ExtendedCacheItemPoolInterface;

final class Repo {

    /** @var ExtendedCacheItemPoolInterface */
    private static $cache;

    public static function setCache($cache) {
        Repo::$cache = $cache;
    }

    public static function purgeCache($keys=[]) {

        if(!empty($keys)) {
            Repo::$cache->deleteItems($keys);
            foreach ($keys as $key) {
                Database::deleteAll($key);
            }
            return;
        }

        Repo::$cache->clear();
        Database::destroy();
    }

    private static function getCacheItem($key, $url, $override=TRUE, $seconds = 10000) {
        $item = Repo::$cache->getItem($key);

        if (is_null($item->get())) {
            $data = Database::get($key);

            if(is_null($data) || !$override) {
                $data = Utils::getJsonArray($url);
                Database::save($key, $data);
            }

            if (!empty($data)) {
                $item->set($data)->expiresAfter($seconds);
                Repo::$cache->save($item);
            } else {
                return $data;
            }
        }

        return $item->get();
    }

    public static function getDownloads() {
        return Repo::getCacheItem('downloads', 'https://amu-roboclub.firebaseio.com/downloads.json');
    }

    public static function getNews() {
        return array_reverse(Repo::getCacheItem('news', 'https://amu-roboclub.firebaseio.com/news.json'));
    }

    public static function getContributions() {
        return array_reverse(Repo::getCacheItem('contributions', 'https://amu-roboclub.firebaseio.com/contribution.json'));
    }

    public static function getProjects($blocking=TRUE) {
        return Repo::getCacheItem('projects', 'https://amu-roboclub.firebaseio.com/projects.json?orderBy="ongoing"&equalTo=false', $blocking);
    }

    public static function getTeam() {
        return Repo::getCacheItem('team', 'https://amu-roboclub.firebaseio.com/team/16.json?orderBy="rank"');
    }

    public static function getRoboconData() {
        return Repo::getCacheItem('robocon', 'https://amu-roboclub.firebaseio.com/robocon/17.json');
    }

    public static function rebuildCache($key=''){

        if(!isset($key) || empty($key)) {
            Repo::purgeCache();

            Repo::getDownloads();
            Repo::getProjects();
            Repo::getNews();
            Repo::getContributions();
            Repo::getTeam();
            Repo::getRoboconData();

            return TRUE;
        }

        Repo::purgeCache([$key]);

        switch ($key) {
            case 'downloads':
                Repo::getDownloads();
                return TRUE;
            case 'news':
                Repo::getDownloads();
                return TRUE;
            case 'projects':
                Repo::getProjects();
                return TRUE;
            case 'contribution':
                Repo::getContributions();
                return TRUE;
            case 'team':
                Repo::getTeam();
                return TRUE;
            case 'robocon':
                Repo::getRoboconData();
                return TRUE;
            default:
                return FALSE;
        }
    }

};