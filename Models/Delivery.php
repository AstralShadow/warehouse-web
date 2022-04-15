<?php
namespace Models;

# Base model for ORM objects
use Core\Entity;

# Specifies table name
use Core\Attributes\Table;

# Specifies primary key
use Core\Attributes\PrimaryKey;



#[Table("Deliveries")]
#[PrimaryKey("id")]
class Delivery extends Entity
{
    public int $id;
    public string $name;

    public string $unit_type;
    public float $unit_price;
    public int $quantity;

    public string $deliver;
    public \DateTime $date;

    /* When creating data. */
    public function __construct(array $data)
    {
        $this->name = $data["name"];

        $this->unit_type = $data["unit_type"];
        $this->unit_price = $data["unit_price"];
        $this->quantity = $data["quantity"];

        $this->deliver = $data["deliver"];
        $this->date = $data["date"];

        parent::__construct();
    }

}

