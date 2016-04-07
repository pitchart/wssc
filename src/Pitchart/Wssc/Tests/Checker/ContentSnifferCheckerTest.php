<?php

namespace Pitchart\Wssc\Tests\Checker;

use Pitchart\Wssc\Checker\Checker;
use Pitchart\Wssc\Checker\ContentSnifferChecker;

class ContentSnifferCheckerTest extends HeaderCheckerTest
{
    /**
     * @var ContentSnifferChecker
     */
    protected $checker;

    public function setUp()
    {
        $this->checker = new ContentSnifferChecker();
    }

    public function testCanBeInstanciated()
    {
        parent::testCanBeInstanciated();
        $this->assertInstanceOf(ContentSnifferChecker::class, $this->checker);
    }
}
