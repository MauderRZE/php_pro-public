<?php
namespace App\Shortener;

use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\Interfaces\IRepository;
use App\Shortener\Valueobjects\UrlCodePair;
use http\Exception\InvalidArgumentException;

class FileRepo implements IRepository

{
    protected array $db = [];

    public function __construct (protected string $fileDb)
    {
        $this->getDbFromStorage();
    }

    protected function getDbFromStorage(): void
    {
        if (file_exists($this->fileDb)) {
           $content = file_get_contents($this->fileDb);
           $this->db = (array)json_decode($content, true);
        }
    }

    /**
     * @param UrlCodePair $urlUrlCodePair
     * @return bool
     */
    public function saveEntity(UrlCodePair $urlUrlCodePair): bool
    {
        $this->db[$urlUrlCodePair->getCode()] = $urlUrlCodePair->getUrl();
        return true;
    }

     /**
     *@param string $url
     *@return string code
     */
    public function getShortCod(string $url): string 
    {
       if (!$code = array_search($url, $this->db)) {
         throw new DataNotFoundException();
       }
       return $code;
    }
              
    

/**
 * @param string $code
 * @return string url
 * 
 */
    public function getUrl(string $code): string 
    {
        if (!$this->codeIsset($code)) {
            throw new DataNotFoundException();
        } 
        return $this->db[$code];
    }

    
    /**
     * @param string $code
     * @return bool
     */

    public function codeIsset(string $code): bool
    {
        return isset($this->db[$code]);
    }

    protected function writeToStorage(string $content)
    {
        $file = fopen($this->fileDb, 'w+');
        fwrite($file, $content);
        fclose($file);
    }

    public function __destruct()
    {
        $this->writeToStorage(json_encode($this->db));
    }


}