<?php

// Routes

$app->get('/[home]', App\Page\HomePage::class);
$app->get('/announcements', App\Page\AnnouncementsPage::class);
$app->get('/news', App\Page\AnnouncementsPage::class);
$app->get('/contributions', App\Page\ContributionsPage::class);
$app->get('/projects', App\Page\ProjectsPage::class);
// Any handler for AJAX post request
$app->any('/projects/{id}', App\Page\ProjectPage::class)->setName('projects');
$app->get('/downloads', App\Page\DownloadsPage::class);
$app->get('/team', App\Page\TeamPage::class);
// Any handler for AJAX post request
$app->any('/robocon', App\Page\RoboconPage::class);
$app->get('/developers', App\Page\DevelopersPage::class);

$app->get('/img/{path:.*}', App\ImageServer::class)->setName('old_images');
$app->get('/image/{path:.*}', App\ImageServer::class)->setName('new_images');

$app->get('/signin', App\Page\SigninPage::class);

$app->get('/admin', App\Page\AdminPage::class);

// Cache Control

$app->get('/cache[/{option}[/{parameter}]]', App\CacheControl::class);
