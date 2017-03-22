<?php

namespace App\Page;

use App\Repo;
use Slim\Http\Request;
use Slim\Http\Response;

final class RoboconPage extends GenericPage {

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Robocon');
		$this->setTemplate('robocon.twig');

		$robocon = null;
		if($request->isPost()) {
			$this->setTemplate('robocon-core.twig');
			$robocon = $request->getParsedBody();

			$this->addTwigObject($robocon);
		} else {
		    $this->addTwigObject([
		        'robocon' => Repo::getRoboconData(),
                'downloads' => Repo::getDownloads()['robocon']]);
        }

		$this->render_page($request, $response);
	}

};