<?php

namespace Palmo\Core\validation;

use Palmo\Core\service\ValidationRules;

class ValidatePassword implements ValidationRules
{
    use CommonValidation;
    public static function validate($data)
    {
        return  match (false) {
            self::validateMinLength($data, 6) => "Password must contain at least 6 characters",
            self::validateMaxLength($data, 30) => "Password must contain no more than 30 characters",
            default => null
        };
    }
}
