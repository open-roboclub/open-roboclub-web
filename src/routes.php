<?php
// Routes

$app->get('/', 'home');
$app->get('/team', 'team');
$app->get('/members', 'members');
$app->get('/projects', 'projects');
$app->get('/robocon', 'robocon');
$app->get('/downloads', 'downloads');
$app->get('/announcements', 'announcements');
$app->get('/robonics', 'robonics');
$app->get('/budget', 'budget');

$app->get('/{name}', App\NamePage::class);
