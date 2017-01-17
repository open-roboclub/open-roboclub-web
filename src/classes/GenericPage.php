<?php

namespace App;

use Slim\Http\Request;
use Slim\Http\Response;

class GenericPage extends BasePage {
	private $title;
	private $template;
	private $navigation = [
		'home', 
		'team', 
		'members', 
		'projects', 
		'robocon', 
		'downloads',
		'announcements',
		'robonics',
		'contributions'
	];

	private $twig_object = [];

	public function setTitle($title) {
		$this->title = $title;
	}

	public function setTemplate($template) {
		$this->template = $template;
	}

	public function addTwigObject($object){
		$this->twig_object = array_merge($this->twig_object, $object);
	}

	protected function render_page($request, $response){
		if(is_null($this->title)||is_null($this->template)||is_null($this->navigation)){
			$this->logger->error("AMU RoboClub Page Creation Error '$this->title'");
			$response->getBody()->write("Oops! Error generating page");
			return $response;
		}

		$uri = $request->getUri();
    	$path = str_replace('/', '', $uri->getPath());
		$this->logger->info("AMU RoboClub '/$path' route");
		$this->addTwigObject([
    		'title' => $this->title,
    		'navigation' => $this->navigation,
    		'route' => $path
    	]);
    	return $this->renderer->render($response, $this->template, $this->twig_object);
	}

	public function __invoke(Request $request, Response $response, $args) {
		$this->render_page($request, $response);
	}
}