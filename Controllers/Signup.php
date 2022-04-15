<?php
namespace Controllers;

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



class Signup
{

    #[GET]
    public static function index()
    {
        $response = Page("signup.html");

        return $response;
    }

    #[POST]
    public static function signup()
    {
        //return redirect("/login?next=/user");
        $response = Page("signup.html");
        $name =& $_POST["name"];
        $pwd =& $_POST["pwd"];
        $pwd2 =& $_POST["pwd2"];

        if($pwd != $pwd2)
        {
            $msg = "Паролите не съвпадат!";
            $response->setValue("pwd2_msg", $msg);
            return $response;
        }

        if(!isValidString($name, 3) || strlen($name) > 24)
        {
            $msg = <<<EOL
                Невалидно потребителско име.
                Името трябва да е с дължина
                 между 3 и 24 символа.
            EOL;
            $response->setValue("name_msg", $msg);
            return $response;
        }

        if(!isValidString($pwd, 6))
        {
            $msg = <<<EOL
                Невалидна парола.
                Паролата трябва да съдържа поне 6 символа.
            EOL;
            $response->setValue("pwd_msg", $msg);
            return $response;
        }

        $name = trim($_POST["name"]);
        $pwd = trim($_POST["pwd"]);

        if(User::exists($name))
        {
            $msg = <<<EOL
                Вече съществува потребител с това име.
            EOL;
            $response->setValue("error_msg", $msg);
            return $response;
        }

        $user = new User($name, $pwd);

        return redirect("/login?new_user");
    }
}
