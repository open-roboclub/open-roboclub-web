<?php

namespace App\Page;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Repo;

final class ContributionsPage extends GenericPage {

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Contributions');
		$this->setTemplate('contributions.twig');

		$contributions = Repo::getContributions();

		$this->addTwigObject(['contributions' => $contributions]);
		$this->render_page($request, $response);
	}

};