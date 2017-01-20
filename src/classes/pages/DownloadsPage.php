<?php

namespace App\Page;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Utils;

final class DownloadsPage extends GenericPage {

	private $test_data = '
{
	"archives": {
		"items": [{
			"file": "dainik jagran.pdf",
			"name": "Dainik Jagran News",
			"size": "522943",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfM1g5UUY4SVNPNzQ"
		}, {
			"file": "Newsletter08_09.pdf",
			"name": "Newsletter 2008-09",
			"size": "1735575",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfei1ZbC1LNW5pWUE"
		}, {
			"file": "Newsletter09_10.pdf",
			"name": "Newsletter 2009-10",
			"size": "895024",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfdk1QRmFmWTkxT28"
		}, {
			"file": "Newsletter10_11.pdf",
			"name": "Newsletter 2010-11",
			"size": "2322228",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfOV9TVF9NbkxHS1U"
		}, {
			"file": "techinnover.pdf",
			"name": "TechInnover",
			"size": "1653090",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfT01kM2d0WnY0VWs"
		}],
		"name": "archives"
	},
	"brochures": {
		"items": [{
			"file": "club_brochure+15.pdf",
			"name": "Brochure 2015-16",
			"size": "877,032",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfM2diR3ZTMXMtdVE"
		}],
		"name": "brochures"
	},
	"datasheets": {
		"items": [{
			"file": "5x7 led display.pdf",
			"name": "5x7 LED Display",
			"size": "535,510",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfdjVZcUNvX1RiaTQ"
		}, {
			"file": "16x2 lcd.pdf",
			"name": "16x2 LCD Display",
			"size": "76,303",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfSDFzR3BxSVNoTnc"
		}, {
			"file": "555 Timer.pdf",
			"name": "555 Timer",
			"size": "153,913",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfREp3NnVnTW9xWlE"
		}, {
			"file": "7805.pdf",
			"name": "7805 Voltage Regulator",
			"size": "235,269",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfbm1FUkt5MVVNck0"
		}],
		"name": "datasheets"
	},
	"ebooks": {
		"items": [{
			"file": "Bluetooth_1.pdf",
			"name": "Bluetooth 1",
			"size": "209,760",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfWHZCOGEwaFpDeXc"
		}, {
			"file": "Embedded Image Processing with DSP Examples in MATLAB - Shehrzad Qureshi.pdf",
			"name": "Embedded Image Processing with DSP Examples in MATLAB (Shehrzad Qureshi)",
			"size": "2,822,775",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfdWFZZmx0R3g0QkU"
		}, {
			"file": "EmbeddedBook.pdf",
			"name": "Beginners Guide To\nEmbedded Systems & Robotics",
			"size": "2,822,775",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfdWFZZmx0R3g0QkU"
		}, {
			"file": "getstart - Matlab.pdf",
			"name": "MATLAB7- Getting Started",
			"size": "2,441,091",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfeDU4cURoRWlObVk"
		}, {
			"file": "GPS_02.pdf",
			"name": "GPS",
			"size": "688,585",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfUEdNdk43N25tQ0U"
		}],
		"name": "ebooks"
	},
	"posters": {
		"items": [{
			"file": "poster1.jpg",
			"name": "Orientation Ceremony",
			"size": "141,289",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfR3U1YWxUWTlqdGM"
		}],
		"name": "posters"
	},
	"robocon": {
		"items": [{
			"file": "robocon 2016 report.pdf",
			"name": "Robocon 2016 Report",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfZVI1aE1jMTQ0S1U"
		}],
		"name": "robocon"
	},
	"slides": {
		"items": [{
			"file": "ADC.pptx",
			"name": "Analog to Digital Converter",
			"size": "227,922",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfZFZSTEoyNTNZUDg"
		}, {
			"file": "LCD interfacing.pptx",
			"name": "LCD Interfacing",
			"size": "3,705,920",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfMy1WVEEtQlZ1SG8"
		}, {
			"file": "basics of embedded C.pptx",
			"name": "Basics of Embedded C",
			"size": "234,835",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfU1hkQldqeWJVUmc"
		}, {
			"file": "sensors.pptx",
			"name": "Sensors Interfacing",
			"size": "837,372",
			"url": "https://drive.google.com/open?id=0B6SBb5XJ1fKfOGRxbjJzYThCRmM"
		}],
		"name": "slides"
	},
	"softwares": {
		"items": [{
			"about": "Free, Open Source & Light-Weight Source Code Editor",
			"url": "http://notepad-plus-plus.org/download",
			"name": "Notepad++",
			"size": "8 MB"
		}, {
			"about": "Integrated Development Environment for the 8-bit Atmel AVR and XMEGA Microcontrollers",
			"url": "http://www.hpinfotech.ro/cvavr_download.html",
			"name": "CodeVision AVR"
		}],
		"name": "softwares"
	}
}';

	private function getDownloads($debug=FALSE) {
		if($debug) {
			return (array) json_decode($this->test_data);
		}

		return Utils::getJsonArray('https://amu-roboclub.firebaseio.com/downloads.json');
	}

	private function adjustSize($obj) {
		foreach ($obj as $download) {
			foreach ($download->items as $item) {
				if(isset($item->size))
					$item->size = Utils::formatSizeUnits($item->size);
			}
		}
	}

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Downloads');
		$this->setTemplate('downloads.twig');

		$downloads = $this->getDownloads();

		$this->adjustSize($downloads);

		$this->addTwigObject(['downloads' => $downloads]);
		$this->render_page($request, $response);
	}

};