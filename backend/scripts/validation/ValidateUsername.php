<?php

namespace Palmo\Core\validation;

use Palmo\Core\service\ValidationRules;

class ValidateUsername implements ValidationRules
{
    use CommonValidation, CyrillicValidation {
        CyrillicValidation::validateMinLength insteadof CommonValidation;
        CyrillicValidation::validateMaxLength insteadof CommonValidation;
    }

    public static function validate($data)
    {
        return match (false) {
            self::validateEmpty($data) => "Login is required",
            self::validateMinLength($data, 3) => "Login must contain at least 3 characters",
            self::validateMaxLength($data, 30) => "The login must contain no more than 30 characters",
            default => null
        };
    }
}
