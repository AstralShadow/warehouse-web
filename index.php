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
}


/* Дефиниция на routing таблицата.
 * Следва формата контролер => адрес */
$router->add("Controllers\Home", "/");
if($mysql["online"])
{
    $user = User::fromSession();
    if(isset($user))
    {
        $router->add("Controllers\Forbidden", "/login");
        $router->add("Controllers\Forbidden", "/signup");
        $router->add("Controllers\Logout", "/logout");
        $router->add("Controllers\Profile", "/profile");
    }
    else
    {
        $router->add("Controllers\Login", "/login");
        $router->add("Controllers\Signup", "/signup");
        $router->add("Controllers\RedirectToLogin",
                     "/profile");
        $router->add("Controllers\RedirectToLogin",
                     "/logout");
    }
}
else
{
    $router->add("Controllers\ServerOffline", "/login");
    $router->add("Controllers\ServerOffline", "/signup");
}



/* Стартиране на рамката */
$app->run();

