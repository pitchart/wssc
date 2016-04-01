<?php

namespace Pitchart\Wssc\Tests\Checker;

use Pitchart\Wssc\Checker\Checker;
use Pitchart\Wssc\Checker\HeaderChecker;
use Pitchart\Wssc\Http\Response;

abstract class HeaderCheckerTest extends \PHPUnit_Framework_TestCase
{
    

    public function testCanBeInstanciated() {
        $this->assertInstanceOf(Checker::class, $this->checker);
        $this->assertInstanceOf(HeaderChecker::class, $this->checker);
    }

    /**
     * @dataProvider validResponseProvider
     */
    public function testReturnsTrueForValidResponses($response) {
        $this->assertTrue($this->checker->check($response));
    }

    /**
     * @dataProvider invalidResponseProvider
     */
    public function testReturnsFalseForInvalidResponses($response) {
        $this->assertFalse($this->checker->check($response));
    }

    public function validResponseProvider() {
        return array(
            array(Response::fromPlainText('HTTP/1.0 200 OK
Date: Fri, 31 Dec 1999 23:59:59 GMT
Server: Apache/0.8.4
Content-Type: text/html
Content-Length: 42
Expires: Sat, 01 Jan 2000 00:59:59 GMT
Last-modified: Fri, 09 Aug 1996 14:21:40 GMT
X-Frame-Options: SAMEORIGIN
X-Content-Type-Options: nosniff
Set-Cookie: ****;Path=/;Expires=Fri, 16-Mar-2018 19:18:51 GMT;Secure;HttpOnly;Priority=HIGH
Strict-Transport-Security: max-age=63072000; includeSubdomains;

<TITLE>Exemple</TITLE>
<P>Lorem ipsum.</P>
')),
            array(Response::fromPlainText('HTTP/1.0 200 OK
Date: Fri, 31 Dec 1999 23:59:59 GMT
Server: Apache/0.8.4
Content-Type: text/html
Content-Length: 42
Expires: Sat, 01 Jan 2000 00:59:59 GMT
Last-modified: Fri, 09 Aug 1996 14:21:40 GMT
X-Frame-Options: DENY
X-Content-Type-Options: nosniff
Strict-Transport-Security: max-age=63072000; includeSubdomains;

<TITLE>Exemple</TITLE>
<P>Lorem ipsum.</P>
')),
        );
    }

    public function invalidResponseProvider() {
        return array(
            'Security headers not defined' => array(Response::fromPlainText('HTTP/1.0 200 OK
Date: Fri, 31 Dec 1999 23:59:59 GMT
Server: Apache/0.8.4
Content-Type: text/html
Content-Length: 42
Expires: Sat, 01 Jan 2000 00:59:59 GMT
Last-modified: Fri, 09 Aug 1996 14:21:40 GMT
Set-Cookie: ****;Path=/;Expires=Fri, 16-Mar-2018 19:18:51 GMT;Priority=HIGH

<TITLE>Exemple</TITLE>
<P>Lorem ipsum.</P>
')),
            'Security headers with invalid definitions' => array(Response::fromPlainText('HTTP/1.0 200 OK
Date: Fri, 31 Dec 1999 23:59:59 GMT
Server: Apache/0.8.4
Content-Type: text/html
Content-Length: 42
Expires: Sat, 01 Jan 2000 00:59:59 GMT
Last-modified: Fri, 09 Aug 1996 14:21:40 GMT
X-Frame-Options: ALLOW
X-Content-Type-Options: sniff
Set-Cookie: ****;Path=/;Expires=Fri, 16-Mar-2018 19:18:51 GMT;Secure;Priority=HIGH

<TITLE>Exemple</TITLE>
<P>Lorem ipsum.</P>
')),
            'Security headers with invalid definition for cookies' => array(Response::fromPlainText('HTTP/1.0 200 OK
Date: Fri, 31 Dec 1999 23:59:59 GMT
Server: Apache/0.8.4
Content-Type: text/html
Content-Length: 42
Expires: Sat, 01 Jan 2000 00:59:59 GMT
Last-modified: Fri, 09 Aug 1996 14:21:40 GMT
X-Frame-Options: ALLOW
X-Content-Type-Options: sniff
Set-Cookie: ****;Path=/;Expires=Fri, 16-Mar-2018 19:18:51 GMT;HttpOnly;Priority=HIGH

<TITLE>Exemple</TITLE>
<P>Lorem ipsum.</P>
')),
        );
    }
}

