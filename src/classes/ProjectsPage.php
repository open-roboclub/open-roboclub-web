<?php

namespace App;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Utils;

final class ProjectsPage extends GenericPage {

	private function getProjects($debug=FALSE) {
		if($debug) {
			return [
				[
					"description" => "The purpose of the design model is to access the result by the students via single SMS over their mobile phones. Project can be scalable to Offices where Employees can get their monthly report evaluation result or can be used to broadcast the urgent message to all the employees of a subdivision in the company.\n \t\tThe prototype model uses UART Protocol to interface GSM Modem and I2C Protocol to interface external EEPROM with Microcontroller. The purpose of GSM Modem is to send and receive the message from recipients whereas EEPROM stores the database of Result along with Individuals Student Id. Microcontroller acts as a link between GSM Modem and EEPROM and processes the data to deliver correct message to correct Individual. \n \t\tPrototype Design Model uses some standard components such as GSM Modem SIM300, AVR Microcontroller, USBASP AVR Programmer, EEPROM 24C512 IC, 7805 Voltage Regulator and few other miscellaneous components. ",
				    "image" => "http://res.cloudinary.com/amuroboclub/image/upload/old/projects/GSMBasedResult/thumb.jpg",
				    "name" => "GSM Based Result System",
				    "ongoing" => FALSE,
				    "team" => "Anand Agrawal"
	  			],
	  			[
					"description" => "The most important feature of the home is that electrical appliances can be controlled from anywhere through a protected webpage. The automated home is well equipped with various sensors which are SMS controlled. The main entrance is password protected and employed with sms notification in case of any breach. Image Processing based Garage gate opening is also employed. Other remarkable features include Automatic Water Level indicator, LPG indicator, alarming and sms notification in case of security and safety breach etc. ",
				    "image" => "http://res.cloudinary.com/amuroboclub/image/upload/old/projects/HomeAutomation/thumb.jpg",
				    "name" => "Ethernet and SMS Based Home Automation with Enhanced Security",
				    "ongoing" => FALSE,
				    "team" => "Aftab Usmani, Haris siddiqui, Ali Shahzan, Muhammad Asif"
	  			],
	  			[
					"description" => "This was implementation of a hardware based calculating device for basic calculations. Main components used were used a ATMEGA16 microcontroller, a LCD screen and a 4x4 Key panel. ",
				    "image" => "http://res.cloudinary.com/amuroboclub/image/upload/old/projects/BasicCalculator/thumb.jpg",
				    "name" => "Basic Calculator on ATMEGA16",
				    "ongoing" => FALSE,
				    "team" => "Abu Talha Danish"
	  			],
	  			[
					"description" => "The system is based upon STBCFG01 IC which is a Switched mode single cell Li+ battery charger with OTG boost, voltage mode fuel gauge and LDO. The aim of the system is to make a low cost, robust and highly efficient backup extender for smartphones which will fit on the phone like a backcover. The back cover will have a battery of its own to provide the extended backup. A push switch is used to provide the control to the user for turning the system on and off and also for selecting between phone charging and backup battery charging. A LED based display section is integrated in the system to indicate the level of battery. ",
				    "image" => "http://res.cloudinary.com/amuroboclub/image/upload/old/projects/STBCFG/thumb.jpg",
				    "name" => "STBCFG01 based Back Cover Battery Charger",
				    "ongoing" => FALSE,
				    "team" => "Mohd. Aftab Usmani"
	  			]
			];
		}

		return Utils::getJsonArray('https://amu-roboclub.firebaseio.com/projects.json?orderBy="ongoing"&equalTo=false');
	}

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Projects');
		$this->setTemplate('projects.twig');

		$projects = $this->getProjects();
		krsort($projects);

		$this->addTwigObject(['projects' => $projects]);
		$this->render_page($request, $response);
	}

};