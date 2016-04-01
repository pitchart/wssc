<?php

namespace Pitchart\Wssc\Http;

class Response {

    private $version;

    private $statusCode;

    private $statusText;

    private $headers;

    private $content;

    public function __construct($version, $statusCode, $statusText, $headers, $content) {
        $this->version = $version;
        $this->statusCode = $statusCode;
        $this->$statusText = $statusText;
        $this->headers = $headers;
        $this->content = $content;
    }

    public static function fromPlainText($response) {
        $response = explode(chr(10), $response);
        $response = array_map('trim', $response);

        $statusLine = array_shift($response);
        if (!preg_match('#^(?P<version>(HTTP|http)/[0-9.]+)\s(?P<code>\d{3})\s(?P<text>.+)$#', $statusLine, $matches)) {
            throw new \Exception('Invalid status line');
        }

        $separator = array_search('', $response);
        $headers = array_slice($response, 0, $separator);
        $headers = array_map(function($item) { return  Header::fromPlainText($item);}, $headers);
        $content = array_slice($response, $separator+1);
        return new self($matches['version'], $matches['code'], $matches['text'], $headers, implode(chr(10), $content));
    }

    public function getVersion() {
        return $this->version;
    }

    public function getCode() {
        return $this->statusCode;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getContent() {
        return $this->content;
    }

    public function getHeader($name) {

    }
}