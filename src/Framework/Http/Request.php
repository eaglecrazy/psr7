<?php

namespace Framework\Http;

use phpDocumentor\Reflection\Types\This;

class Request
{
    private $queryParams;

    private $parsedBody;

    public function __construct(array $queryParams = [], $parsedBody = null)
    {
        $this->queryParams = $queryParams;
        $this->parsedBody  = $parsedBody;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function withQueryParams(array $query): self
    {
        $new              = clone $this;
        $new->queryParams = $query;
        return $new;
    }

    public function getParsedBody(): ?array
    {
        return $this->parsedBody;
    }

    public function withParsedBody($data): self
    {
        $new             = clone $this;
        $new->parsedBody = $data;
        return $new;
    }
}