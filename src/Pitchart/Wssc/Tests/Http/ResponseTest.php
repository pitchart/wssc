<?php

namespace Pitchart\Wssc\Tests\Http;

use Pitchart\Wssc\Http\Response;
use Pitchart\Wssc\Http\Header;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    
    public function testCanBeInstanciated() {
        $headers = [
            'Date: Fri, 31 Dec 1999 23:59:59 GMT',
            'Server: Apache/0.8.4',
            'Content-Type: text/html',
            'Content-Length: 42',
            'Expires: Sat, 01 Jan 2000 00:59:59 GMT',
            'Last-modified: Fri, 09 Aug 1996 14:21:40 GMT',
        ];

        $content = '<TITLE>Exemple</TITLE>
<P>Lorem ipsum.</P>';

        $response = new Response('1.0', '200', 'OK', $headers, $content);
        $this->assertInstanceOf(Response::class, $response);
    }

    /**
     * @dataProvider plainTextResponseProvider
     */
    public function testCanBeCreateByPlainTextResponse($plainTextResponse) {
        $response = Response::fromPlainText($plainTextResponse);
        $this->assertInstanceOf(Response::class, $response);
    }

    /**
     * @dataProvider plainTextResponseProvider
     */
    public function testIsValidWhenCreatedByPlainTextResponse($plainTextResponse) {
        $response = Response::fromPlainText($plainTextResponse);
        $this->assertEquals('200', $response->getCode());
        $this->assertEquals('HTTP/1.0', $response->getVersion());
        $this->assertEquals([
            'Date' => new Header('Date', 'Fri, 31 Dec 1999 23:59:59 GMT'),
            'Server' => new Header('Server', 'Apache/0.8.4'),
            'Content-Type' => new Header('Content-Type', 'text/html'),
            'Content-Length' => new Header('Content-Length', '42'),
            'Expires' => new Header('Expires', 'Sat, 01 Jan 2000 00:59:59 GMT'),
            'Last-modified' => new Header('Last-modified', 'Fri, 09 Aug 1996 14:21:40 GMT'),
        ], $response->getHeaders());
        $this->assertEquals('<TITLE>Exemple</TITLE>
<P>Lorem ipsum.</P>
', $response->getContent());
    }

    /**
     * Provides a plaint text HTTP response
     */
    public function plainTextResponseProvider() {
        return array(
            array(
'HTTP/1.0 200 OK
Date: Fri, 31 Dec 1999 23:59:59 GMT
Server: Apache/0.8.4
Content-Type: text/html
Content-Length: 42
Expires: Sat, 01 Jan 2000 00:59:59 GMT
Last-modified: Fri, 09 Aug 1996 14:21:40 GMT

<TITLE>Exemple</TITLE>
<P>Lorem ipsum.</P>
'           )
        );
    }

}