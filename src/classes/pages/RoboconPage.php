<?php

namespace App\Page;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Repo;

final class RoboconPage extends GenericPage {

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Robocon');
		$this->setTemplate('robocon.twig');

		$robocon = Repo::getRoboconData();
		$downloads = Repo::getDownloads()['robocon'];

		$this->addTwigObject(['robocon' => $robocon, 'downloads' => $downloads]);
		$this->render_page($request, $response);
	}

};