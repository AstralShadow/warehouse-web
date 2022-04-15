<?php

namespace Extend;

use Core\Responses\TemplateResponse;
use Models\User;


function layoutResponseFactory(string $file,
                               int $code = 200)
{
    if($file == "errors/404.html" && $code == 200)
        $code = 404;

    $response = new TemplateResponse
        (file: "shared/_layout.html", code: $code);

    $user = User::fromSession();
    $menu = "anon";
    if(isset($user))
    {
        $menu = "admin" == $user->name ? "admin" : "user";
        $response->setValue("_user", $user->name);
    }
    $response->setValue("_user_menu",
                        "shared/_${menu}_menu.html");

    $response->setValue("shared/_page", $file);

    return $response;
}

