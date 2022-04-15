<?php
namespace Controllers;

use Core\Request;
use function Extend\layoutResponseFactory as Page;
use function Extend\redirect;
use Core\RequestMethods\GET;
use Core\RequestMethods\PUT;
use Core\RequestMethods\POST;
use Core\RequestMethods\DELETE;
use Core\RequestMethods\Fallback;
use Core\RequestMethods\StartUp;


class Login
{

    #[GET]
    public static function index()
    {
        //return redirect("/login?next=/user");
        $response = Page("login.html");

        return $response;
    }

    #[POST]
    public static function login()
    {
        $response = Page("login.html");

        var_dump($_POST);

        return $response;
    }
}
