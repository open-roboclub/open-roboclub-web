<?php

use App\Repo;

// Routes

$app->get('/announcements', App\Page\AnnouncementsPage::class);
$app->get('/contributions', App\Page\ContributionsPage::class);
$app->get('/projects', App\Page\ProjectsPage::class);
$app->get('/downloads', App\Page\DownloadsPage::class);
$app->get('/team', App\Page\TeamPage::class);
$app->get('/[home]', App\Page\HomePage::class);
$app->get('/robocon', App\Page\RoboconPage::class);

// Cache Control

$app->get('/cache[/{option}[/{parameter}]]', App\CacheControl::class);
