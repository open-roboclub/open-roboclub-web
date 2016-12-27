<?php

namespace App;

use Slim\Http\Request;
use Slim\Http\Response;

final class GenericPage extends BasePage {
	public $title;
	public $template;
	public $navigation;

	public function setTitle($title) {
		$this->title = $title;
	}

	public function setTemplate($template) {
		$this->template = $template;
	}

	public function setNavigation($navigation) {
		$this->navigation = $navigation;
	}

	public function __invoke(Request $request, Response $response, $args) {

		if(is_null($this->title)||is_null($this->template)||is_null($this->navigation)){
			$this->logger->error("AMU RoboClub Page Creation Error '$this->title'");
			$response->getBody()->write("Oops! Error generating page");
			return $response;
		}

		$uri = $request->getUri();
    	$path = str_replace('/', '', $uri->getPath());
		$this->logger->info("AMU RoboClub '/$path' route");
    	return $this->renderer->render($response, $this->template, [
    		'title' => $this->title,
    		'navigation' => $this->navigation,
    		'route' => $path
    	]);
	}
}