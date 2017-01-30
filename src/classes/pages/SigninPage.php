<?php

namespace App\Page;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Repo;

final class SigninPage extends GenericPage {

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Sign In');
		$this->setTemplate('signin.twig');

		$this->render_page($request, $response);
	}

};