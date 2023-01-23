<?php
declare(strict_types=1);

namespace App\Exceptions;

class UnnamedRouteException extends \Exception
{
    public function __construct(\Illuminate\Routing\Route $route)
    {
        $uri = \Illuminate\Support\Arr::first($route->methods()) . ' /' . ltrim($route->uri(), '/');

        parent::__construct("The current route ($uri) is not named");
    }
}
