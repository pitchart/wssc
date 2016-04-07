<?php

namespace Pitchart\Wssc\Tests\Checker;

use Pitchart\Wssc\Checker\Checker;
use Pitchart\Wssc\Checker\HttpsStatusChecker;
use Pitchart\Wssc\Http\Response;

class HttpsStatusCheckerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HttpsStatusChecker
     */
    protected $checker;

    public function setUp()
    {
        $this->checker = new HttpsStatusChecker();
    }

    public function testCanBeInstanciated()
    {
        $this->assertInstanceOf(Checker::class, $this->checker);
        $this->assertInstanceOf(HttpsStatusChecker::class, $this->checker);
    }

    public function testMustReturnTrueFor200Status()
    {
        $response = Response::fromPlainText('HTTP/1.0 200 OK');
        $this->assertTrue($this->checker->check($response));
    }

    public function testMustReturnFalseForNon301Status()
    {
        $response = Response::fromPlainText('HTTP/1.0 404 NOT FOUND');
        $this->assertFalse($this->checker->check($response));
    }
}
