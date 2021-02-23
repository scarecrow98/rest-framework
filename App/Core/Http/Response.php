<?php

namespace App\Core\Http;

class Response {
    private array $headers = [];

    public function __construct() {
        
    }

    public function setHeaders(array $headers) {
        $this->headers = array_merge($headers, $this->headers);
    }

    public function header(string $header, $value) {
        $this->headers[$header] = $value;
    }

    public function removeHeader(string $header) {
        unset($this->headers[$header]);
    }

    public function json($data = []) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function text(string | null $text) {
        header('Content-Type: text/html');
        echo $text;
    }
}