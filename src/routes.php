<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/index', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
 
$app->get('/{lol}/{name}', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index2.phtml', $args);
});

$app->get('/form', function (Request $request, Response $response, array $args) {
	$this->logger->info("Requesting the form");

	return $this->renderer->render($response, 'form.phtml', $args);
});

$app->post('/form', function (Request $request, Response $response, array $args) {
	$this->logger->info("Submitting info");

	$this->logger->info($request->getParam('lName'));
	$args[lName] = $request->getParam('lName');
	$args[fName] = $request->getParam('fName');

	return $this->renderer->render($response, 'thanks.phtml', $args);
});
