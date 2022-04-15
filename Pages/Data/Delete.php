<?php
namespace Pages\Data;


use Core\Request;
use function Extend\layoutResponseFactory as Page;
use function Extend\redirect;
use Core\RequestMethods\GET;
use Core\RequestMethods\POST;


class Delete
{

    #[GET]
    public static function list()
    {
        return Page("data/list.html");
    }

}
