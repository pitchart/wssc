<?php

namespace Pitchart\Wssc\Tests\Checker;

use Pitchart\Wssc\Checker\FrameEmbedChecker;

class FrameEmbedCheckerTest extends HeaderCheckerTest
{

    /**
     * @var FrameEmbedChecker
     */
    protected $checker;

    public function setUp()
    {
        $this->checker = new FrameEmbedChecker();
    }

    public function testCanBeInstanciated()
    {
        parent::testCanBeInstanciated();
        $this->assertInstanceOf(FrameEmbedChecker::class, $this->checker);
    }
}
