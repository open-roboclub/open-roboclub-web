<?php

namespace App;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class BasePage {
	protected $renderer;
	protected $logger;

	public function __construct(Twig $renderer, LoggerInterface $logger) {
		$this->renderer = $renderer;
		$this->logger = $logger;
	}

	abstract public function __invoke(Request $request, Response $response, $args);

}