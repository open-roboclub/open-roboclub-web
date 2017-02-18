<?php

namespace App\Page;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Repo;

final class ProjectPage extends GenericPage {

	private function generateThumbs(&$project) {
		if(!@array_key_exists('images', $project))
			return $project;

		$thumbs = [];
		foreach ($project['images'] as $image) {
			$thumbs[] = str_replace('upload/', 'upload/c_thumb,w_150,h_150/', $image);
		}

		$project['thumbs'] = $thumbs;

		return $project;
	}

	private function findProject(&$array, $id) {
		foreach ($array as $project) {
			if ($project['id'] === $id) {
				return $this->generateThumbs($project);
			}
		}

		return NULL;
	}

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Projects');
		$this->setTemplate('project.twig');

		$project = null;
		
		if ($request->isPost()) {
			$this->setTemplate('project-core.twig');
			$project = $request->getParsedBody();
			$this->generateThumbs($project);
		} else {
			$projects = Repo::getProjects();
			$project = $this->findProject($projects, $args['id']);
		}
		

		$this->addTwigObject(['project' => $project]);
		$this->render_page($request, $response);
	}

};