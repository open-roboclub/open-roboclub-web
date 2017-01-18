<?php

namespace App;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Utils;

final class ContributionsPage extends GenericPage {

	private function getContributions($debug=FALSE) {
		if($debug) {
			return [
				[
					"amount" => "₹ 1300",
					"contributor" => "Prof. Ekram Khan",
					"purpose" => "ROBOCON",
					"remark" => "-"
	  			],
	  			[
					"amount" => "Robotics Kits",
					"contributor" => "Mr. Abed Mohammad Kalamuddin, Mr. Mohammad Umair",
					"purpose" => "-",
					"remark" => "-"
	  			],
	  			[
					"amount" => "$ 99.00",
					"contributor" => "Mr. Aftab Usmani, Mr. Haris Siddiqui",
					"purpose" => "eZdsp USB Kit (Texas)",
					"remark" => "-"
	  			],
	  			[
					"amount" => "₹ 50,000",
					"contributor" => "Dr. Mohd Ahmad Badshah",
					"purpose" => "ROBOCON",
					"remark" => "Alumni Meet 2015"
	  			]
			];
		}

		return Utils::getReverseJsonArray('https://amu-roboclub.firebaseio.com/contribution.json');
	}

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Contributions');
		$this->setTemplate('contributions.twig');

		$contributions = $this->getContributions();

		$this->addTwigObject(['contributions' => $contributions]);
		$this->render_page($request, $response);
	}

};