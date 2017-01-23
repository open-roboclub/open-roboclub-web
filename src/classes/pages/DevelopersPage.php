<?php

namespace App\Page;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Repo;

final class DevelopersPage extends GenericPage {

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Developers');
		$this->setTemplate('developers.twig');

		$this->render_page($request, $response);
	}

};