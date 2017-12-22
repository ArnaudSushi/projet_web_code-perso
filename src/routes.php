<?php

use Slim\Http\Request;
use Slim\Http\Response;
require __DIR__ . '/../src/Models/Books.php';
// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
	// Sample log message
	$this->logger->info("Slim-Skeleton '/' route");

	$this->db;
	$capsule = new \Illuminate\Database\Capsule\Manager;
	if (!$capsule::Schema()->hasTable("books")) {
		$capsule::Schema()->create("books", function (\Illuminate\Database\Schema\Blueprint $table){
			$table->increments("id");
			$table->string("title")->default("");
			$table->string("author")->default("");
			$table->timestamps();
		});
		$book = new Books();
		$book->title = 'TEST';
		$book->author = 'AUTHEST';
		$book->save();
	}

	// Render index view
	return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/books/addABook', function (Request $request, Response $response, array $args) {
	$this->logger->info("Requesting the form");

	return $this->renderer->render($response, 'addABook.phtml', $args);
});

$app->post('/books/addABook', function (Request $request, Response $response, array $args) {
	$this->logger->info("Submitting info");

	$args['title'] = $request->getParam('title');
	$args['author'] = $request->getParam('author');

	$this->db;
	$books = $this->db->table('books')->get();
	foreach ($books as $bookIterator) {
		if ($bookIterator->title == $args['title']) {
			return $this->renderer->render($response, 'thanks.phtml', $args);
			break;
		}
	}
	$book = new Books();
	$book->title = $args['title'];
	$book->author = $args['author'];
	$book->save();

	return $this->renderer->render($response, 'thanks.phtml', $args);
});

$app->get('/books/', function (Request $request, Response $response, array $args) {

	$this->db;
	$books = $this->db->table('books')->get();
	$index = 0;
	$response->getBody()->write("<h2>Voici les livres existants : </h2>");

	foreach ($books as $book) {
		$index++;
		$response->getBody()->write("<a href=\"/index.php/books/" . $book->id . "\">");
		$response->getBody()->write("Livre " . $index . "</a>: \"" . $book->title . "\" Ecris par: " . $book->author . "</br></br>");
	}
	return $this->renderer->render($response, 'books.phtml', $args);
});

$app->post('/books/', function (Request $request, Response $response, array $args) {
	$this->logger->info("Submitting info suppr book");

	$bookID = $request->getParam('supp');
	$this->logger->info($bookID);
	$this->db;
	$book = $this->db->table('books')->delete($bookID);

	$books = $this->db->table('books')->get();
	$index = 0;
	$response->getBody()->write("<h2>Voici les livres existants : </h2>");

	foreach ($books as $book) {
		$index++;
		$response->getBody()->write("<a href=\"/books/" . $book->id . "\">");
		$response->getBody()->write("Livre " . $index . "</a>: " . $book->title . "  " . $book->author . "</br></br>");
	}   

	return $this->renderer->render($response, 'books.phtml', $args);
});

$app->get('/books/{bookId}', function (Request $request, Response $response, array $args) {

	$args['func'] = $this;
	return $this->renderer->render($response, 'book.phtml', $args);
});

$app->get('/books/{bookId}/modify', function (Request $request, Response $response, array $args) {

	$args['func'] = $this;
	return $this->renderer->render($response, 'modifyABook.phtml', $args);

});

$app->post('/books/{bookId}/modify', function (Request $request, Response $response, array $args) {
	$this->logger->info("modifying");

	$this->db;
	$bookId = $request->getParam('id');
	$book = $this->db->table('books')->find($bookId);

	$args['title'] = $request->getParam('title');
	$args['author'] = $request->getParam('author');

	$this->db->table('books')->where('id', $bookId)->update(['title' => $args['title']]);
	$this->db->table('books')->where('id', $bookId)->update(['author' => $args['author']]);
	$this->logger->info($book->title);
//	$this->logger->info($book->author);
//	$book->save();

	return $this->renderer->render($response, 'thanks.phtml', $args);
});
