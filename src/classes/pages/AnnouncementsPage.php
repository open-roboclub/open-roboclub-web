<?php

namespace App\Page;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Utils;
use App\Repo;

final class AnnouncementsPage extends GenericPage {

	private function getNews($debug=FALSE) {
		if($debug) {
			return [
				[
					"date" => "5th Sept 2014",
	  				"notice" => "Registrations to be closed soon."
	  			],
	  			[
					"date" => "10th Sept 2014",
					"link" => "https://drive.google.com/open?id=0B6SBb5XJ1fKfMVp6OXBNZ2lYczA",
					"notice" => "Class schedule for session 2014-15 Download Attachment"
	  			],
	  			[
					"date" => "15th Sept 2014",
	 				"notice" => "RoboClub's first introductory class of session 2014-15 will be held on 12:30PM, 16th September 2014 (Tuesday) in Mechanical Engineering Department."
	  			],
	  			[
					"date" => "10th Oct 2014",
					"link" => "http://goo.gl/forms/HS75Zx2Iar",
					"notice" => "All the registered members of AMURoboclub are advised to choose one of the projects from This Link"
	  			]
			];
		}

		return Utils::getReverseJsonArray('https://amu-roboclub.firebaseio.com/news.json');
	}

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Announcements');
		$this->setTemplate('announcements.twig');

		$news = Repo::getNews();

		$this->addTwigObject(['news' => $news]);
		$this->render_page($request, $response);
	}

};