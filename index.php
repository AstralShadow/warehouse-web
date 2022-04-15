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


/* MySQL сървър */
$mysql = [
    "path" => "mysql:host=localhost;dbname=2022_04_c_sharp_competition",
    "name" => "c_sharp_competition",
    "pwd" => "94b53710-fc61-43d0-b43b-abc091b59b6c"
];


/* Проверка за състоянието на MySQL сървъра*/

$mysql["online"] = true;/* to be added*/



if($mysql["online"])
{
    /* Дефиниция на routing таблицата.
     * Следва формата контролер => адрес */
    $router = new Core\Router();
    $router->add("Controllers\Home", "/");


    /* Инициализация на рамката */
    $app = new Core\Controller($router);

    /* Връзка с базата данни */
    $app->usePDO($mysql["path"],
                 $mysql["name"], $mysql["pwd"]);

    /* Стартиране на рамката */
    $app->run();
}
else
{
    /* Дефиниция на routing таблицата.
     * Следва формата контролер => адрес */
    $router = new Core\Router();
    $router->add("Controllers\Home", "/");


    /* Стартиране на рамката */
    $app = new Core\Controller($router);

    /* Връзка с базата данни */
    $app->usePDO($mysql["path"],
                 $mysql["name"], $mysql["pwd"]);

    $app->run();
}
