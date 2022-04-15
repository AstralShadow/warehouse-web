<?php
namespace Pages\User;

use Core\Request;
use function Extend\layoutResponseFactory as Page;
use function Extend\redirect;
use function Extend\isValidString;
use Core\RequestMethods\GET;
use Core\RequestMethods\PUT;
use Core\RequestMethods\POST;
use Core\RequestMethods\DELETE;
use Core\RequestMethods\Fallback;
use Core\RequestMethods\StartUp;

use Models\User;

class Logout
{

    #[GET]
    public static function get()
    {
        User::clearSession();
        return redirect("/login");
    }

    #[POST]
    public static function post()
    {
        User::clearSession();
        return redirect("/login");
    }
}
