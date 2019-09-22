<?php

namespace ProxyWrapper;

use Curl\Curl;
use ProxyWrapper\Checker\ProxyCheckerInterface;

class ProxyManager
{
    private  $useProxy = false;
    private $proxyProvider;
    private $checker;

    public function __construct(ProxyProviderInterface $proxyProvider, ProxyCheckerInterface $proxyChecker, bool $useProxy = false)
    {
        $this->useProxy = $useProxy;
        $this->proxyProvider = $proxyProvider;
        $this->checker = $proxyChecker;
    }

    /**
     *
     * @param array $options
     * @return mixed
     */
    public function getProxy(): ?Proxy
    {
        if (!$this->useProxy) {
            return null;
        }

        $proxies = $this->proxyProvider->getProxies();

        foreach ($proxies as $proxy){
            if($this->checker->checkProxy($proxy)){
                return $proxy;
            }
        }

        throw new ProxyException("We has no proxy for tg");
    }
}