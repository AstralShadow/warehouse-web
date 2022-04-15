<?php

/* Extend съдържа методи и инструменти, които все още
 * не съм добавил в рамката */
include "Extend/layoutResponseFactory.php";
include "Extend/redirect.php";
include "Extend/setCookie.php";
include "Extend/isValidString.php";
include "Extend/CSRFTokenManager.php";
include "Extend/generateToken.php";


/* Позволява автоматично зареждане
 * на класове по тяхното име */
include "Core/autoload.php";

/* Използван при задаване на рутирането */
use Models\User;


/* MySQL сървър */
$mysql = [
    "path" => "mysql:host=localhost;dbname=2022_04_c_sharp_competition",
    "name" => "c_sharp_competition",
    "pwd" => "94b53710-fc61-43d0-b43b-abc091b59b6c"
];


/* Проверка за състоянието на MySQL сървъра*/
$mysql["online"] = true;/* to be added*/


/* Инициализация на рамката */
$router = new Core\Router();
$app = new Core\Controller($router);
if($mysql["online"])
{
    /* Връзка с базата данни */
    $app->usePDO($mysql["path"],
                 $mysql["name"], $mysql["pwd"]);

    /* Създава администраторски профил
     * Този потребител може да регистрира
     * други потребители.
     */
    $admin = User::findByName("admin");
    if(!isset($admin))
    {
        new User("admin", "admin");
    }
    unset($admin);
}


/* Дефиниция на routing таблицата.
 * Следва формата контролер => адрес */
$router->add("Pages\Home", "/");
if($mysql["online"])
{
    $user = User::fromSession();
    if(isset($user))
    {
        $router->add("Pages\Forbidden", "/login");
        if("admin" == $user->name)
        {
            $router->add("Pages\User\Signup", "/signup");
        }
        else
        {
            $router->add("Pages\Forbidden",
                         "/signup");
        }
        $router->add("Pages\User\Logout", "/logout");
        $router->add("Pages\User\Profile", "/profile");
    }
    else
    {
        $router->add("Pages\User\Login", "/login");
        $router->add("Pages\Forbidden", "/signup");
        $router->add("Pages\RedirectToLogin",
                     "/profile");
        $router->add("Pages\RedirectToLogin",
                     "/logout");
    }
}
else
{
    $router->add("Pages\ServerOffline", "/login");
    $router->add("Pages\ServerOffline", "/signup");
}



/* Стартиране на рамката */
$app->run();

