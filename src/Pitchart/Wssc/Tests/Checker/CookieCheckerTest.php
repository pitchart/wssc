<?php

namespace Pitchart\Wssc\Tests\Checker;

use Pitchart\Wssc\Checker\Checker;
use Pitchart\Wssc\Checker\CookieChecker;

class CookieCheckerTest extends HeaderCheckerTest
{
    /**
     * @var Checker
     */
    protected $checker;

    public function setUp()
    {
        $this->checker = new CookieChecker();
    }

    public function testCanBeInstanciated()
    {
        parent::testCanBeInstanciated();
        $this->assertInstanceOf(CookieChecker::class, $this->checker);
    }
}
