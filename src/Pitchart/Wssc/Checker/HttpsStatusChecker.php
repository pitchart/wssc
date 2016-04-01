<?php

namespace Pitchart\Wssc\Checker;

use Pitchart\Wssc\Http\Response;

class HttpsStatusChecker implements Checker {
    
    public function check(Response $response) {
        return $response->getCode() == '200';
    }
}