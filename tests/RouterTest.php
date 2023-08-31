<?php

use App\Core\Router\Route;
use App\Core\Router\Router;
use PHPUnit\Framework\TestCase;


class RouterTest extends TestCase
{
    public function testAddRoute()
    {
        $router = new Router();
        $route = $router->addRoute('GET', '/test', function () {
        });

        $this->assertInstanceOf(Route::class, $route);
        $this->assertEquals('/test', $route->getRoute());
    }


    public function testDispatchWithMatchingRoute()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/test';

        $router = new Router();
        $router->addRoute('GET', '/test', function () {
            echo 'Test Route';
        });

        ob_start();
        $router->dispatch();
        $output = ob_get_clean();

        $this->assertEquals('Test Route', $output);
    }

    public function testDispatchWithUnknownRoute()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/unknown';

        $router = new Router();

        ob_start();
        $router->dispatch();
        $output = ob_get_clean();

        $this->assertEquals('404 Not Found', $output);
        $this->assertEquals(404, http_response_code());
    }


    public function testUnknownMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/test';

        $router = new Router();
        $router->addRoute('GET', '/test', function () {
        });

        ob_start();
        $router->dispatch();
        $output = ob_get_clean();

        $this->assertEquals('Unknown method', $output);
    }
}
