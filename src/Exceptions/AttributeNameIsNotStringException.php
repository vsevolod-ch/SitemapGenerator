<?php
/**
 * Created by PhpStorm.
 * User: webengineer
 * Date: 01.12.18
 * Time: 22:28
 */

namespace SitemapGenerator\Exceptions;


class AttributeNameIsNotStringException extends \Exception
{

    protected $message = "Название атрибута должно быть строкой.";

}