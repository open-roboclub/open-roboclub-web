<?php

namespace App\Page;

use App\Utils\Repo;
use Slim\Http\Request;
use Slim\Http\Response;

final class ProjectPage extends GenericPage {

	private function getProject($id) {
        $projects = Repo::getProjects($blocking = FALSE);
        if(isset($projects)) {
            foreach ($projects as $project) {
                if($project['id'] == $id)
                    return $project;
            }
        } else {
            return false;
        }

        return NULL;
    }

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Project');
		$this->setTemplate('project.twig');
		
		if ($request->isPost()) {
			$this->setTemplate('project-core.twig');
			
			$project = $request->getParsedBody();
			$this->addTwigObject(['project' => $project]);
		} else {
		    $project = $this->getProject($request->getAttribute('id'));
		    if($project) {
                $this->addTwigObject(['project' => $project]);
                $this->addTwigObject(['hide' => TRUE]);
            }
        }
		
		$this->render_page($request, $response);
	}

};