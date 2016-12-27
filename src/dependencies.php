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
function invoke($container, $class){
	return new $class($container->get('renderer'), $container->get('logger'));
}

$container['home'] = function ($c) {
    $object =  invoke($c, App\GenericPage::class);
    $object->setTitle('Home');
    $object->setTemplate('home.twig');
    return $object;
};

$container['team'] = function ($c) {
    $object =  invoke($c, App\GenericPage::class);
    $object->setTitle('Team');
    $object->setTemplate('team.twig');
    return $object;
};

$container['members'] = function ($c) {
    $object =  invoke($c, App\GenericPage::class);
    $object->setTitle('Members');
    $object->setTemplate('members.twig');
    return $object;
};

$container['projects'] = function ($c) {
    $object =  invoke($c, App\GenericPage::class);
    $object->setTitle('Projects');
    $object->setTemplate('projects.twig');
    return $object;
};

$container['robocon'] = function ($c) {
    $object =  invoke($c, App\GenericPage::class);
    $object->setTitle('Robocon');
    $object->setTemplate('robocon.twig');
    return $object;
};

$container['downloads'] = function ($c) {
    $object =  invoke($c, App\GenericPage::class);
    $object->setTitle('Downloads');
    $object->setTemplate('downloads.twig');
    return $object;
};

$container['announcements'] = function ($c) {
    $object =  invoke($c, App\GenericPage::class);
    $object->setTitle('Announcements');
    $object->setTemplate('announcements.twig');
    return $object;
};

$container['robonics'] = function ($c) {
    $object =  invoke($c, App\GenericPage::class);
    $object->setTitle('Robonics');
    $object->setTemplate('robonics.twig');
    return $object;
};

$container['budget'] = function ($c) {
    $object =  invoke($c, App\GenericPage::class);
    $object->setTitle('Budgets');
    $object->setTemplate('budget.twig');
    return $object;
};

$container[App\NamePage::class] = function ($c) {
    return invoke($c, App\NamePage::class);
};