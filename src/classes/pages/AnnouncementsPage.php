<?php

namespace App\Page;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Repo;

final class AnnouncementsPage extends GenericPage {

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Announcements');
		$this->setTemplate('announcements.twig');

		$news = Repo::getNews();

		$this->addTwigObject(['news' => $news]);
		$this->render_page($request, $response);
	}

};