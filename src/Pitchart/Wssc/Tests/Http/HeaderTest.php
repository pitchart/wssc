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

    /**
     * @dataProvider headerLinesProvider
     */
    public function testCanBeConvertedAsString($headerName, $headerValue, $headerLine) {
        $header = new Header($headerName, $headerValue);
        $this->assertEquals($headerLine, (string) $header);

        $header = Header::fromPlainText($headerLine);
        $this->assertEquals($headerLine, (string) $header);
    }

    /**
     * Fourni différent types d'entêtes HTTP
     */
    public function headerLinesProvider() {
        return array(
            'Simple header' => array('Content-Type', 'text/html', 'Content-Type: text/html'),
            'Header containing date' => array('Last-modified', 'Fri, 09 Aug 1996 14:21:40 GMT', 'Last-modified: Fri, 09 Aug 1996 14:21:40 GMT'),
        );
    }
}