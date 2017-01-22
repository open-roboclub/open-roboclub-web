<?php

namespace App\Page;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Repo;

final class TeamPage extends GenericPage {

	private static function updateLinks(&$team) {
		foreach ($team as &$member) {
			if(!array_key_exists('links', $member))
				continue;
			foreach ($member['links'] as $key => &$link) {
				if ($key == 'mobile') {
					$member['links']['phone'] = $link;
					unset($member['links'][$key]);
				} else if ($key == 'g-plus') {
					$member['links']['google-plus'] = $link;
					unset($member['links'][$key]);
				}
			}
		}
	}

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Team');
		$this->setTemplate('team.twig');

		$team = Repo::getTeam();
		$this->updateLinks($team);

		$this->addTwigObject(['team' => $team]);
		$this->render_page($request, $response);
	}

};