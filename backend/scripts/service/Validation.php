<?php

namespace Palmo\Core\service;

use Palmo\Core\validation\ValidateConfirmPassword;
use Palmo\Core\validation\ValidateDate;
use Palmo\Core\validation\ValidateEmail;
use Palmo\Core\validation\ValidatePassword;
use Palmo\Core\validation\ValidateRules;
use Palmo\Core\validation\ValidateUsername;
use Palmo\Core\validation\ValidateTitle;
use Palmo\Core\validation\ValidateGenres;
use Palmo\Core\validation\ValidateAbout;
use Palmo\Core\validation\ValidateImage;


class Validation
{
    static function validate($type, $data)
    {
        return match ($type) {
            'email' => ValidateEmail::validate($data),
            'password' => ValidatePassword::validate($data),
            'username' => ValidateUsername::validate($data),
            'rules' => ValidateRules::validate($data),
            'confirmPassword' => ValidateConfirmPassword::validate($data),
            'date' => ValidateDate::validate($data),
            'title' => ValidateTitle::validate($data),
            'about' => ValidateAbout::validate($data),
            'genres' => ValidateGenres::validate($data),
            'image' => ValidateImage::validate($data),
            default => null,
        };
    }
}
