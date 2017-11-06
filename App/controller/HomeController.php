<?php

namespace App;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Illuminate\Database\Query\Builder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class WidgetController {

	$this->db;
	$capsule = new \Illuminate\Database\Capsule\Manager;
	$capsule::schema()->dropIfExists('articles');
	$capsule::schema()->create('articles', function(\illuminate\Database\Schema\Blueprint $table) {
		$table->increments('id');
		$table->string('title')->default('');

		$table->timestamps();
	});

	private $view;
	private $slogger;
	protected $table;

	public function __construct(Twig $view, LoggerInterface $logger, Builder $table) {
		$this->view = $view;
		$this->logger = $logger;
		$this->table = $table;
	}

	public function __invoke(Request $request, Response $reponse, $args) {
		
		$widget = $this->table->get();

		$this->view->render($response, 'app\index.twig', ['widgets' => $widgets]);

		return $response;
	}
}
