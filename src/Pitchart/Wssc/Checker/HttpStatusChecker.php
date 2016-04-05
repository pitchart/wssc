<?php

namespace Pitchart\Wssc\Checker;

use Pitchart\Wssc\Http\Response;

class HttpStatusChecker implements Checker
{
    public function check(Response $response)
    {
        return $response->getCode() == '301';
    }
}
