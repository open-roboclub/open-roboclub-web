<?php
// Routes

$app->get('/', function ($request, $response) {
    $this->logger->info("AMU RoboClub '/' route");
    return $this->renderer->render($response, 'home.twig');
});

$app->get('/{name}', function ($request, $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    $this->logger->info("AMU RoboClub '/$name' route");
    return $response;
});
