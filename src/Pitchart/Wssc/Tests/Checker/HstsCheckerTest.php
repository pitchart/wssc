<?php

namespace Pitchart\Wssc\Tests\Checker;

use Pitchart\Wssc\Checker\Checker;
use Pitchart\Wssc\Checker\HstsChecker;

class HstsCheckerTest extends HeaderCheckerTest {
    /**
     * @var HstsChecker
     */
    protected $checker;

    public function setUp() {
        $this->checker = new HstsChecker();
    }

    public function testCanBeInstanciated() {
        parent::testCanBeInstanciated();
        $this->assertInstanceOf(HstsChecker::class, $this->checker);
    }

}