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


class Edit
{

    #[GET]
    public static function get()
    {
        $delivery = self::get_delivery();
        if($delivery == null)
        {
            return redirect("/list?missing_item=1");
        }
        $response = self::generate_page($delivery);

        if(isset($_GET["success"]))
        {
            $msg = "Доставката беше редактирана успешно.";
            $response->setValue("success_msg", $msg);
        }
        return $response;
    }

    private static function get_delivery() : ?Delivery
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

    private static function generate_page($delivery)
    {
        $response = Page("data/edit.html");

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

        $response->setValue("next", "/edit?id="
                             . $delivery->getId());

        return $response;
    }

    #[POST]
    public static function edit()
    {
        $delivery = self::get_delivery();
        if($delivery == null)
        {
            return redirect("/list?missing_item=1");
        }
        $response = self::generate_page($delivery);


        $criteria = [
            "name" => ["Името трябва да съдържа между 3 и 60 символа.", 80, 3],
            "unit_type" => ["Мерната единица трябва да съдържа между 1 и 30 символа.", 30, 1],
            "unit_price" => ["Цената трябва да е неотрицателно число", null, 0],
            "quantity" => ["Количеството трябва е положително цяло число.", null, 1],
            "deliver" => ["Полето Доставчик трябва да съдържа поне 5 символа.", null, 5],
            "date" => ["Датата не може да е след днешната дата", new DateTime("now"), null],
        ];
        $strings = ["name", "unit_type", "deliver"];
        $output = [];

        foreach($criteria as $field => $stuff)
        {
            $msg = $stuff[0];
            $max = $stuff[1];
            $min = $stuff[2];
            $data =& $_POST[$field];
            $fine = true;

            if(in_array($field, $strings))
            {
                if(!isValidString($data, $min)
                   || (isset($max)
                       && mb_strlen(trim($data)) > $max))
                {
                    $fine = false;
                }
                else
                {
                    $data = trim($data);
                }
            }
            else if(isset($data))
            {
                if("date" == $field)
                {
                    $data = DateTime::createFromFormat
                        ('Y-m-d', $data);
                    if(!$data)
                    {
                        $fine = false;
                    }
                }
                else if(!is_numeric($data))
                {
                    $fine = false;
                }
                else
                {
                    $data = floatval($data);
                }

                if(isset($min) && $data < $min)
                    $fine = false;

                if(isset($max) && $data > $max)
                    $fine = false;

            }
            else
            {
                $fine = false;
            }

            if(!$fine)
            {
                $place = "${field}_msg";
                $response->setValue($place, $msg);
            }
            else
            {
                $output[$field] = $data;
            }
        }

        if($fine)
        {
            foreach($output as $key => $val)
                $delivery->$key = $val;
            $delivery->save();

            return redirect("/edit?success=1&id="
                             . $delivery->getId());
        }

        return $response;
    }
}
