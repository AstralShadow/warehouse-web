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

class Profile
{

    #[GET]
    public static function get()
    {
        $response = Page("user/profile.html");

        return $response;
    }

    #[POST]
    public static function post()
    {
        $response = Page("user/profile.html");

        $old =& $_POST["old_pwd"];
        $new =& $_POST["new_pwd"];
        $new2 =& $_POST["new_pwd2"];

        if($new != $new2)
        {
            $msg = "Паролите не съвпадат!";
            $response->setValue("new2_msg", $msg);
            return $response;
        }
        
        if(!isValidString($old, 6))
        {
            $msg = <<<EOL
                Невалидна парола.
                Паролата трябва да съдържа поне 6 символа.
            EOL;
            $response->setValue("old_msg", $msg);
            return $response;
        }
        if(!isValidString($new, 6))
        {
            $msg = <<<EOL
                Невалидна парола.
                Паролата трябва да съдържа поне 6 символа.
            EOL;
            $response->setValue("new_msg", $msg);
            return $response;
        }

        $old = trim($_POST["old_pwd"]);
        $new = trim($_POST["new_pwd"]);

        
        $user = User::fromSession();
        if($user->changePassword($old, $new))
        {
            $msg = <<<EOL
                Паролата беше сменена успешно.
            EOL;
            $response->setValue("success_msd", $msg);
            return $response;
        }
        else
        {
            $msg = <<<EOL
                Грешна парола.
            EOL;
            $response->setValue("error_msg", $msg);
            return $response;
        }

        return redirect("/");
    }
}
