<?php

namespace Pitchart\Wssc\Tests\Checker;

use Pitchart\Wssc\Checker\Checker;
use Pitchart\Wssc\Checker\HttpStatusChecker;
use Pitchart\Wssc\Http\Response;

class HttpStatusCheckerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HttpStatusChecker
     */
    protected $checker;

    public function setUp()
    {
        $this->checker = new HttpStatusChecker();
    }

    public function testCanBeInstanciated()
    {
        $this->assertInstanceOf(Checker::class, $this->checker);
        $this->assertInstanceOf(HttpStatusChecker::class, $this->checker);
    }

    public function testMustReturnTrueFor301Status()
    {
        $response = Response::fromPlainText('HTTP/1.0 301 MOVED PERMANENTLY');
        $this->assertTrue($this->checker->check($response));
    }

    public function testMustReturnFalseForNon301Status()
    {
        $response = Response::fromPlainText('HTTP/1.0 200 OK');
        $this->assertFalse($this->checker->check($response));
    }
}
