<?php
// Routes


$app->get('/', 'home');
foreach ($generic_pages as $page) {
	$app->get('/' . $page, $page);
}

$app->get('/{name}', App\NamePage::class);
