<?php

namespace App\Page;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Utils\Repo;

final class ProjectsPage extends GenericPage {

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Projects');
		$this->setTemplate('projects.twig');

		$projects = Repo::getProjects();
		krsort($projects);

		$this->addTwigObject(['projects' => $projects]);
		$this->render_page($request, $response);
	}

};