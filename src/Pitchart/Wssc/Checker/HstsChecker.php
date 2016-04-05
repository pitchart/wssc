<?php

namespace Pitchart\Wssc\Checker;

class HstsChecker extends HeaderChecker
{

    protected $headerName = 'Strict-Transport-Security';

    protected $matchingPattern = '#max-age=*#';
}
