<?php



use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function getQueryParams(): array
    {
        return $_GET;
    }
}