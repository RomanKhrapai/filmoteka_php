<?php

namespace Palmo\Core\validation;

use Palmo\Core\service\ValidationRules;

class ValidateAbout implements ValidationRules
{
    use CommonValidation, CyrillicValidation {
        CyrillicValidation::validateMinLength insteadof CommonValidation;
        CyrillicValidation::validateMaxLength insteadof CommonValidation;
    }

    public static function validate($data)
    {
        return match (false) {
            self::validateEmpty($data) => "Title is required",
            self::validateMinLength($data, 20) => "Title must contain at least 20 characters",
            self::validateMaxLength($data, 500) => "Title must contain no more than 500 characters",
            default => null
        };
    }
}
