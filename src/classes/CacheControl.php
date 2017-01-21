<?php

namespace App;

use Slim\Http\Request;
use Slim\Http\Response;

final class CacheControl {

	public function __invoke(Request $request, Response $response, $args) {

		if (!isset($args['option'])) {
			$response->write('No option given for cache control!');
			return;
		}

		switch ($args['option']) {
			case 'purge':
				Repo::purgeCache();
				$response->write('Cache Purged!');
				break;
			case 'rebuild':
				Repo::rebuildCache();
				$response->write('Cache Rebuilt!');
				break;
			case 'delete':
				if(!isset($args['parameter'])) {
					$response->write('No key given to delete');
					return;
				}
				Repo::purgeCache((array)$args['parameter']);
				$response->write('Key '.$args["parameter"]. ' deleted!');
				break;
			
			default:
				$response->write('No correct option provided!');
				break;
		}

		return;
	}
	
}