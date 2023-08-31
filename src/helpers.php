<?php

use App\Core\Http\Response;

function dd($any)
{

    var_dump($any);
    die();

}

/**
 * @param $content
 * @param int $statusCode
 * @return Response
 */
function response($content, int $statusCode = 200): Response
{
    return new Response($content, $statusCode);
}