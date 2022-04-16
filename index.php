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


/* Инициализация на рамката */
$router = new Core\Router();
$app = new Core\Controller($router);
/* Връзка с базата данни */
$app->usePDO($mysql["path"],
             $mysql["name"], $mysql["pwd"]);


/* Проверка за състоянието на MySQL сървъра*/
try
{
    $app->initPDO();
    define("DATABASE_ONLINE", true);
} catch(PDOException $e)
{
    define("DATABASE_ONLINE", false);
}


if(DATABASE_ONLINE)
{

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
 * Следва формат "контролер => адрес" */
$router->add("Pages\Home", "/");
if(DATABASE_ONLINE)
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
            $router->add("Pages\Forbidden", "/signup");
        }
        $router->add("Pages\User\Logout", "/logout");
        $router->add("Pages\User\Profile", "/profile");
        $router->add("Pages\Data\Create", "/new");
        $router->add("Pages\Data\Show", "/list");
        $router->add("Pages\Data\Edit", "/edit");
        $router->add("Pages\Data\Delete", "/delete");
    }
    else
    {
        $router->add("Pages\User\Login", "/login");
        $router->add("Pages\Forbidden", "/signup");
        $router->add("Pages\RedirectToLogin", "/profile");
        $router->add("Pages\RedirectToLogin", "/logout");
    }
}
else
{
    $router->add("Pages\ServerOffline", "/login");
    $router->add("Pages\ServerOffline", "/signup");
}



/* Стартиране на рамката */
$app->run();

