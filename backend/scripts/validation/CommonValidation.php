<?php

namespace Palmo\Core\validation;

trait CommonValidation
{
    public static function validateEmpty($data)
    {
        return !empty($data);
    }

    public static function validateIsTrue($data)
    {
        return $data;
    }
    public static function validateIsSame($data)
    {
        return $data[0] === $data[1];
    }

    public static function validateMinLength($data, $minLength)
    {
        return strlen($data) >= $minLength;
    }

    public static function validateMaxLength($data, $maxLength)
    {
        return strlen($data) <= $maxLength;
    }

    public static function validateMaxSizeFile($data, $maxSize)
    {
        return $data['size'] <= $maxSize;
    }
    public static function validateMinSizeFile($data, $minSize)
    {

        return $data['size'] >= $minSize;
    }
    public static function validateTypeFile($data, $typeArray)
    {
        return in_array($data['type'], $typeArray);
    }
    public static function validateisFile($data)
    {
        return  is_uploaded_file($data['tmp_name'] ?? null);
    }
    public static function validateFileMinHeight($data, $minSize)
    {
        $height = getimagesize($data['tmp_name'])[1];
        return  $height > $minSize;
    }
    public static function validateFileMinWidth($data, $minSize)
    {
        $width = getimagesize($data['tmp_name'])[0];
        return     $width > $minSize;
    }
    public static function validateisArray($data)
    {
        return  is_array($data);
    }
    public static function validateisEmptyArray($data)
    {
        return !empty($data);
    }
    public static function validateisItemArrayNumber($data)
    {
        foreach ($data as $item) {
            if (ctype_digit($item)) {
                return true;
            };
        }
        return false;
    }

    static function validateDateFormat($data, $format)
    {
        return date_create_from_format($format, $data);
    }
}
