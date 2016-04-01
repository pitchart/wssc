<?php

namespace Pitchart\Wssc\Checker;

use Pitchart\Wssc\Http\Response;

interface Checker {

    /**
     * @param Response $response
     *
     * @return boolean
     */
    public function check(Response $response);

}