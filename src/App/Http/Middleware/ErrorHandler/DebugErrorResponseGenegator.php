<?php

namespace App\Http\Middleware\ErrorHandler;

use App\Http\Middleware\ErrorHandler;

use Framework\Http\Template\TemplateRenderer;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

use Zend\Diactoros\Response;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Stratigility\Utils;

class DebugErrorResponseGenegator implements ErrorHandler\ErrorResponseGenegator
{
    private TemplateRenderer $template;
    private string $view;
    private Response $response;

    public function __construct(TemplateRenderer $template,  Response $response,  string $view)
    {
        $this->template = $template;
        $this->view    = $view;
        $this->response = $response;
    }

    public function generate(ServerRequestInterface $request, Throwable $e): ResponseInterface
    {
        $response = $this->response->withStatus(Utils::getStatusCode($e, $this->response));

        $response
            ->getBody()
            ->write($this->template->render($this->view, [
                'request' => $request,
                'exception' => $e,
            ]));

        return $response;
    }
}