<?php
namespace App\Shortener\Interfaces;
use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\ValueObjects\UrlCodePair;

interface IRepository


{
    /**
     * @param string $url
     * @throws DataNotFoundException
     * @return string code
     */
    public function getShortCod(string $url): string;
              
    

/**
 * @param string $code
 * @throws DataNotFoundException
 * @return string url
 * 
 */
    public function getUrl(string $code): string;

    /**
     * @param UrlCodePair $urlUrlCodePair
     * @return bool
     */
    public function saveEntity(UrlCodePair $urlUrlCodePair): bool;

    /**
     * @param string $code
     * @return bool
     */

    public function codeIsset(string $code): bool;

    
}