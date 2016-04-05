<?php

namespace Pitchart\Wssc\Http;

class Response
{

    /**
     * @var string
     */
    private $version;

    /**
     * @var integer
     */
    private $statusCode;

    /**
     * @var string
     */
    private $statusText;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var string
     */
    private $content;

    public function __construct($version, $statusCode, $statusText, $headers, $content)
    {
        $this->version = $version;
        $this->statusCode = $statusCode;
        $this->$statusText = $statusText;
        $this->headers = $this->parseHeaders($headers);
        $this->content = $content;
    }

    public static function fromPlainText($response)
    {
        $response = explode(chr(10), $response);
        $response = array_map('trim', $response);

        $statusLine = array_shift($response);
        if (!preg_match('#^(?P<version>(HTTP|http)/[0-9.]+)\s(?P<code>\d{3})\s(?P<text>.+)$#', $statusLine, $matches)) {
            throw new \Exception('Invalid status line');
        }

        $separator = array_search('', $response);
        $headers = array_slice($response, 0, $separator);
        $headers = array_map(function ($item) {
            return  Header::fromPlainText($item);

        }, $headers);
        $content = array_slice($response, $separator+1);
        return new self($matches['version'], $matches['code'], $matches['text'], $headers, implode(chr(10), $content));
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->statusCode;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasHeader($name)
    {
        return array_key_exists($name, $this->headers);
    }

    /**
     * @param $name
     * @return Header
     */
    public function getHeader($name)
    {
        if ($this->hasHeader($name)) {
            return $this->headers[$name];
        }
        return null;
    }

    /**
     * @param array $headers
     * @return array
     */
    private function parseHeaders(array $headers)
    {
        $return = [];
        foreach ($headers as $header) {
            $return = array_merge($return, $this->parseHeader($header));
        }
        return $return;
    }

    /**
     * @param $header
     * @return array
     */
    private function parseHeader($header)
    {
        if (!($header instanceof Header)) {
            $header = Header::fromPlainText($header);
        }

        return array($header->getName() => $header);
    }
}
