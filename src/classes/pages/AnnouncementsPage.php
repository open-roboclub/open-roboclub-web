<?php

namespace App\Page;

use App\Utils\Repo;
use Slim\Http\Request;
use Slim\Http\Response;

final class AnnouncementsPage extends GenericPage {

    public function __invoke(Request $request, Response $response, $args) {
        $this->setTitle('Announcements');
        $this->setTemplate('announcements.twig');

        $this->addTwigObject(['news' => Repo::getNews()]);
        $this->render_page($request, $response);
    }

};