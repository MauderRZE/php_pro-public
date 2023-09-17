<?php
namespace App\Shortener\Interfaces;
interface IUrlValidator 
{
   /**
    * @param string $url
    * @throws InvalidArgumentException
    * @return bool
    */
   public function validatorUrl (string $url): bool;

   /**
    * @param string $url
    * @throws InvalidArgumentException
    * @return bool
    */

   public function checkUlr (string $url): bool;
}