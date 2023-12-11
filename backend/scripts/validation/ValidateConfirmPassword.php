<?php

namespace Palmo\Core\validation;

use Palmo\Core\service\ValidationRules;

class ValidateConfirmPassword implements ValidationRules
{
    use CommonValidation, CyrillicValidation {
        CyrillicValidation::validateMinLength insteadof CommonValidation;
        CyrillicValidation::validateMaxLength insteadof CommonValidation;
    }

    public static function validate($data)
    {
        return  match (false) {
            self::validateIsSame($data) => "Passwords are not the same",
            default => null
        };
    }
}
