<?php

namespace Pitchart\Wssc\Tests\Http;

use Pitchart\Wssc\Http\Header;

class HeaderTest extends \PHPUnit_Framework_TestCase
{

    public function testCanBeInstantiated() {
        $header = new Header('Content-Type', 'text/html');
        $this->assertInstanceOf(Header::class, $header);
    }

    public function testCanBeCreatedFromPlainText() {
        $header = Header::fromPlainText('Content-Type: text/html');
        $this->assertInstanceOf(Header::class, $header);
    }

    public function testCanBeConvertedAsString() {
        $header = new Header('Content-Type', 'text/html');
        $this->assertEquals('Content-Type: text/html', (string) $header);

        $header = Header::fromPlainText('Content-Type: text/html');
        $this->assertEquals('Content-Type: text/html', (string) $header);
    }
}