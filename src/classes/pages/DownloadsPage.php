<?php

namespace App\Page;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Utils;
use App\Repo;

final class DownloadsPage extends GenericPage {

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

		$downloads = Repo::getDownloads();

		$this->adjustSize($downloads);

		$this->addTwigObject(['downloads' => $downloads]);
		$this->render_page($request, $response);
	}

};