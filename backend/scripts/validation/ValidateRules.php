<?php

namespace Palmo\Core\validation;

use Palmo\Core\service\ValidationRules;

class ValidateRules implements ValidationRules
{
    use CommonValidation, CyrillicValidation {
        CyrillicValidation::validateMinLength insteadof CommonValidation;
        CyrillicValidation::validateMaxLength insteadof CommonValidation;
    }

    public static function validate($data)
    {
        return match (false) {
            self::validateIsTrue($data) => "The rules are not accepted",
            default => null
        };
    }
}
