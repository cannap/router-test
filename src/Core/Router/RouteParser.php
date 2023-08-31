<?php

namespace App\Core\Router;


class RouteParser
{
    //from ChatGPT
    const VARIABLE_REGEX = '/\{\s*([a-zA-Z0-9_]+)\s*}\??/';

    /**
     * @param string $route
     * @return array|null
     * @todo WIP here we parse
     *
     */
    public function parse(string $route): ?array

    {
        //Check for static routes without {}
        return $this->extractParameters($route);
    }

    /**
     * @param string $route
     * @return string[][]|void
     */
    public function extractParameters(string $route)
    {
        if (preg_match_all(self::VARIABLE_REGEX, $route, $out, PREG_OFFSET_CAPTURE | PREG_SET_ORDER)) {
            return $out;
        }
    }


    /**
     *  Escapes forward slashes in the route string to ensure they are treated as literal characters
     *  in the resulting regular expression pattern.
     * @param string $route
     * @return string
     */
    public function buildRoutePattern(string $route): string
    {
        $pattern = preg_replace('/\//', '\\/', $route);
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_-]+)', $pattern);
        $pattern .= '\/?';
        return "/^$pattern$/";
    }
}
