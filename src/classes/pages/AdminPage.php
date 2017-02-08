<?php

namespace App\Page;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Repo;

final class AdminPage extends GenericPage {

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Admin Panel');
		$this->setTemplate('admin.twig');

		$this->render_page($request, $response);
	}

};