<?php

namespace Palmo\Core\validation;

use Palmo\Core\service\ValidationRules;

class ValidateImage implements ValidationRules
{
    use CommonValidation;

    public static function validate($data)
    {
        return match (false) {
            self::validateisFile($data) => 'the file is corrupted',
            self::validateMaxSizeFile($data, 30000) => "Size too large 30 Mb",
            self::validateMinSizeFile($data, 100) => "Size too small 100 b",
            self::validateTypeFile($data, ['image/jpeg']) => 'Invalid file type (jpeg,jpg)',
            self::validateFileMinHeight($data, 350) => 'the image is too small in height',
            self::validateFileMinWidth($data, 250) => 'the image is too small in width',
            default => null
        };
    }
}
