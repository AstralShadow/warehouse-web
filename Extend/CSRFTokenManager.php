<?php
namespace Extend;

use function Extend\generateToken;
use function Extend\isValidString;


// Uses double submit technique.
class CSRFTokenManager
{
    const TOKEN_COOKIE = "LearningResourcesCSRFToken";

    private static bool $valid;
    private static string $token;

    public static function check() : bool
    {
        if(isset(self::$valid))
            return self::$valid;

        self::$valid = false;
        if(isValidString($_POST["csrf"], 42))
        {
            $cookie = $_COOKIE[self::TOKEN_COOKIE];
            self::$valid = $_POST["csrf"] == $cookie;
        }

        return self::$valid;
    }

    public static function get() : string
    {
        self::check();

        if(!isset(self::$token))
        {
            self::$token = generateToken(42);
            setCookie(self::TOKEN_COOKIE, self::$token);
        }

        return self::$token;
    }
    

}
