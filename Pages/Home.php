<?php
namespace Pages;

use Core\Request;
use function Extend\layoutResponseFactory as Page;
use function Extend\redirect;
use Core\RequestMethods\GET;
use Core\RequestMethods\PUT;
use Core\RequestMethods\POST;
use Core\RequestMethods\DELETE;
use Core\RequestMethods\Fallback;
use Core\RequestMethods\StartUp;

use Models\User;


class Home
{

    #[GET]
    public static function index()
    {
        if(!DATABASE_ONLINE)
            return Page("help/installation.html");

        $user = User::fromSession();
        if(isset($user))
        {
            if($user->name == "admin")
                return Page("help/admin.html");
            else
                return Page("help/usage.html");
        }
        else
            return Page("help/users.html");
    }

    #[Fallback]
    public static function notFound()
    {
        return Page("errors/404.html");
    }

}
