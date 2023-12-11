<?php

namespace Palmo\Core\validation;

use Palmo\Core\service\ValidationRules;

class ValidateGenres implements ValidationRules
{
    use CommonValidation;

    public static function validate($data)
    {
        return match (false) {
            self::validateisArray($data) => "Wrong data type",
            self::validateisEmptyArray($data) => "No genre selected",
            self::validateisItemArrayNumber($data) => "Item is not number",
            default => null
        };
    }
}
