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


class Create
{

    #[GET]
    public static function get()
    {
        $response = Page("data/create.html");

        if(isset($_GET["success"]))
        {
            $msg = "Доставката беше успешно записана.";
            $response->setValue("success_msg", $msg);
        }
        return $response;
    }

    #[POST]
    public static function add()
    {
        $response = Page("data/create.html");

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

        $fine = true;
        foreach($criteria as $field => $stuff)
        {
            $msg = $stuff[0];
            $max = $stuff[1];
            $min = $stuff[2];
            $data =& $_POST[$field];
            $fine_local = true;

            if(in_array($field, $strings))
            {
                if(!isValidString($data, $min)
                   || (isset($max)
                       && mb_strlen(trim($data)) > $max))
                {
                    $fine_local = false;
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
                        $fine_local = false;
                    }
                }
                else if(!is_numeric($data))
                {
                    $fine_local = false;
                }
                else
                {
                    $data = floatval($data);
                }

                if(isset($min) && $data < $min)
                    $fine_local = false;

                if(isset($max) && $data > $max)
                    $fine_local = false;

            }
            else
            {
                $fine_local = false;
            }

            if(!$fine_local)
            {
                $response->setValue("${field}_msg", $msg);
                $fine = false;
            }
            else
            {
                $output[$field] = $data;
            }
        }

        if($fine)
        {
            $delivery = new Delivery($output);
            return redirect("/new?success=1");
        }

        return $response;
    }
}
