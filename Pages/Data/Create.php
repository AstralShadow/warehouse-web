<?php
namespace Pages\Data;


use Core\Request;
use function Extend\layoutResponseFactory as Page;
use function Extend\redirect;
use Core\RequestMethods\GET;
use Core\RequestMethods\PUT;
use Core\RequestMethods\POST;
use Core\RequestMethods\DELETE;
use Core\RequestMethods\Fallback;
use Core\RequestMethods\StartUp;


class Create
{

    #[GET]
    public static function get()
    {
        return Page("data/create.html");
    }

    #[POST]
    public static function add()
    {
        var_dump($_POST);
        return Page("data/create.html");
    }

}
