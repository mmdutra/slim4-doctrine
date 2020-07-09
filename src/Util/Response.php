<?php

declare(strict_types=1);

namespace App\Util;

use \Psr\Http\Message\ResponseInterface;

class Response
{
    private ResponseInterface $response;

    /** @var mixed */
    private $data;

    private int $status;

    public function __construct($response, $data, int $status = 200)
    {
        $this->response = $response;
        $this->status = $status;
        $this->data = $data;
    }

    public static function fromError($response, \Throwable $error)
    {
        return new self($response, ['message' => $error->getMessage()], $error->getCode());
    }

    public function getResponse(): ResponseInterface
    {
        $data = ["data" => $this->data];

        $this->response->getBody()->write(json_encode($data));

        return $this->response->withStatus($this->status)->withHeader('Content-type', 'application/json; charset=utf-8');
    }
}
