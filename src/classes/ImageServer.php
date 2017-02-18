<?php

namespace App;

use Slim\Http\Request;
use Slim\Http\Response;

final class ImageServer {

	public function __invoke(Request $request, Response $response, $args) {

		return $response->withStatus(200)->withHeader('Location', 'https://res.cloudinary.com/amuroboclub/image/upload/old/' . $args['path']);
	}
	
}