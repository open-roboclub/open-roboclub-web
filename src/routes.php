<?php
// Routes


$app->get('/', 'home');
foreach ($generic_pages as $page) {
	$app->get('/' . $page, $page);
}

$app->get('/announcements', App\Page\AnnouncementsPage::class);
$app->get('/contributions', App\Page\ContributionsPage::class);
$app->get('/projects', App\Page\ProjectsPage::class);
$app->get('/downloads', App\Page\DownloadsPage::class);

$app->get('/{name}', App\Page\NamePage::class);
