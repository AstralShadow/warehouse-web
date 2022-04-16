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


class Show
{

    private static function generatePage()
    {
        $page = Page("data/list.html");

        if(isset($_GET["missing_item"]))
        {
            $msg = "Доставката не е намерена.";
            $page->setValue("error_msg", $msg);
        }
        
        if(isset($_GET["deleted_item"]))
        {
            $msg = "Вие успешно изтрихте доставката.";
            $page->setValue("success_msg", $msg);
        }

        return $page;
    }

    #[GET]
    public static function list()
    {
        return self::generatePage();
    }

    #[GET("api/")]
    public static function data($req)
    {
        $result = self::generatePage();
        $page = intval($_GET["p"] ?? 1);
        $search;

        return $result;
    }

}
