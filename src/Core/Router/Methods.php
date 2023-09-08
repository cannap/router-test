<?php

namespace App\Core\Router;
//TODO: not sure  need this here...
class Methods
{
    const POST = "POST";
    const GET = 'GET';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';
    const ANY = "ANY";
    const HEAD = "HEAD"; // this can be handled as GET in most times

    const OPTION = "OPTION";    //not sure but it is used for preflight to check cors allowed
}
