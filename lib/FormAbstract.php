<?php

/**
 * Created by PhpStorm.
 * User: artem
 * Date: 18.05.17
 * Time: 19:28
 */

abstract class FormAbstract
{
    abstract public function validate();

    abstract public function send();
}