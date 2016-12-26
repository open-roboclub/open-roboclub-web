<?php
// Routes

$app->get('/', App\HomePage::class)->setName('home');

$app->get('/{name}', function ($request, $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    $this->logger->info("AMU RoboClub '/$name' route");
    return $response;
});
