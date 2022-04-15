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

class Login
{

    #[GET]
    public static function index()
    {
        return Page("user/login.html");
    }

    #[POST]
    public static function login()
    {
        $response = Page("user/login.html");

        $name =& $_POST["name"];
        $pwd =& $_POST["pwd"];
        
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

        if(!isValidString($pwd, 2))
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

        
        if(false && !User::exists($name))
        {
            $msg = <<<EOL
                Не съществува потребител с това име.
            EOL;
            $response->setValue("error_msg", $msg);
            return $response;
        }

        $user = User::login($name, $pwd);
        if(!isset($user))
        {
            $msg = <<<EOL
                Грешно име или парола.
            EOL;
            $response->setValue("error_msg", $msg);
            return $response;
        }

        $user->ToSession();

        return redirect("/");
    }
}
