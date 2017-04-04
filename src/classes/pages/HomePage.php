<?php

namespace App\Page;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Utils\Repo;

final class HomePage extends GenericPage {

	private function getCoordinators() {
		$coordinators = [];
		foreach (Repo::getTeam() as $member) {
			if ($member['position'] == 'Coordinator') {
				array_push($coordinators, $member);
			}
		}

		return $coordinators;
	}

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Home');
		$this->setTemplate('home.twig');

		$news = array_slice(Repo::getNews(), 0, 10);

		$this->addTwigObject(['news' => $news, 'coordinators' => $this->getCoordinators()]);
		$this->render_page($request, $response);
	}

};