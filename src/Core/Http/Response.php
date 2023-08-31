<?php

namespace App\Core\Http;
class Response
{

    private $headers = [];

    private $content;

    private $contentType = "application/json";
    private $statusCode;

    public function __construct($content, $statusCode = 200)
    {
        $this->statusCode = $statusCode;
        $this->content = $content;
    }

    public function send()
    {

        $content = $this->content;

        if ($this->contentType === "application/json") {
            $content = json_encode($content);
        }
        $this->buildResponse();
        echo $content;
    }


    private function buildResponse()
    {

        header_remove("X-Powered-By");
        header_remove("server");
        header("Content-Type: $this->contentType");
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }


        http_response_code($this->statusCode);

    }

    /**
     * Add a Header item
     * @param $prop
     * @param $value
     * @return Response
     */
    public function header($prop, $value): Response
    {
        $this->headers[$prop] = $value;
        return $this;
    }

}