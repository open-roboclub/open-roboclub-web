<?php

namespace App;

use Slim\Http\Request;
use Slim\Http\Response;

final class ImageServer {

	public function __invoke(Request $request, Response $response, $args) {
		
		$url = 'https://res.cloudinary.com/amuroboclub/image/upload/';
		
		if('old_images' == $request->getAttribute('route')->getName()) {
			$url = $url . 'old/';
		}

		return $response->withStatus(302)->withHeader('Location',  $url . $args['path']);
	}
	
}