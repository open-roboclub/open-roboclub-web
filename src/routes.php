<?php
// Routes


$app->get('/', 'home');
foreach ($generic_pages as $page) {
	$app->get('/' . $page, $page);
}

$app->get('/announcements', App\AnnouncementsPage::class);
$app->get('/contributions', App\ContributionsPage::class);
$app->get('/projects', App\ProjectsPage::class);

$app->get('/{name}', App\NamePage::class);
