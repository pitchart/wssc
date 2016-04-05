<?php

namespace Pitchart\Wssc\Checker;

use Pitchart\Wssc\Http\Response;

abstract class HeaderChecker implements Checker
{

    /**
     * The header to check
     * @var string
     */
    protected $headerName;

    /**
     * Pattern validating the test
     * @var string
     */
    protected $matchingPattern = '';

    /**
     * @inheritedDoc
     */
    public function check(Response $response)
    {
        return $response->hasHeader($this->headerName)
            && preg_match($this->matchingPattern, $response->getHeader($this->headerName)->getValue());
    }
}
