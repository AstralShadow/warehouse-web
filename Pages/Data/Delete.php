<?php
namespace Pages\Data;


use Core\Request;
use function Extend\layoutResponseFactory as Page;
use function Extend\redirect;
use function Extend\isValidString;
use Core\RequestMethods\GET;
use Core\RequestMethods\POST;
use \DateTime;

use \Models\Delivery;


class Delete
{

    const MARK_AS_DELETED = true;

    private static function getDelivery() : ?Delivery
    {
        $id =& $_GET["id"];
        if(!isset($id))
            return null;
        if(!is_numeric($id) || !intval($id))
            return null;
        
        $id = intval($id);
        $item = Delivery::get($id);
        if(isset($item->deleted))
            return null;

        return $item;
    }

    private static function generatePage($delivery)
    {
        $response = Page("data/delete.html");

        $keys = [
            "name", "unit_type", "unit_price",
            "quantity", "deliver", "date"
        ];
        foreach($keys as $key)
        {
            $val = $delivery->$key;
            if($val instanceof \DateTime)
            {
                $val = $val->format("Y-m-d");
            }
            $response->setValue($key, $val);
        }

        return $response;
    }


    #[GET]
    public static function get()
    {
        $delivery = self::getDelivery();
        if($delivery == null)
        {
            return redirect("/list?missing_item=1");
        }
        $response = self::generatePage($delivery);

        return $response;
    }

    #[POST]
    public static function delete()
    {
        $delivery = self::getDelivery();
        if($delivery == null)
        {
            return redirect("/list?missing_item=1");
        }
        $response = self::generatePage($delivery);

        $fine = true;

        if($fine)
        {
            if(self::MARK_AS_DELETED)
            {
                $delivery->deleted = new DateTime();
                $delivery->save();
            }
            else
            {
                Delivery::delete($delivery);
            }
            return redirect("/list?deleted_item=1");
        }

        return $response;
    }
}
