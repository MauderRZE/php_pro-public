<?php

use App\Shortener\Helpers\UrlValidator;
use App\Shortener\FileRepo;
use App\Shortener\UrlConverter;
use GuzzleHttp\Client;

require_once __DIR__ . '/../vendor/autoload.php';

$config = [
    'dbfile' => __DIR__ . '/../storage/db.json',
];
$validator = new UrlValidator(new Client());

$save = new FileRepo($config['dbfile']);
$converter = new UrlConverter($validator, $save);

$url = 'https://rada-poltava.gov.ua';
$code = 'pJRBGPg69W';


 try {
     echo $converter->encode($url);
 } catch (\Exception $e) {
     echo 'Erorr' . $e->getMessage();
 }
 echo PHP_EOL;


