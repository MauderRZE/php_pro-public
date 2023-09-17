<?php
namespace App\Shortener;

use App\Shortener\Interfaces\IUrlDecoder;
use App\Shortener\Interfaces\IUrlEncoder;
use App\Shortener\Interfaces\IUrlValidator;
use App\Shortener\Interfaces\IRepository;
use InvalidArgumentException;
use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\ValueObjects\UrlCodePair;



class UrlConverter implements IUrlEncoder, IUrlDecoder


{
    public function __construct (protected IUrlValidator  $validator, protected IRepository $repository)
    {

    }
    public function encode(string $url): string
    {
        $this->validateUrl($url);
        try {
            $code = $this->repository->getShortCod($url);
        } catch (DataNotFoundException) {
            $code = $this->generateAndSaveCode($url);

        }
        return $code;
    }

    

    public function decode (string $code): string
    {
        try {
            $code = $this->repository->getUrl($code);
        } catch (DataNotFoundException $e) {
            throw new InvalidArgumentException (
                $e->getMessage(),
                $e->getCode(),
            );
        }
       
        return $code;
    }
    protected function generateAndSaveCode ($url):string
    {
        $code = $this->generateUniqueCode();
        $this->repository->saveEntity(new UrlCodePair($code, $url));
        return $code;
    }
    protected function validateUrl(string $url): bool
    {
        $result = $this->validator->validatorUrl($url);
        $this->validator->checkUlr($url);
        return $result;
    }

    protected function generateUniqueCode(): string
    {
        $chars = '1234567890abcdefghgklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($chars), 0, 10);
        return $code;
    }
    
}