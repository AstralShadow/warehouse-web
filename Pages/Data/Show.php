<?php
namespace Pages\Data;

use Core\Request;
use function Extend\layoutResponseFactory as Page;
use function Extend\redirect;
use Core\Responses\ApiResponse;
use Core\RequestMethods\GET;
use Core\RequestMethods\POST;

use Models\Delivery;


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

        if(isset($_GET["edit_success"]))
        {
            $msg = "Вие успешно редактирахте доставката.";
            $page->setValue("success_msg", $msg);
        }

        return $page;
    }

    #[GET]
    public static function list()
    {
        return self::generatePage();
    }

    #[GET("/data")]
    public static function data($req)
    {
        $search;

        $query = [];

        $collection = Delivery::find($query);
        $result = [];
        foreach($collection as $item)
        {
            if($item->deleted) continue;

            $result[] = $item->apiData();
        }

        return self::json($result);
    }

    public static function json($data, $code = 200)
    {
        $result = new ApiResponse($code);
        $result->echo($data);
        return $result;
    }

    public static function jsonError($error, $code = 400)
    {
        return self::json(["error" => $error], $code);
    }

}
