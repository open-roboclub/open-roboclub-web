<?php

namespace App;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Utils;

final class Notification {

    public function __invoke(Request $request, Response $response, $args) {

        $result = [
            'error' => TRUE,
            'message' => 'No title/message provided'
        ];

        $data = $request->getParams();

        if (isset($data['title']) && isset($data['message'])) {
            $result['message'] = 'Sent successfully!';

            $auth = $request->getHeader('Authorization')[0];

            $verified = !Utils::verifyKey($auth, $result);
            $result['error'] = $verified;
        }

        return $response->withHeader('Content-Type', 'application/json')
                 ->write(json_encode($result));
    }
    
}