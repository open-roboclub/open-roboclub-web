<?php

namespace App;

final class Mock {

	public static function getTeam() {
		return (array) json_decode('[{
			  "avatar" : "/DrAbidAliKhan.bmp",
			  "name" : "Dr. Abid Ali Khan",
			  "position" : "Faculty Adviser",
			  "thumbnail" : "https://res.cloudinary.com/amuroboclub/image/upload/old/team/DrAbidAliKhan.bmp"
			}, {
			  "avatar" : "/DrAnwarSadat.bmp",
			  "links" : {
			    "email" : "anwart7039@gmail.com"
			  },
			  "name" : "Dr. Anwar Sadat",
			  "position" : "Faculty Adviser",
			  "thumbnail" : "https://res.cloudinary.com/amuroboclub/image/upload/old/team/DrAnwarSadat.bmp"
			}, {
			  "avatar" : "/NishantPratapSingh.jpg",
			  "id" : "NishantPratapSingh",
			  "links" : {
			    "email" : "npsaligarh@gmail.com",
			    "facebook" : "httpss://facebook.com/NPSIN",
			    "mobile" : "+91-9412272766"
			  },
			  "name" : "Nishant Pratap Singh",
			  "position" : "Coordinator",
			  "profile" : "https://amuroboclub.in/profile.php?id=NishantPratapSingh",
			  "thumbnail" : "https://res.cloudinary.com/amuroboclub/image/upload/old/members/thumbs/NishantPratapSingh.jpg"
			}, {
			  "avatar" : "/AmarUpadhyay.jpg",
			  "id" : "AmarUpadhyay",
			  "links" : {
			    "email" : "chat2amar@yahoo.in",
			    "facebook" : "httpss://www.facebook.com/amarupadhyay.happy",
			    "g-plus" : "httpss://plus.google.com/u/0/107125332291865356506/posts",
			    "linkedin" : "httpss://www.linkedin.com/profile/view?id=380171064",
			    "mobile" : "+91-9045414527"
			  },
			  "name" : "Amar Upadhyay",
			  "position" : "Coordinator",
			  "profile" : "https://amuroboclub.in/profile.php?id=AmarUpadhyay",
			  "thumbnail" : "https://res.cloudinary.com/amuroboclub/image/upload/old/members/thumbs/AmarUpadhyay.jpg"
			}, {
			  "avatar" : "/MohdTalha.jpg",
			  "id" : "MohdTalha",
			  "links" : {
			    "email" : "mohdtalha13@gmail.com",
			    "facebook" : "httpss://www.facebook.com/talha.mohd.5",
			    "linkedin" : "httpss://www.linkedin.com/profile/view?id=403978334",
			    "mobile" : "+91-7417108769"
			  },
			  "name" : "Mohd Talha",
			  "position" : "Coordinator",
			  "profile" : "https://amuroboclub.in/profile.php?id=MohdTalha",
			  "thumbnail" : "https://res.cloudinary.com/amuroboclub/image/upload/old/members/thumbs/MohdTalha.jpg"
			}, {
			  "avatar" : "/AbdulHudaif.jpg",
			  "id" : "AbdulHudaif",
			  "name" : "Abdul Hudaif",
			  "position" : "Joint Coordinator",
			  "profile" : "https://amuroboclub.in/profile.php?id=AbdulHudaif",
			  "thumbnail" : "https://res.cloudinary.com/amuroboclub/image/upload/old/members/thumbs/AbdulHudaif.jpg"
			}]');
	}

	public static function getNews() {
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

	public static function getContributions() {
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

	public static function getProjects() {
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

	public static function getDownloads() {
		$downloads = '
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

		return (array) json_decode($downloads);
	}
}