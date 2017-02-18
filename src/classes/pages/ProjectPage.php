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

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Project');
		$this->setTemplate('project.twig');
		
		if ($request->isPost()) {
			$this->setTemplate('project-core.twig');
			
			$project = $request->getParsedBody();
			$this->generateThumbs($project);
			$this->addTwigObject(['project' => $project]);
		}
		
		$this->render_page($request, $response);
	}

};