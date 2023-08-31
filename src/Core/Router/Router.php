<?php

namespace App\Core\Router;


use App\Core\Http\Request;

final class Router
{
    /** @var Route[] */
    private $routesCollection = [];
    private $prefix;

    // protected  $methods = array();

    public function __construct(RouteParser $routeParser = null)
    {

        //   $this->routeParser = new RouteParser();
    }

    /**
     * Undocumented function
     *
     * @param string $route
     *
     * @param  $callback
     * @return Route
     */
    public function post(string $route, $callback): Route
    {
        return $this->addRoute(Methods::POST, $route, $callback);
    }


    /**
     * Creates a get route
     * @param string $route
     * @param $callback
     * @return Route
     */
    public function get(string $route, $callback): Route
    {
        return $this->addRoute(Methods::GET, $route, $callback);
    }

    public function addRoute($method, string $route, $callback): Route
    {
        if ($this->prefix) {
            $route = $this->prefix . $route;
        }

        $route = $this->sanitizeRoute($route);

        return $this->routesCollection[$route] = new Route($route, $method, $callback);
    }

    /**
     * @param $route
     * @return string
     */
    private function sanitizeRoute($route): string
    {
        $route = preg_replace('/(\/+)/', '/', $route);
        return rtrim($route, '/');

    }

    public function getCurrentUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        if (strstr($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        return '/' . trim($uri, '/');
    }


    public function dispatch(): void
    {
        $currentURI = $this->getCurrentUri();
        $matched = false;

        foreach ($this->routesCollection as $route) {
            //Match static routes
            if ($route->getRoute() === $currentURI && !$route->hasParams()) {
                $matched = true;
                $this->executeRoute($route);
                break;
            }

            $pattern = $route->getPattern();

            if (preg_match($pattern, $currentURI, $matches)) {
                sage($matches);
                array_shift($matches);
                sage($matches);
                if ($_SERVER['REQUEST_METHOD'] === $route->getMethod()) {
                    $this->executeRoute($route, $matches);
                } else {
                    echo "Unknown method";
                }
                return;
            }
        }
        if (!$matched) {
            http_response_code(404);
            echo "404 Not Found";
        }
    }

    public function group($prefix, $callback)

    {
        $this->prefix = $prefix;
        $callback();
        $this->prefix = '';

    }

    private function executeRoute(Route $route, $params = []): void
    {
        $method = $route->getMethod();
        if ($_SERVER['REQUEST_METHOD'] === $method) {
            $request = new Request($route, $method, $params,);
            $route->run($request);

        } else {
            echo "Unknown method";
        }
    }


    public function listRoutes(): array
    {
        return $this->routesCollection;

    }

}
