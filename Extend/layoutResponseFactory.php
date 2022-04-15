<?php

namespace Extend;

use Core\Responses\TemplateResponse;
use Models\User;


function layoutResponseFactory(string $file,
                               int $code = 200)
{
    if($file == "404.html" && $code == 200)
        $code = 404;

    $response = new TemplateResponse
        (file: "_layout.html", code: $code);

    $user = User::fromSession();
    if(isset($user))
    {
        $response->setValue("_user_menu",
                            "_user_menu.html");
    }
    else
    {
        $response->setValue("_user_menu",
                            "_anon_menu.html");
    }

    $response->setValue("_page", $file);

    return $response;
}

