<?php

namespace Palmo\Core\validation;

trait CyrillicValidation
{
    public static function validateMinLength($data, $minLength)
    {
        return mb_strlen($data) > $minLength;
    }

    public static function validateMaxLength($data, $maxLength)
    {
        return mb_strlen($data) < $maxLength;
    }
}
