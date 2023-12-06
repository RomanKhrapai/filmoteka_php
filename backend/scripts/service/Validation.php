<?php

namespace Palmo\Core\service;

interface ValidationRules
{
    public static function validate($data);
}
class Validation
{
    static function validate($type, $data)
    {
        switch ($type) { //todo match
            case 'email':
                $error = ValidateEmail::validate($data);
                break;
            case 'password':
                $error = ValidatePassword::validate($data);
                break;
            case 'username':
                $error = ValidateUsername::validate($data);
                break;
            case 'rules':
                $error = ValidateRules::validate($data);
                break;
            case 'confirmPassword':
                $error = ValidateConfirmPassword::validate($data);
                break;
                // case 'date':
                //     $error = ValidateDate::validate($data);
                //     break;
            default:
                $error = null;
                break;
        }
        return $error;
    }
}

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
}

trait CyrillicValidation
{
    public static function validateMinLength($data, $minLength)
    {
        return mb_strlen($data) > $minLength;
    }

    public static function validateMaxLength($data, $maxLength)
    {
        return mb_strlen($data) < $maxLength;
    }
}

class ValidateEmail implements ValidationRules
{

    use CommonValidation;


    public static function validate($data)
    {
        $result = match (false) {
            self::validateEmail($data) => "Invalid email format",
            self::validateEmpty($data) => "Email is required",
            default => null
        };

        return $result;
    }

    private static function validateEmail($data)
    {
        if (filter_var($data, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
}

class ValidatePassword implements ValidationRules
{
    use CommonValidation;

    public static function validate($data)
    {
        $result = match (false) {
            self::validateMinLength($data, 6) => "Password must contain at least 6 characters",
            self::validateMaxLength($data, 30) => "Password must contain no more than 30 characters",
            default => null
        };

        return $result;
    }
}

class ValidateUsername implements ValidationRules
{
    use CommonValidation, CyrillicValidation {
        CyrillicValidation::validateMinLength insteadof CommonValidation;
        CyrillicValidation::validateMaxLength insteadof CommonValidation;
    }

    public static function validate($data)
    {
        $result = match (false) {
            self::validateEmpty($data) => "Username is required",
            self::validateMinLength($data, 3) => "Username must contain at least 3 characters",
            self::validateMaxLength($data, 30) => "Username must contain no more than 30 characters",
            default => null
        };

        return $result;
    }
}

class ValidateRules implements ValidationRules
{
    use CommonValidation, CyrillicValidation {
        CyrillicValidation::validateMinLength insteadof CommonValidation;
        CyrillicValidation::validateMaxLength insteadof CommonValidation;
    }

    public static function validate($data)
    {
        $result = match (false) {
            self::validateIsTrue($data) => "The rules are not accepted",
            default => null
        };

        return $result;
    }
}

class ValidateConfirmPassword implements ValidationRules
{
    use CommonValidation, CyrillicValidation {
        CyrillicValidation::validateMinLength insteadof CommonValidation;
        CyrillicValidation::validateMaxLength insteadof CommonValidation;
    }

    public static function validate($data)
    {
        $result = match (false) {
            self::validateIsSame($data) => "Passwords are not the same",
            default => null
        };

        return $result;
    }
}

// class ValidateDate implements ValidationRules
// {
//     use CommonValidation;

//     public static function validate($data)
//     {
//         $result = match (false) {
//             self::validateEmpty($data) => "Date is required",
//             default => null
//         };

//         return $result;
//     }

//     static function validateDateFormat($data)
//     {
//         return date_create_from_format('Y-m-d', $data);
//     }
// }

// class ValidateEndDate extends ValidateDate
// {
//     use CommonValidation;

//     public static function validate($data)
//     {
//         $result = match (false) {
//             self::validateEmpty($data) => "Date is required",
//             default => null
//         };

//         return $result;
//     }

//     static function validateEndDate($startDate, $endDate)
//     {
//         return date_create_from_format('Y-m-d', $startDate);
//     }
// }
