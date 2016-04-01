<?php

namespace Pitchart\Wssc\Checker;

use Pitchart\Wssc\Http\Response;

class CookieChecker extends HeaderChecker
{
    protected $headerName = 'Set-Cookie';

    protected $matchingPattern = '/(Secure|HttpOnly)+(.*)(Secure|HttpOnly)+/i';

    public function check(Response $response) {
        return parent::check($response)
            || !$response->hasHeader($this->headerName)
        ;
    }
}