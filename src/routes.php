<?php
// Routes

$app->get('/', App\HomePage::class)
	->setName('home');

$app->get('/{name}', App\NamePage::class);
