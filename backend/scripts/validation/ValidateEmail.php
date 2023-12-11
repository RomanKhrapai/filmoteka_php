<?php

namespace Palmo\Core\validation;

use Palmo\Core\service\ValidationRules;

class ValidateEmail implements ValidationRules
{
    use CommonValidation;

    public static function validate($data)
    {
        $result = match (false) {
            self::validateEmail($data) => "Invalid email format",
            self::validateEmpty($data) => "Email is required",
            default => null
        };

        return $result;
    }

    private static function validateEmail($data)
    {
        return filter_var($data, FILTER_VALIDATE_EMAIL) ? true : false;
    }
}
