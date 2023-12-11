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
            default => null
        };
    }

    static function validateDateFormat($data)
    {
        return date_create_from_format('Y-m-d', $data);
    }
}
