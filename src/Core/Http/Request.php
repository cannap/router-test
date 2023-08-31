<?php

namespace App\Core\Http;


class Request
{

    private $parsedRoute;
    private $params = [];
    private $method;

    /**
     * @param $route
     * @param $method
     * @param array $params
     */
    public function __construct($route, $method, array $params = [])
    {
        $this->method = $method;
        $this->params = $params;
        $this->parsedRoute = parse_url($_SERVER['REQUEST_URI']);
    }


    public function params(): array
    {
        return $this->params;
    }

    public function input($param)
    {
        return $this->params[$param];
    }

}
