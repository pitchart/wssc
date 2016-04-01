<?php

namespace Pitchart\Wssc\Checker;

use Pitchart\Wssc\Http\Response;
use Curl\Curl;

class CheckerChain {

    private $curlChecks = array(
        'http' => array(),
        'https' => array(),
    );

    private $results = array();

    public function addCurlCheck(Checker $checker, $type, $alias) {
        $this->curlChecks[$type][$alias] = $checker;
    }

    public function getResults() {
        return $this->results;
    }

    public function processChecks($url) {
        if (!preg_match('/^http/i', $url)) {
            $url = 'http://'.$url;
        }
        $urlParts = parse_url($url);

        $curl = new Curl();
        $urlParts['scheme'] = 'https';
        $curl->get($this->buildUrl($urlParts));
        $httpsResponse = Response::fromPlainText(implode(chr(10), $curl->response_headers).chr(10).chr(10));

        $urlParts['scheme'] = 'http';
        $curl->get($this->buildUrl($urlParts));
        $httpResponse = Response::fromPlainText(implode(chr(10), $curl->response_headers).chr(10).chr(10));

        foreach ($this->curlChecks['http'] as $alias => $check) {
            $this->results[$alias] = $check->check($httpResponse);
        }
        foreach ($this->curlChecks['https'] as $alias => $check) {
            $this->results[$alias] = $check->check($httpsResponse);
        }
    }

    private function buildUrl(array $urlParts) {
        return sprintf('%s://%s%s', $urlParts['scheme'], $urlParts['host'], isset($urlParts['path']) ? $urlParts['path'] : '/');
    }


}