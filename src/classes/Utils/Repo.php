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
            return;
        }

        Repo::$cache->clear();
    }

    private static function getCacheItem($key, $url, $seconds = 600) {
        $item = Repo::$cache->getItem($key);

        if (is_null($item->get())) {
            $data = Utils::getJsonArray($url);

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

    public static function getProjects() {
        return Repo::getCacheItem('projects', 'https://amu-roboclub.firebaseio.com/projects.json?orderBy="ongoing"&equalTo=false');
    }

    public static function getTeam() {
        return Repo::getCacheItem('team', 'https://amu-roboclub.firebaseio.com/team/16.json');
    }

    public static function getRoboconData() {
        return Repo::getCacheItem('robocon', 'https://amu-roboclub.firebaseio.com/robocon/17.json');
    }

    public static function getRobotsMetaData() {
        return Repo::getCacheItem('google_robots', 'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com');
    }

    public static function getAdmins($uid, $token) {
        return Repo::getCacheItem("admin_$uid_$token", "https://amu-roboclub.firebaseio.com/admins/$uid.json?auth=$token", 60);
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
            Repo::getRobotsMetaData();

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
            case 'robots':
                Repo::getRobotsMetaData();
                return TRUE;
            default:
                return FALSE;
        }
    }

};