<?php

declare(strict_types=1);

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface;
use App\Entities\{Book, Author};
use App\Util\Response;

$app->get('/author', function (Request $request, ResponseInterface $response) use ($app) {

    $authorRepository = $this->get('em')->getRepository('App\Entities\Author');
    $authors = $authorRepository->findAll();

    $response = new Response($response, $authors, 200);
    return $response->getResponse();
});

$app->post('/author', function (Request $request, ResponseInterface $response) use ($app) {

    $params = (object) $request->getParsedBody();

    $author = new Author($params->name);

    $this->get('em')->persist($author);
    $this->get('em')->flush();

    $response = new Response($response, $author, 201);
    return $response->getResponse();
});

$app->get('/book', function (Request $request, ResponseInterface $response) use ($app) {

    $booksRepository = $this->get('em')->getRepository('App\Entities\Book');
    $books = $booksRepository->findAll();

    $response = new Response($response, $books, 200);
    return $response->getResponse();
});

$app->post('/book', function (Request $request, ResponseInterface $response) use ($app) {

    $params = (object) $request->getParsedBody();
    $author_id = $params->author_id;

    $authorRepository = $this->get('em')->getRepository('App\Entities\Author');
    $author = $authorRepository->find($author_id);

    if (!$author)
        return Response::fromError($response, new \Exception('Autor não existe!', 404))->getResponse();

    $book = new Book($params->name, $author);

    $this->get('em')->persist($book);
    $this->get('em')->flush();

    $response = new Response($response, $book, 201);
    return $response->getResponse();
});

$app->get('/book/{id}', function (Request $request, ResponseInterface $response) use ($app) {

    $id = $request->getAttribute('id');

    $booksRepository = $this->get('em')->getRepository('App\Entities\Book');
    $book = $booksRepository->find($id);

    if (!$book)
        return Response::fromError($response, new \Exception('Livro não existe!', 404))->getResponse();

    $response = new Response($response, $book, 200);
    return $response->getResponse();
});

$app->delete('/book/{id}', function (Request $request, ResponseInterface $response) use ($app) {

    $id = $request->getAttribute('id');

    $booksRepository = $this->get('em')->getRepository('App\Entities\Book');
    $book = $booksRepository->find($id);

    if (!$book)
        return Response::fromError($response, new \Exception('Livro não existe!', 404))->getResponse();

    $this->get('em')->remove($book);
    $this->get('em')->flush();

    $response = new Response($response, null, 204);
    return $response->getResponse();
});
