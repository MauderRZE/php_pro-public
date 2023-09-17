<?php
namespace App\Shortener\ValueObjects;
class UrlCodePair 
{
    public function __construct(protected string $code, protected string $url)
    {

    }

    public function getCode(): string 
    {
        return $this->code;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}