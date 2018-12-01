<?php
/**
 * Created by PhpStorm.
 * User: webengineer
 * Date: 01.12.18
 * Time: 22:28
 */

namespace SitemapGenerator\Exceptions;


class AttributeValueIsNotScalarException extends \Exception
{

    protected $message = "Значением атрибута может быть только любое скалярное значение.";

}