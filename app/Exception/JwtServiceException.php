<?php

namespace App\Exception;

use Exception;

class JwtServiceException extends Exception
{
    public static function cannotDecode()
    {
        return new static("Cannot decode the JWT token.");
    }
}