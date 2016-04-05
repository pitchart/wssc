<?php

namespace Pitchart\Wssc\Http;

class Header
{

    private $name;

    private $value;

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public static function fromPlainText($header)
    {
        $header = explode(':', $header);
        $name = array_shift($header);
        return new self(trim($name), trim(implode(':', $header)));
    }

    public function __toString()
    {
        return sprintf('%s: %s', $this->name, $this->value);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }
}
