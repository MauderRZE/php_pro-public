<?php
namespace App\Shortener\Helpers;


use App\Shortener\Interfaces\IUrlValidator;
use InvalidArgumentException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\ClientInterface;

class UrlValidator implements IUrlValidator
{

    public function __construct (protected ClientInterface $client)
    {

    }

    public function validatorUrl(string $url): bool
    {
       if (empty($url)
           || !filter_var($url, FILTER_VALIDATE_URL)) {
           throw new InvalidArgumentException('url is broken');
        }
        return true;
    }

    public function checkUlr(string $url): bool
    {
        $allowCodes = [
            208, 281, 301, 302
        ];
        try {
            $response = $this->client->request('GET', $url);
            return (!empty($response->getStatusCode()) && in_array($response->getStatusCode(), $allowCodes));
        } catch (ConnectException $exception) {
            throw new InvalidArgumentException($exception->getMessage(), $exception->getCode());
        }
    }

}

