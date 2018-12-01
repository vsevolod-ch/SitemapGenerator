<?php
/**
 * Created by PhpStorm.
 * User: webengineer
 * Date: 02.12.18
 * Time: 0:50
 */

namespace SitemapGenerator\Exceptions;


use Exception;

class WriteOpenFailureException extends \Exception
{

    public function __construct($path)
    {
        $this->message = 'Не удалось открыть файл на запись: ' . $path;
    }

}