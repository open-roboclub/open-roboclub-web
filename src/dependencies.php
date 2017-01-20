<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];

    $view = new Slim\Views\Twig($settings['template_path'], $settings['twig']);
    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// -----------------------------------------------------------------------------
// Action factories
// -----------------------------------------------------------------------------

$generic_pages = [
	'home', 
	'team', 
	'members', 
	'robocon',
	'robonics'
];

foreach ($generic_pages as $page) {
	$container[$page] = function ($c) use($page, $generic_pages) {
		
    	$object =  new App\Page\GenericPage($c->get('renderer'), $c->get('logger'));
    	$object->setTitle($page);
    	$object->setTemplate($page . '.twig');

    	return $object;
	};
}

$container[App\Page\AnnouncementsPage::class] = function($c) {
    return new App\Page\AnnouncementsPage($c->get('renderer'), $c->get('logger'));
};

$container[App\Page\ContributionsPage::class] = function($c) {
    return new App\Page\ContributionsPage($c->get('renderer'), $c->get('logger'));
};

$container[App\Page\ProjectsPage::class] = function($c) {
    return new App\Page\ProjectsPage($c->get('renderer'), $c->get('logger'));
};

$container[App\Page\DownloadsPage::class] = function($c) {
    return new App\Page\DownloadsPage($c->get('renderer'), $c->get('logger'));
};


$container[App\Page\NamePage::class] = function ($c) {
    return new App\Page\NamePage($c->get('renderer'), $c->get('logger'));
};