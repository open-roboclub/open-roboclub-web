<?php

namespace App;

use Slim\Http\Request;
use Slim\Http\Response;

final class NamePage extends BasePage {

	public function __invoke(Request $request, Response $response, $args) {
		$name = $args['name'];
	    $response->getBody()->write("Hello, $name");

	    $this->logger->info("AMU RoboClub '/$name' route");
	    return $response;
	}
}