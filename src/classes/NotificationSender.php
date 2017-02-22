<?php

namespace App;

use GuzzleHttp\Exception\ClientException;
use Slim\Http\Request;
use Slim\Http\Response;

use paragraph1\phpFCM\Client;
use paragraph1\phpFCM\Message;
use paragraph1\phpFCM\Recipient\Topic;
use paragraph1\phpFCM\Notification;

final class NotificationSender {

    private function sendNotification($title, $body) {
        $apiKey = Secrets::$fcm_key;
        $client = new Client();
        $client->setApiKey($apiKey);
        $client->injectHttpClient(new \GuzzleHttp\Client());

        $message = new Message();
        $message->addRecipient(new Topic('news'));
        $message->setNotification(new Notification($title, $body));

        $response = $client->send($message);

        return (array) json_decode($response->getBody()->getContents(), TRUE);
    }

    public function __invoke(Request $request, Response $response, $args) {

        $result = [
            'error' => TRUE,
            'message' => 'No title/message provided'
        ];

        $data = $request->getParams();

        if (isset($data['title']) && isset($data['message'])) {
            $title = $data['title'];
            $message = $data['message'];

            $result['message'] = 'Sent successfully!';

            $auth = $request->getHeader('Authorization')[0];

            $verified = Utils::verifyKey($auth, $result);
            $result['error'] = !$verified;

            if($verified) {
                try {
                    $response_data = $this->sendNotification($title, $message);

                    if(array_key_exists('error', $response_data)) {
                        $result['error'] = TRUE;
                        $result['message'] = $response_data['error'];
                    } else {
                        $result['error'] = FALSE;
                        $result['message_id'] = $response_data['message_id'];
                    }

                } catch (ClientException $e) {
                    $result['error'] = TRUE;
                    $result['message'] = "Wrong Key or User unauthorized";
                }
            }
            
        }

        return $response->withHeader('Content-Type', 'application/json')
                 ->write(json_encode($result));
    }
    
}