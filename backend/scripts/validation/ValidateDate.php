<?php

namespace Palmo\Core\validation;

use Palmo\Core\service\ValidationRules;

class ValidateDate implements ValidationRules
{
    use CommonValidation;

    public static function validate($data)
    {
        return  match (false) {
            self::validateEmpty($data) => "Date is required",
            self::validateDateFormat($data, 'Y-m-d') => "Date format is not correct",
            default => null
        };
    }
}
