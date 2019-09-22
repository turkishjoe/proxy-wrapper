<?php

namespace ProxyWrapper;

interface ProxyProviderInterface
{
    public function getProxies($options = []);
}