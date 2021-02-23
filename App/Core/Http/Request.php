<?php

namespace App\Core\Http;

class Request {
    private array $headers;
    private string $method;
    private PostBody $body;
    private GetParams $params;

    public function __construct(PostBody $body, GetParams $params) {
        $this->headers = getallheaders();
        $this->body = $body;
        $this->params = $params;
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function header(string $key): string {
        return $this->headers[$key] ?? null;
    }

    public function hasHeader(string $key): bool {
        return isset($this->headers[$key]);
    }

    public function getMethod() {
        return $this->method;
    }
    
}