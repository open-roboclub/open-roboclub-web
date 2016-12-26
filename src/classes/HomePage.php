<?php

namespace App;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class HomePage {
	private $renderer;
	private $logger;

	public function __construct(Twig $renderer, LoggerInterface $logger) {
		$this->renderer = $renderer;
		$this->logger = $logger;
	}

	public function __invoke(Request $request, Response $response, $args) {
		$this->logger->info("AMU RoboClub '/' route");
    	return $this->renderer->render($response, 'home.twig');
	}
}