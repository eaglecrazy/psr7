<?php

namespace Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Framework\Http\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Zend\Diactoros\Response;
use Zend\Stratigility\Utils;

class PrettyErrorResponseGenerator implements ErrorResponseGenerator
{
    private TemplateRenderer $template;
    private array $views;
    private Response $response;

    public function __construct(TemplateRenderer $template, Response $response, array $views)
    {
        $this->template = $template;
        $this->views    = $views;
        $this->response = $response;
    }

    public function generate(ServerRequestInterface $request, Throwable $e): ResponseInterface
    {
        $code = Utils::getStatusCode($e, $this->response);
        $view = $this->getView($code);

        $response = $this->response->withStatus($code);

        $response->getBody()->write(
            $this->template->render($view, [
                    'request'   => $request,
                    'exception' => $e,
                ])
        );

        return $response;
    }

    private function getView(int $code): string
    {
        if (array_key_exists($code, $this->views)) {
            $view = $this->views[$code];
        } else {
            $view =  $this->views['error'];
        }
        return $view;
    }
}
