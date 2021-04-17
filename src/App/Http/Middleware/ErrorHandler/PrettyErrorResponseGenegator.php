<?php

namespace App\Http\Middleware\ErrorHandler;

use App\Http\Middleware\ErrorHandler;

use Framework\Http\Template\TemplateRenderer;

use phpDocumentor\Reflection\Types\This;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Zend\Diactoros\Response;
use Zend\Stratigility\Utils;

class  PrettyErrorResponseGenegator implements ErrorHandler\ErrorResponseGenegator
{

    private TemplateRenderer $template;
    private array $views;
    private ResponseInterface $response;

    public function __construct(TemplateRenderer $template, ResponseInterface $response, array $views)
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
                ]
        ));

        return $response;
    }

    private function getView(int $code)
    {
        if(array_key_exists($code, $this->views)){
            return $this->views[$code];
        } else {
            return $this->views['error'];
        }
    }

}