<?php

declare(strict_types=1);

error_reporting(E_ALL);
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

use App\Core\Http\Request;
use App\Core\Router\Router;

//TODO: move this in a dedicated router file
$router = new Router();

$router->get('/', function () {
    echo 'welcome home';
});


$router->get('/json', function (Request $request) {
    $data = array("a" => "Apple", "b" => "Ball", "c" => "Cat");
    return response($data);
});


$router->group('/admin/', function () use ($router) {
    $router->get('/hi/', function (Request $request) {
        echo "Hello World";
    });
});
$router->get('/hi', function (Request $request) {
    $prepared = db()->pdo->prepare('INSERT INTO users (email, username) VALUES (?,?)');
    $data = $prepared->execute(['hello@world.com', 'oghgo']);

    echo $data;

});

$router->dispatch();



