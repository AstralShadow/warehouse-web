<?php
namespace Controllers;

use Core\Request;
use function Extend\layoutResponseFactory as Page;
use function Extend\redirect;
use Core\RequestMethods\GET;
use Core\RequestMethods\PUT;
use Core\RequestMethods\POST;
use Core\RequestMethods\DELETE;
use Core\RequestMethods\Fallback;
use Core\RequestMethods\StartUp;


class ServerOffline
{

    #[Fallback]
    public static function notFound()
    {
        return Page("503.html", 503);
    }

}
