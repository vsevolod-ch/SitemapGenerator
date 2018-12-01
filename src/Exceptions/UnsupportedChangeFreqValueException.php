<?php
/**
 * Created by PhpStorm.
 * User: webengineer
 * Date: 01.12.18
 * Time: 22:51
 */

namespace SitemapGenerator\Exceptions;


class UnsupportedChangeFreqValueException extends \Exception
{

    public function __construct($msg)
    {
        $this->message = "Недопустимое значение поля changefreq: " . (string)$msg;
    }

}