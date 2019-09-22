<?php


namespace ProxyWrapper\Checker;


use Curl\Curl;
use ProxyWrapper\Proxy;

class DefaultChecker implements ProxyCheckerInterface
{

    public function checkProxy(?Proxy $proxy, array $options = [])
    {
        $ch = new Curl("https://api.telegram.org");
        $options = array_merge_recursive($options, $this->getDefaultOptions());

        $userAgent
            = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
        $ch->setOpts([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_HEADER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        $ch->setUserAgent($userAgent);
        $ch->setConnectTimeout($options['connection_timeout'] ?? 30);
        $ch->setTimeout($options['timeout'] ?? 30);

        $ch->setProxy($proxy->toUrl());
        $ch->setProxyType($proxy->getCurlProxy());
        $ch->setOpt(CURLOPT_HTTPPROXYTUNNEL, true);
        if (!empty($proxy->getUsername())) {
            $ch->setProxyAuth($proxy->toAuthString());
        }
        $output = $ch->exec();

        if ($ch->getCurlErrorCode() !== 0) {
            return false;
        }

        //
        $header = $ch->getResponseHeaders()['etag'] ?? null;

        if (!is_null($header)) {
            return false;
        }

        return true;
    }

    private function getDefaultOptions(){
        return [
            'connection_timeout'=>30,
            'timeout'=>30,
            'curl'=>[
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_HEADER => true,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
            ],
            'test_url'=>'https://api.telegram.org',
            'user_agent'=>'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0'
        ];
    }
}