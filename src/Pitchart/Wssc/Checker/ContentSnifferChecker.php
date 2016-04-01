<?php

namespace Pitchart\Wssc\Checker;

class ContentSnifferChecker extends HeaderChecker {
    
    protected $headerName = 'X-Content-Type-Options';

    protected $matchingPattern = '#(nosniff)#i';
}