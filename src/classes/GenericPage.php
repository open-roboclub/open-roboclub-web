<?php

namespace App;

use Slim\Http\Request;
use Slim\Http\Response;

final class GenericPage extends BasePage {
	public $title;
	public $template = 'home.twig';

	public function setTitle($title) {
		$this->title = $title;
	}

	public function setTemplate($template) {
		$this->template = $template;
	}

	public function __invoke(Request $request, Response $response, $args) {
		$this->logger->info("AMU RoboClub '/$this->title' route");
    	return $this->renderer->render($response, $this->template, [
    		'title' => $this->title
    	]);
	}
}