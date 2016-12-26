<?php

namespace App;

use Slim\Http\Request;
use Slim\Http\Response;

final class HomePage extends BasePage {

	public function __invoke(Request $request, Response $response, $args) {
		$this->logger->info("AMU RoboClub '/' route");
    	return $this->renderer->render($response, 'home.twig');
	}
}