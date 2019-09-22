<?php

namespace ProxyWrapper\Checker;

use ProxyWrapper\Proxy;

interface ProxyCheckerInterface
{
    public function checkProxy(?Proxy $proxy, array $options = []);
}