<?php

namespace Palmo\Core\validation;

use Palmo\Core\service\ValidationRules;

class ValidateTitle implements ValidationRules
{
    use CommonValidation, CyrillicValidation {
        CyrillicValidation::validateMinLength insteadof CommonValidation;
        CyrillicValidation::validateMaxLength insteadof CommonValidation;
    }

    public static function validate($data)
    {
        return match (false) {
            self::validateEmpty($data) => "Title is required",
            self::validateMinLength($data, 3) => "Title must contain at least 3 characters",
            self::validateMaxLength($data, 100) => "Title must contain no more than 100 characters",
            default => null
        };
    }
}
