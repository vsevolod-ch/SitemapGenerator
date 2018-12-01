<?php
/**
 * Created by PhpStorm.
 * User: webengineer
 * Date: 30.11.18
 * Time: 13:18
 */

namespace SitemapGenerator\Exceptions;


class SitemapLoadFailureException extends \Exception
{

    public function __construct($path)
    {
        $this->message = 'Не удалось загрузить xml карты сайта: ' . $path;
    }

}