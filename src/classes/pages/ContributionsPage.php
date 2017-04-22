<?php

namespace App\Page;

use App\Utils\Repo;
use Slim\Http\Request;
use Slim\Http\Response;

final class ContributionsPage extends GenericPage {

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Contributions');
		$this->setTemplate('contributions.twig');

        $this->addTwigObject(['contributions' => Repo::getContributions()]);
		$this->render_page($request, $response);
	}

};