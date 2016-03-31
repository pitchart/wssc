<?php

namespace Pitchart\Wssc\Http;

class Header {

    private $name;

    private $value;

    public function __construct($name, $value) {
        $this->name = $name;
        $this->value = $value;
    }

    public function fromPlainText($header) {
        $header = explode(':', $header);
        $header = array_map('trim', $header);
        return new self($header[0], $header[1]);
    }

    public function __toString() {
        return sprintf('%s: %s', $this->name, $this->value);
    }
}