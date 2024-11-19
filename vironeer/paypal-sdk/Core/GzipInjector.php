<?php

namespace Vironeer\PayPal\Core;

use Vironeer\PayPal\PayPalHttp\Injector;

class GzipInjector implements Injector
{
    public function inject($httpRequest)
    {
        $httpRequest->headers["Accept-Encoding"] = "gzip";
    }
}
