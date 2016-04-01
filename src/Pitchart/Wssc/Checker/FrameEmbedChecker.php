<?php

namespace Pitchart\Wssc\Checker;

class FrameEmbedChecker extends HeaderChecker {
    
    protected $headerName = 'X-Frame-Options';

    protected $matchingPattern = '#(SAMEORIGIN|DENY)#i';
}